<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class TdbController extends AbstractController
{
    /**
     * @Route("/tdb", name="tdb")
     */
    public function index()
    {
        return $this->render('tdb/index.html.twig', [
            'controller_name' => 'TdbController',
        ]);
    }
}
