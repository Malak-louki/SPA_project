<?php

namespace App\Controller;

use App\Form\ImageType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ImageController extends AbstractController
{
    #[Route('/image', name: 'app_image')]
    public function imageForm(): Response
    {
        $form = $this->createForm(ImageType::class);
        return $this->render('image/imageForm.html.twig', [
            'imageForm' => $form->createView(),
        ]);
    }
}