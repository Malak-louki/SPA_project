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
    #[Route('/annonce/{id}', name: 'announcement_show', requirements: ["id" => "\d+"])]
    public function show(
        int $id,
        Announcement $announcement,
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

        return $this->render('annonce/announcement.html.twig', [
            'id' => $id,
            'announcement' => $announcement,
            'form' => $form->createView(),
            'dogs' => $dogs,
            'requests' => $requestRepository,
        ]);

    }
}