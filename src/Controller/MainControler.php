<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainControler extends AbstractController
{
    /**
     * @Route("/", name="main_home")
     */

    public  function home(): Response
    {
        return $this->render("main/acceuil.html.twig");
    }

    /**
     * @Route("/aboutUs", name="main_aboutUs")
     */

    public  function aboutUs(): Response
    {
        return $this->render("main/aboutUs.html.twig");
    }


}