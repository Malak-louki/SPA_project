<?php

namespace App\Controller;

use App\Repository\AnnouncementRepository;
use App\Repository\DogRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ListAnnouncementController extends AbstractController
{
    #[Route('/list', name: 'app_list_announcement')]
    public function listAnnouncement(AnnouncementRepository $announcementRepository): Response
    { //, DogRepository $dogRepository

        $annonces = $announcementRepository->groupByAnnouncement();
        // $group = $dogRepository->groupByDogs();


        return $this->render('list_announcement/list_announcement.html.twig', [
            'annonces' => $annonces,
            // 'group' => $group,
        ]);
    }
}