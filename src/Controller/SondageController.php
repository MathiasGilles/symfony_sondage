<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class SondageController extends AbstractController
{
    /**
     * @Route("/sondage", name="sondage")
     */
    public function index()
    {
        return $this->render('sondage/index.html.twig', [
            'controller_name' => 'SondageController',
        ]);
    }
}
