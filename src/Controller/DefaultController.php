<?php

namespace App\Controller;

use App\Repository\AnnouncementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(string $image, AnnouncementRepository $announcementRepository): Response
    {
        $annonce = $announcementRepository->findOneBy([
            'title' => $image
        ]);
        return $this->render('default/index.html.twig', [
        ]);
    }
}