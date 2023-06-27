<?php

namespace App\Controller;

use App\Entity\Announcer;
use App\Repository\AnnouncementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AnnouncerController extends AbstractController
{
    #[Route('/annonceur/gestion', name: 'announcer_announcement_management')]
    public function announcementManagement(AnnouncementRepository $announcementRepository, ?Announcer $announcer): Response
    {
        /** @var ?Announcer */
        $announcer = $this->getUser();
        $announcements = $announcementRepository->findForAnnouncerManagement($announcer);

        return $this->render('announcer/announcementManagement.html.twig', [
            'announcements' => $announcements,
        ]);
    }
}
