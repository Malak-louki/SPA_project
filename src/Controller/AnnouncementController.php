<?php

namespace App\Controller;

use App\Entity\Announcement;
use App\Form\Filter\DogFilterType;
use App\Form\Filter\AnnouncementFilter;
use App\Repository\AnnouncementRepository;
use App\Repository\RequestRepository;
use App\Repository\DogRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AnnouncementController extends AbstractController
{
    #[Route('/annonce/{id}', name: 'app_annonce', requirements: ["id" => "\d+"])]
    public function announcement(Announcement $annonce, AnnouncementRepository $repository, DogRepository $dogRepository, Request $request): Response
    {
        
        $filter = new AnnouncementFilter();
        
        $form = $this->createForm(DogFilterType::class, $filter, [
            'announcement' => $annonce,
        ]);
        $form->handleRequest($request);
        
            $dogs = $dogRepository->filterDogs($filter, $annonce);
        
        return $this->render('annonce/announcement.html.twig', [
            'annonces' => $annonce,
            'form'      => $form->createView(),
            'dogs'  => $dogs,
        ]);
    }
}
