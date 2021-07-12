<?php


namespace App\Controller;


use App\Controller\Services\Censurator\Censurator;
use App\Controller\Services\uploadImage\UploadImage;
use App\Entity\Wish;
use App\Form\WishType;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

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

    /**
     * @Route("/formulaire", name="main_formulaire")
     */
    public  function  ajouterWish(Censurator $censurator,
                                  Request $request,
                                  EntityManagerInterface $entityManager,
                                  SluggerInterface $slugger): Response
    {

        $wish = new Wish();
        $wish->setDateCreated(new \DateTime());
        $wish->setIsPublished(true);

        $wishForm = $this->createForm(WishType::class, $wish);
        $wishForm->handleRequest($request);

        if ($wishForm->isSubmitted() && $wishForm->isValid() )
        {
            $imageFile = $wishForm->get('image')->getData();
            if ($imageFile)
            {
             /*   $imageFileName = $uploadImage->upload($imageFile);
                $wish->setImage($imageFileName);*/
                $originalImageName = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeImageName =$slugger->slug($originalImageName);
                $imageName = $safeImageName.'-'.uniqid().'.'.$imageFile->guessExtension();
                try {
                    $imageFile->move(
                        $this->getParameter('brochures_directory'),
                    $imageName);
            }catch (FileException$e)
                {
                    return $e->getTrace();
                }
                $wish->setImage($imageName);
            }
            $entityManager->persist($wish);
            $entityManager->flush();

            $this->addFlash('success','Votre Wish a été ajoutée ! ');
            return $this->redirectToRoute('wish_details', ['id' => $wish->getId()]);
        }
        return $this->render("main/ajouterWish.html.twig", [
            "wishForm" => $wishForm->createView()
        ]);
    }




}