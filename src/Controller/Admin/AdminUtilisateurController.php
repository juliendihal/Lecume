<?php
namespace App\Controller\Admin;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdminUtilisateurController extends AbstractController{

    /**
     * @Route ("/admin/utilisateur" , name="utilisateur")
     */
    public function UtilisateurList(UserRepository $userRepository){
      $users = $userRepository->findAll();
      return $this->render('Admin/user.html.twig', [
       'users'=> $users
      ]);
    }
}