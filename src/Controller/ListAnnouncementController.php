<?php

namespace App\Controller;

use App\Form\AnnouncementFilterType;
use App\Form\Filter\AnnouncementFilter;
use App\Repository\AnnouncementRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ListAnnouncementController extends AbstractController
{
    #[Route('/liste', name: 'app_list_announcement')]
    public function listAnnouncement(Request $request, AnnouncementRepository $announcementRepository, EntityManagerInterface $entityManager): Response
    {
        $filter = new AnnouncementFilter();
        $form = $this->createForm(AnnouncementFilterType::class, $filter);
        $form->handleRequest($request);

        $announcements = $announcementRepository->groupByAnnouncement($filter);

        return $this->render('list_announcement/list_announcement.html.twig', [
            'announcements' => $announcements,
            'form' => $form->createView(),
        ]);
    }
}