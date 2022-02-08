<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AccueilController extends AbstractController
{
    /**
     * @Route("/", name="accueil")
     */
    public function index(AuthenticationUtils $authUser): Response
    {
        $lastUsername = $authUser->getLastUsername();
        return $this->render('accueil/index.html.twig', [
            'username' => $lastUsername,
        ]);
    }
}
