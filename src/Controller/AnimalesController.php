<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AnimalesController extends AbstractController
{
    /**
     * @Route("/animal/inicio", name="animal_inicio")
     */
    public function index(): Response
    {
        return $this->render('animales/index.html.twig', [
            'controller_name' => 'AnimalesController',
        ]);
    }
}
