<?php
namespace App\Controller\Admin;

use App\Entity\Galerie;
use App\Form\GalerieType;
use App\Image\FileUploader;
use App\Repository\GalerieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdminGalerieController extends AbstractController{

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/galerie/insert" , name="galerie_insert")
     */
    public function galerieInsert( Request $request , EntityManagerInterface $entityManager, FileUploader $fileUploader)
    {
        //Création d une variable qui instancie l entité galerie
        //pour créer une nouvel galerie dans la bdd (et un nouvel enregistrement dans la table visée)
        $galerie = new Galerie();

        //Récupération du gabarit formulaire pour le stocker dans une variable
        //en parametre : instanciation du gabarit et nom de l entité visée ou de celle à créer
        $galerieForm = $this->createForm(GalerieType::class, $galerie);

        //mise en relation du formulaire avec les données envoyées en Post
        $galerieForm->handleRequest($request);

        //si le formulaire a ete poster et il est valide alors on enregistre l'article
        if ($galerieForm->isSubmitted() && $galerieForm->isValid()) {

            // Recupération de l image téléchargée avec la methode get
            $brochureFile = $galerieForm->get('image')->getData();

            //mise en place d une condition
            // pour définir le comportement en cas d upload de fichier
            if ($brochureFile) {

                $brochureFileName = $fileUploader->upload($brochureFile);

                //avec la methode setter: ajout de l image dans l entity article
                $galerie->setImage($brochureFileName);
            }

            $entityManager->persist($galerie);
            $entityManager->flush();

            //si ok on renvoi sur la page galerie
            return $this->redirectToRoute('gallerie');

        }

        //renvoi du formulaire sur une page vue si le formulaire n est pas validé
        return $this->render('Admin/formgalerie.html.twig', [
            'galerieForm' => $galerieForm->createView()
        ]);

    }

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/galerie/update/{id}" , name="galerie_update")
     */
    public function galerieUpdate($id,GalerieRepository $galerieRepository , request $request , EntityManagerInterface $entityManager , FileUploader $fileUploader ){

        //recupération de la galerie à modifier en fonction de son id defini dans la wildcard
        $galerie = $galerieRepository->find($id);

        //Récupération du gabarit formulaire pour le stocker dans une variable
        //en parametre : instanciation du gabarit et nom de l entité visée ou de celle à créer
        $galerieForm = $this->createForm(GalerieType::class, $galerie);

        //mise en relation du formulaire avec les données envoyées en Post
        $galerieForm->handleRequest($request);

        //si le formulaire a ete poster et il est valide alors on enregistre l'article
        if($galerieForm->isSubmitted() && $galerieForm->isValid()){

            // Recupération de l image téléchargée avec la methode get
            $brochureFile = $galerieForm->get('image')->getData();

            //mise en place d une condition
            // pour définir le comportement en cas d upload de fichier
            if ($brochureFile) {

                $brochureFileName = $fileUploader->upload($brochureFile);

                //avec la methode setter: ajout de l image dans l entity article
                $galerie->setImage($brochureFileName);
            }

            $entityManager->persist($galerie);
            $entityManager->flush();

            //si ok on renvoi sur la page galerie
            return $this->redirectToRoute('gallerie');
        }

        //renvoi du formulaire sur une page vue si le formulaire n est pas validé
        return $this->render('Admin/formgalerie.html.twig',[
            'galerieForm'=>$galerieForm->createView()
        ]);

    }

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/galerie/delete/{id}" , name="galerie_delete")
     */
    public function galerieDelete($id, GalerieRepository $galerieRepository , EntityManagerInterface $entityManager){

        //recupération une gallerie à modifier en fonction de son id defini dans la wildcard
        $galerie = $galerieRepository->find($id);

        //mise en place des managers de gestion des entités
        //pour supprimer l element selectionné avec son id
        $entityManager->remove($galerie);
        $entityManager->flush();

        //si ok on renvoi sur la page galerie
        return $this->redirectToRoute('gallerie');

    }

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("admin/galerie" , name="admin_galerie")
     */
    //utilisation de l autowire pour instancier la classe repository pour pouvoir faire mes requête sql
    public function galerie(GalerieRepository $galerieRepository){

        //instruction de requete
        $images = $galerieRepository->findAll();

        //renvoi de la reponse html sous la forme une vue liée au fichier twig correspondant
        return $this->render('Admin/galerie.html.twig',[
            'images'=> $images
        ]);
    }

}