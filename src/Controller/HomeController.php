<?php
namespace App\Controller;

use App\Repository\GalerieRepository;
use App\Repository\PlatsRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class HomeController extends AbstractController{


    /**
     * @Route("/" , name="home")
     */
    public function home()
    {
     return $this->render('Front/home.html.twig');

    }

    /**
     * @Route("/contact" , name="contact")
     */
    public function contact()
    {
        return $this->render('Front/contact.html.twig');
    }

    /**
     * @Route("/carte/{Type}" , name="carte")
     */
    //utilisation de l autowire pour instancier la classe repository pour pouvoir faire mes requête sql
    public function carte(PlatsRepository $platsRepository, $Type ){

        //requete SQL pour recupération des plats par type avec un classement ASC
        $plats = $platsRepository->findBy(['Type' => $Type] , ['subtype'=> 'ASC']);

        //renvoi de la reponse html sous la forme d une vue liée au fichier twig correspondant
        return $this->render('Front/carte.html.twig', [
            'plats'=> $plats,
        ]);
    }
















}