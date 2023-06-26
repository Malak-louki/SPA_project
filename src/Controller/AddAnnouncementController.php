<?php

namespace App\Controller;

use App\Entity\Announcement;
use App\Entity\Announcer;
use App\Form\AddAnnouncementType;
use App\Repository\AnnouncementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class AddAnnouncementController extends AbstractController
{
    #[IsGranted('ROLE_ANNOUNCER')]
    #[Route('annonceur/ajout/annonce', name: 'app_add_announcement')]
    #[Route('annonceur/modification/annonce/{id}', name: 'app_modifier_announcement')]
    public function addAnnouncement(Request $request, AnnouncementRepository $announcementRepository, ?Announcement $announcement): Response
    {
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

            return $this->redirectToRoute('app_list_announcement');
        }

        $annonces = $announcementRepository->findAll();

        return $this->render('add_announcement/add_announcement.html.twig', [
            'form' => $form->createView(),
            'annonces' => $annonces,
        ]);
    }
}
