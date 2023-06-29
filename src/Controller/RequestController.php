<?php

namespace App\Controller;

use App\Entity\Adopter;
use App\Entity\Announcement;
use App\Entity\Conversation;
use App\Entity\Request;
use App\Form\FirstRequestType;
use App\Repository\RequestRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request as HttpRequest;
use Symfony\Component\HttpFoundation\Response;
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
}