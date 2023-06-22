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

class RequestController extends AbstractController
{
    #[Route('/request', name: 'request_index')]
    public function index(): Response
    {
        return $this->render('request/index.html.twig', [
            'controller_name' => 'RequestController',
        ]);
    }

    #[Route('/adoptant/premier-contact/{id}', name: 'request_new', requirements: ["id" => "\d+"])]
    public function new(
        HttpRequest $request,
        Announcement $annonce,
        RequestRepository $requestRepository,
        ?Request $firstRequest = null
    ): Response {

        if (is_null($firstRequest)) {
            $firstRequest = new Request();
            $firstRequest->setAdopter($this->getUser());
            $firstRequest->setAnnouncement($annonce);

            $conversation = new Conversation();
            $firstRequest->addConversation($conversation);
        }

        $form = $this->createForm(FirstRequestType::class, $firstRequest, [
            'method' => 'POST',
            'announcement' => $annonce,
            // 'action' => $this->generateUrl('tag_new'), // des options du formulaire (optionnelles)
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $requestRepository->save($firstRequest, true);
            $this->addFlash('success', 'Votre message a été envoyé.');
            return $this->redirectToRoute('home');
        }


        return $this->render('request/new.html.twig', [
            'form' => $form->createView(),
            'annonce' => $annonce,
        ]);
    }
}