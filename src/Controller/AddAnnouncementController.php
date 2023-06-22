<?php

namespace App\Controller;

use App\Entity\Dog;
use App\Form\AddAnnouncementType;
use App\Form\AddDogFormType;
use App\Repository\AnnouncementRepository;
use App\Entity\Announcement;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class AddAnnouncementController extends AbstractController
{
    #[IsGranted('ROLE_ANNOUNCER')]
    #[Route('/ajout/annonce', name: 'app_add_announcement')]
    public function addAnnouncement(Request $request, AnnouncementRepository $announcementRepository, ?Announcement $announcement): Response
    {
        $user = $this->getUser();

        if (is_null($announcement)) {
            $announcement = new Announcement();
            $dog = new Dog();
            $announcement->addDog($dog);
        }
        $announcement->setAnnouncer($user);
        $form = $this->createForm(AddAnnouncementType::class, $announcement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // On enregistre
            $announcement->setUpdatedAt(new \DateTimeImmutable());
            $announcementRepository->save($announcement, true);
        }

        return $this->render('add_announcement/add_announcement.html.twig', [
            'form' => $form->createView()
        ]);
    }

}