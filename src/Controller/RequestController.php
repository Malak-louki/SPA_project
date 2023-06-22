<?php

namespace App\Controller;

use App\Entity\Announcement;
use App\Entity\Conversation;
use App\Entity\Request;
use App\Form\FirstRequestType;
use App\Repository\RequestRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request as HttpRequest;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class RequestController extends AbstractController
{
    #[IsGranted('ROLE_ADOPTER')]
    #[Route('/adoptant/premier-contact/{id}', name: 'request_new', requirements: ["id" => "\d+"])]
    public function new(
        HttpRequest $request,
        Announcement $annonce,
        RequestRepository $requestRepository
    ): Response {

        $firstRequest = new Request();
        $firstRequest->setAdopter($this->getUser());
        $firstRequest->setAnnouncement($annonce);

        $conversation = (new Conversation())
            ->setIsAnnouncer(false);
        $firstRequest->addConversation($conversation);


        $form = $this->createForm(FirstRequestType::class, $firstRequest, [
            'method' => 'POST',
            'announcement' => $annonce,
            // 'action' => $this->generateUrl('tag_new'), // des options du formulaire (optionnelles)
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $requestRepository->save($firstRequest, true);
            $this->addFlash('success', 'Votre message a été envoyé.');
            return $this->redirectToRoute('app_annonce', ['id' => $annonce->getId()]);
        }


        return $this->render('request/new.html.twig', [
            'form' => $form->createView(),
            'annonce' => $annonce,
        ]);
    }
}