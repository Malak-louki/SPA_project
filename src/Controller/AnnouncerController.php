<?php

namespace App\Controller;

use App\Repository\AnnouncementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AnnouncerController extends AbstractController
{
    #[Route('/annonceur/gestion', name: 'announcer_announcement_management')]
    public function announcementManagement(): Response
    {
        return $this->render('announcer/announcementManagement.html.twig', [
            'controller_name' => 'AnnouncerController',
        ]);
    }
}