<?php

namespace App\Controller;

use App\Entity\Announcement;
use App\Entity\Request;
use App\Form\FirstRequestType;
use App\Repository\RequestRepository;
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
    public function new(HttpRequest $request, Announcement $annonce, RequestRepository $requestRepository): Response
    {
        $firstRequest = new Request();
        $firstRequest->setAdopter($this->getUser());
        $firstRequest->setAnnouncement($annonce);



        $form = $this->createForm(FirstRequestType::class, $firstRequest, [
            'method' => 'POST',
            'announcement' => $annonce,
            // 'action' => $this->generateUrl('tag_new'), // des options du formulaire (optionnelles)
        ]);

        // $form->handleRequest($request);

        return $this->render('request/new.html.twig', [
            'form' => $form->createView(),
            'annonce' => $annonce,
        ]);
    }
}