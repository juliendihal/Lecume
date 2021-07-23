<?php
namespace App\Controller\Admin;

use App\Entity\Plats;
use App\Form\PlatsType;
use App\Repository\PlatsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class AdminArticleController  extends AbstractController{



    /**
    * @Route("/carte/insert" , name="carteinsert")
    */
    public function carteinsert( Request $request , EntityManagerInterface $entityManager){

        //Création d une variable qui instancie l entité platss
        //pour créer un nouvel article dans la bdd (et un nouvel enregistrement dans la table visée)
        $carte = new Plats();

        //Récupération du gabarit formulaire pour le stocker dans une variable
        //en parametre : instanciation du gabarit et nom de l entité visée ou de celle à créer
        $carteForm = $this->createForm(PlatsType::class, $carte);

        //mise en relation du formulaire avec les données envoyées en Post
        $carteForm->handleRequest($request);

        //mise en place d une condition pour vérifier la validité du formulaire  au niveau de la saisie des champs
        //et le bon envoi des données en post
        // si les deux conditions sont ok alors l enregistrement en bdd s effectue
        if($carteForm->isSubmitted() && $carteForm->isValid()){

        $entityManager->persist($carte);
        $entityManager->flush();

        //si ok on renvoi sur la page Admin carte
            return $this->redirectToRoute('admincarte');
        }

        //renvoi de la reponse html sous la forme d une vue liée au fichier twig correspondant
        return $this->render('Admin/formcarte.html.twig',[
        'carteForm'=>$carteForm->createView()
        ]);

    }

    /**
    * @Route("/carte/update/{id}" , name="carteupdate")
    */
    //utilisation de l autowire pour instancier la classe repository pour pouvoir faire mes requête sql
    public function carteupdate($id, PlatsRepository $platsRepository , EntityManagerInterface $entityManager , request $request){

        //requete SQL pour recupération des plats à modifier en fonction de son id defini dans la wildcard
        $carte = $platsRepository->find($id);

        //Récupération du gabarit formulaire pour le stocker dans une variable
        //en parametre : instanciation du gabarit et nom de l entité visée ou de celle à créer
        $carteForm = $this->createForm(PlatsType::class, $carte);

        $carteForm->handleRequest($request);

        //mise en place d une condition pour vérifier la validité du formulaire  au niveau de la saisie des champs
        //et le bon envoi des données en post
        // si les deux conditions sont ok alors l enregistrement en bdd s effectue
        if($carteForm->isSubmitted() && $carteForm->isValid()){

        $entityManager->persist($carte);
        $entityManager->flush();

        //si ok on renvoi sur la page Admin carte
            return $this->redirectToRoute('admincarte');
        }

        //renvoi de la reponse html sous la forme d une vue liée au fichier twig correspondant
        return $this->render('Admin/formcarte.html.twig',[
        'carteForm'=>$carteForm->createView()
        ]);

    }

    /**
    * @Route("/carte/delete/{id}" , name="cartedelete")
    */
    //utilisation de l autowire pour instancier la classe repository pour pouvoir faire mes requête sql
    public function cartedelete($id, PlatsRepository $platsRepository , EntityManagerInterface $entityManager){

        //requete SQL pour recupération des plats à supprimer en fonction de son id defini dans la wildcard
        $carte = $platsRepository->find($id);

        //mise en place des managers de gestion des entités
        //pour supprimer l element selectionné avec son id
        $entityManager->remove($carte);
        $entityManager->flush();

        // on renvoie sur la page Admin carte
        return $this->redirectToRoute('admincarte');

    }

    /**
     * @Route("/admincarte" , name="admincarte")
     */
    //utilisation de l autowire pour instancier la classe repository pour pouvoir faire mes requête sql
public function carte(PlatsRepository $platsRepository){

    //instruction de requete
    $plats = $platsRepository->findAll();

    //renvoie de la reponse html sous la forme d une vue liée au fichier twig correspondant
    return $this->render('Admin/carte.html.twig', [
        'plats'=> $plats
    ]);

}

}