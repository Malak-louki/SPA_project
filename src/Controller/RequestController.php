<?php

namespace App\Controller;

use App\Entity\Adopter;
use App\Entity\Announcement;
use App\Entity\Announcer;
use App\Entity\Conversation;
use App\Entity\Request;
use App\Form\ConversationType;
use App\Form\FirstRequestType;
use App\Repository\ConversationRepository;
use App\Repository\RequestRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request as HttpRequest;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class RequestController extends AbstractController
{
    #[IsGranted('ROLE_ADOPTER')]
    #[Route('/adoptant/premier-contact/{id}', name: 'request_new', requirements: ['id' => "\d+"])]
    public function new(
        HttpRequest $request,
        Announcement $announcement,
        RequestRepository $requestRepository
    ): Response {
        /** @var Adopter */
        $user = $this->getUser();

        $requests = $requestRepository->getIsFirstRequest($user, $announcement);
        if (count($requests) > 0) {
            $this->addFlash('warning', 'Vous avez déjà postulé à cette annonce');

            return $this->redirectToRoute('announcement_show', ['id' => $announcement->getId()]);
        }

        $firstRequest = new Request();
        $firstRequest->setAdopter($user);
        $firstRequest->setAnnouncement($announcement);

        $conversation = (new Conversation())
            ->setIsAnnouncer(false);
        $firstRequest->addConversation($conversation);

        $form = $this->createForm(FirstRequestType::class, $firstRequest, [
            'method' => 'POST',
            'announcement' => $announcement,
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $requestRepository->save($firstRequest, true);
            $this->addFlash('success', 'Votre message a été envoyé.');

            return $this->redirectToRoute('announcement_show', ['id' => $announcement->getId()]);
        }

        return $this->render('request/new.html.twig', [
            'form' => $form->createView(),
            'announcement' => $announcement,
        ]);
    }

    #[IsGranted('ROLE_USER')]
    #[Route('/fil-conversation/{id}', name: 'request_reply', requirements: ['id' => "\d+"])]
    public function reply(
        HttpRequest $request,
        ConversationRepository $conversationRepository,
        Request $requestReply,
        EntityManagerInterface $entityManager
    ): Response {
        $user = $this->getUser();
        // Retriction d'accès
        if ($user instanceof Adopter && $user != $requestReply->getAdopter()) {
            throw new AccessDeniedHttpException("Vous n'avez pas les droits pour accèder
            à cette page.");
        }
        if ($user instanceof Announcer && $user != $requestReply->getAnnouncement()->getAnnouncer()) {
            throw new AccessDeniedHttpException("Vous n'avez pas les droits pour accèder
            à cette page.");
        }
        // Envoi en BdD si conversation lu
        foreach ($requestReply->getConversations() as $conversation) {
            if (
                (!$conversation->getIsAnnouncer() and $user instanceof Announcer)
                or ($conversation->getIsAnnouncer() and $user instanceof Adopter)
            ) {
                $conversation->setIsRead(true);

                $conversationRepository->save($conversation, true);
            }
        }

        $conversation = (new Conversation())
            ->setIsAnnouncer($user instanceof Announcer)
            ->setRequest($requestReply)
        ;

        $form = $this->createForm(ConversationType::class, $conversation);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $conversationRepository->save($conversation, true);
            $requestReply->setUpdatedAt(new \DateTimeImmutable());

            $entityManager->persist($requestReply);
            $entityManager->flush();

            $this->addFlash('success', 'Votre message a été envoyé.');

            return $this->redirectToRoute('request_reply', ['id' => $requestReply->getId()]);
        }

        return $this->render('request/reply.html.twig', [
            'form' => $form->createView(),
            'requestReply' => $requestReply,
            'adopter' => $requestReply->getAdopter(),
            'announcement' => $requestReply->getAnnouncement(),
            'conversations' => $requestReply->getConversations(),
            'dogs' => $requestReply->getDogs(),
            'user' => $user,
        ]);
    }
}
