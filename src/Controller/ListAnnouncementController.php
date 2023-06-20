<?php

namespace App\Controller;

use App\Repository\AnnouncementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ListAnnouncementController extends AbstractController
{
    #[Route('/list', name: 'app_list_announcement')]
    public function listAnnouncement(AnnouncementRepository $announcementRepository): Response
    {

        $annonces = $announcementRepository->groupByAnnouncement();


        return $this->render('list_announcement/list_announcement.html.twig', [
            'annonces' => $annonces,
        ]);
    }
}