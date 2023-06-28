<?php

namespace App\Controller;

use App\Entity\Announcement;
use App\Entity\Announcer;
use App\Form\AddAnnouncementType;
use App\Form\AnnouncementFilterType;
use App\Form\Filter\AnnouncementFilter;
use App\Form\Filter\DogFilterType;
use App\Repository\AnnouncementRepository;
use App\Repository\DogRepository;
use App\Repository\RequestRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class AnnouncementController extends AbstractController
{
    #[Route('/annonce/{id}', name: 'announcement_show', requirements: ['id' => "\d+"])]
    public function show(
        int $id,
        Announcement $announcements,
        AnnouncementRepository $announcementRepository,
        DogRepository $dogRepository,
        Request $request,
        RequestRepository $requestRepository
    ): Response {
        $announcement = $announcementRepository->find($id);

        $filter = new AnnouncementFilter();

        $form = $this->createForm(DogFilterType::class, $filter, [
            'announcement' => $announcement,
        ]);
        $form->handleRequest($request);

        $dogs = $dogRepository->filterDogs($filter, $announcement);

        return $this->render('announcement/announcement.html.twig', [
            'id' => $id,
            'announcement' => $announcement,
            'form' => $form->createView(),
            'dogs' => $dogs,
            'requests' => $requestRepository,
        ]);
    }

    /** --------------------------------------- */
    #[IsGranted('ROLE_ANNOUNCER')]
    #[Route('annonceur/ajout/annonce', name: 'announcement_new')]
    #[Route('annonceur/modification/annonce/{id}', name: 'announcement_modify')]
    public function new(
        Request $request,
        AnnouncementRepository $announcementRepository,
        ?Announcement $announcement
    ): Response {
        /** @var Announcer */
        $user = $this->getUser();

        if (is_null($announcement)) {
            $announcement = new Announcement();
        }

        $announcement->setAnnouncer($user);
        $form = $this->createForm(AddAnnouncementType::class, $announcement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // On enregistre
            $announcement->setUpdatedAt(new \DateTimeImmutable());
            $announcementRepository->save($announcement, true);

            return $this->redirectToRoute('announcement_listAnnouncement');
        }

        $announcement = $announcementRepository->findAll();

        return $this->render('announcement/add_announcement.html.twig', [
            'form' => $form->createView(),
            'announcement' => $announcement,
        ]);
    }

    /**---------------------------------*/

    #[Route('/liste', name: 'announcement_listAnnouncement')]
    public function listAnnouncement(
        Request $request,
        AnnouncementRepository $announcementRepository,
        EntityManagerInterface $entityManager
    ): Response {
        $filter = new AnnouncementFilter();
        $form = $this->createForm(AnnouncementFilterType::class, $filter);
        $form->handleRequest($request);

        $announcements = $announcementRepository->groupByAnnouncement($filter);

        return $this->render('announcement/list_announcement.html.twig', [
            'form' => $form->createView(),
            'announcements' => $announcements,
        ]);
    }
}