<?php

namespace App\Controller;

use App\Repository\AnnouncementRepository;
use App\Repository\RequestRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AnnouncementController extends AbstractController
{
    #[Route('/annonce/{id}', name: 'app_annonce', requirements: ["id" => "\d+"])]
    public function announcement(int $id, AnnouncementRepository $repository, RequestRepository $requestRepository): Response
    {
        $annonces = $repository->find($id);

        return $this->render('annonce/announcement.html.twig', [
            'annonces' => $annonces,
            'id' => $id,
            'requests' => $requestRepository,
        ]);
    }
}