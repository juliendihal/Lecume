<?php
namespace App\Controller\Admin;

use App\Entity\Plats;
use App\Form\PlatsType;
use App\Repository\PlatsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class AdminArticleController  extends AbstractController{



    /**
     * @IsGranted("ROLE_ADMIN")
    * @Route("/carte/insert" , name="carte_insert")
    */
    public function carteInsert( Request $request , EntityManagerInterface $entityManager){

        //Création d une variable qui instancie l entité plats
        //pour créer un nouvel article dans la bdd (et un nouvel enregistrement dans la table visée)
        $carte = new Plats();

        //Récupération du gabarit formulaire avec le nom de l entité visée pour le stocker dans une variable
        $carteForm = $this->createForm(PlatsType::class, $carte);

        //mise en relation du formulaire avec les données envoyées en Post
        $carteForm->handleRequest($request);

        //verifivication du formulaire et enregistrement en bdd
        if($carteForm->isSubmitted() && $carteForm->isValid()){

        $entityManager->persist($carte);
        $entityManager->flush();

            $this ->addFlash(
                'success',
                'Le plat ' . $carte-> getName() . ' a été créée '
            );

        //si ok on renvoi sur la page Admin carte
            return $this->redirectToRoute('admincarte');
        }

        //renvoi de la reponse html sous la forme d une vue liée au fichier twig correspondant
        return $this->render('Admin/formcarte.html.twig',[
        'carteForm'=>$carteForm->createView()
        ]);

    }

    /**
     * @IsGranted("ROLE_ADMIN")
    * @Route("/carte/update/{id}" , name="carte_update")
    */
    //utilisation de l autowire pour instancier la classe repository pour pouvoir faire mes requête sql
    public function carteUpdate($id, PlatsRepository $platsRepository , EntityManagerInterface $entityManager , request $request){

        //requete SQL pour recupération des plats à modifier en fonction de son id defini dans la wildcard
        $carte = $platsRepository->find($id);

        //Récupération du gabarit formulaire avec le nom de l entité visée pour le stocker dans une variable
        $carteForm = $this->createForm(PlatsType::class, $carte);

        $carteForm->handleRequest($request);

        //verifivication du formulaire et enregistrement en bdd
        if($carteForm->isSubmitted() && $carteForm->isValid()){

        $entityManager->persist($carte);
        $entityManager->flush();

            $this ->addFlash(
                'success',
                'Le plat ' . $carte-> getName() . ' a été modifié '
            );

        //si ok on renvoi sur la page Admin carte
            return $this->redirectToRoute('admincarte');
        }

        //renvoi de la reponse html sous la forme d une vue liée au fichier twig correspondant
        return $this->render('Admin/formcarte.html.twig',[
        'carteForm'=>$carteForm->createView()
        ]);

    }

    /**
     * @IsGranted("ROLE_ADMIN")
    * @Route("/carte/delete/{id}" , name="carte_delete")
    */
    //utilisation de l autowire pour instancier la classe repository pour pouvoir faire mes requête sql
    public function carteDelete($id, PlatsRepository $platsRepository , EntityManagerInterface $entityManager){

        //requete SQL pour recupération des plats à supprimer en fonction de son id defini dans la wildcard
        $carte = $platsRepository->find($id);

        //mise en place des managers de gestion des entités
        //pour supprimer l element selectionné avec son id
        $entityManager->remove($carte);
        $entityManager->flush();

        $this ->addFlash(
            'success',
            'Le plat ' . $carte-> getName() . ' a été supprimé '
        );

        // on renvoie sur la page Admin carte
        return $this->redirectToRoute('admincarte');

    }

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/admin/carte" , name="admin_carte")
     */
    //utilisation de l autowire pour instancier la classe repository pour pouvoir faire mes requête sql
public function adminCarte(PlatsRepository $platsRepository){

    //instruction de requete
    $plats = $platsRepository->findAll();

    //renvoie de la reponse html sous la forme d une vue liée au fichier twig correspondant
    return $this->render('Admin/carte.html.twig', [
        'plats'=> $plats
    ]);

}

}