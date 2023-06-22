<?php

namespace App\Controller;

use App\Form\UpdateUserFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;


class MyAccountController extends AbstractController
{
    #[IsGranted('ROLE_ADOPTER')]
    #[Route('/my_account', name: 'app_my_account')]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(UpdateUserFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($user);
            $em->flush();
        }
        return $this->render('my_account/myAccount.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }
}
