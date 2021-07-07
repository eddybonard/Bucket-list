<?php


namespace App\Controller;


use App\Entity\Wish;
use App\Form\WishType;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainControler extends AbstractController
{
    /**
     * @Route("/", name="main_home")
     */

    public  function home(): Response
    {
        $url = "https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3022.1839486564413!2d-73.98773128501851!3d40.757978742739105!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c25855c6480299%3A0x55194ec5a1ae072e!2sTimes%20Square!5e0!3m2!1sfr!2sfr!4v1625582381617!5m2!1sfr!2sfr";
        return $this->render("main/acceuil.html.twig", [
            "url" => $url
        ]);
    }

    /**
     * @Route("/aboutUs", name="main_aboutUs")
     */

    public  function aboutUs(): Response
    {
        return $this->render("main/aboutUs.html.twig");
    }

    /**
     * @Route("/formulaire", name="main_formulaire")
     */
    public  function  ajouterWish(Request $request, EntityManagerInterface $entityManager): Response
    {

        $wish = new Wish();
        $wish->setDateCreated(new \DateTime());
        $wish->setIsPublished(true);

        $wishForm = $this->createForm(WishType::class, $wish);
        $wishForm->handleRequest($request);

        if ($wishForm->isSubmitted() && $wishForm->isValid())
        {
            $entityManager->persist($wish);
            $entityManager->flush();

            $this->addFlash('success','Idea successfully aded ! ');
            return $this->redirectToRoute('wish_details', ['id' => $wish->getId()]);
        }

        return $this->render("main/ajouterWish.html.twig", [
            "wishForm" => $wishForm->createView()
        ]);
    }




}