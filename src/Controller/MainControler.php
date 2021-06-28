<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MainControler extends AbstractController
{
    /**
     * @Route("/", name="main_home")
     */

    public  function home()
    {
        return $this->render("main/acceuil.html.twig");
    }
}