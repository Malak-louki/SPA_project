<?php

namespace App\Controller;

use App\Repository\AnnouncementRepository;
use App\Repository\DogRepository;
use App\Repository\ImageRepository;
use App\Repository\RaceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AnnonceController extends AbstractController
{
    #[Route('/annonce/{id}', name: 'app_annonce', requirements: ["id" => "\d+"])]
    public function index(int $id, AnnouncementRepository $repository): Response
    //     
    {

        $annonces = $repository->find($id);
        // $dog = $dogRepository->find($id);
        // $images = $imageRepository->findImage($id);
        // $race = $raceRepository->find($id);

        return $this->render('annonce/announcement.html.twig', [
            'annonces' => $annonces,
            // 'dog' => $dog,
            // 'images' => $images,
            // 'race' => $race,
        ]);
    }
}