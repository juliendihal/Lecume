<?php
namespace App\Controller\Front;
use App\Repository\GalerieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
class GalerieController extends AbstractController{

    /**
     * @Route("/galerie" , name="galerie")
     */
    //utilisation de l autowire pour instancier la classe repository pour pouvoir faire mes requête sql
    public function galerie(GalerieRepository $galerieRepository){

        //instruction de requete
        $images = $galerieRepository->findAll();

        //renvoi de la reponse html sous la forme une vue liée au fichier twig correspondant
        return $this->render('Front/galerie.twig',[
            'images'=> $images
        ]);
    }
}