<?php

namespace App\Controller;

use App\Entity\Dog;
use App\Form\AddDogFormType;
use App\Repository\AnnouncementRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AddDogController extends AbstractController
{
    #[Route('/ajout/chien', name: 'app_ajout_dog')]
    #[Route('/modifier/chien/{id}', name: 'app_modifier_chien')]
    public function new(Request $request, EntityManagerInterface $em, AnnouncementRepository $announcementRepository, ?Dog $dog = null): Response
    {
        if (is_null($dog)) {

            $announcement = current($announcementRepository->findAll());
            $dog = new Dog();
            $dog->setAnnouncement($announcement);
        }

        $form = $this->createForm(AddDogFormType::class, $dog);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($dog);
            $em->flush();
        }

        return $this->render('add_dog/add_dog.html.twig', [
            'controller_name' => 'AddDogController',
            'form' => $form->createView(),
        ]);
    }
}