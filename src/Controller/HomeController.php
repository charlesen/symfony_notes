<?php
// src/Controller/HomeController.php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
       * Home page
       ** @Route("/", name="home_index")
       */
    public function index()
    {
        return $this->render('home.html.twig', [
            'number' => random_int(0, 100),
        ]);
    }
}
