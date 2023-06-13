<?php

namespace App\Controller;

use App\Repository\AnnouncementRepository;
use App\Repository\DogRepository;
use App\Repository\ImageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AnnonceController extends AbstractController
{
    #[Route('/annonce/{id}', name: 'app_annonce', requirements: ["id" => "\d+"])]
    public function index(int $id, AnnouncementRepository $repository, DogRepository $dogRepository, ImageRepository $imageRepository): Response
    {

        $annonce = $repository->find($id);
        $dog = $dogRepository->find($id);
        $image = $imageRepository->findAll();

        return $this->render('annonce/index.html.twig', [
            'annonce' => $annonce,
            'dog' => $dog,
            'image' => $image,
        ]);
    }
}