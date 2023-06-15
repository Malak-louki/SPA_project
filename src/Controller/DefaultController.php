<?php

namespace App\Controller;

use App\Repository\AnnouncementRepository;
// use App\Repository\ImageRepository;
use App\Repository\AnnouncerRepository;
use App\Repository\ImageRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(AnnouncementRepository $announcementRepository, AnnouncerRepository $announcerRepository): Response
    {
        $annonces = $announcementRepository->findForHome();
        $announcers = $announcerRepository->findForHome();

        return $this->render('default/index.html.twig', [
            'annonces' => $annonces,
            'announcers' => $announcers,
        ]);
    }
}