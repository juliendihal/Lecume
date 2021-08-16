<?php
namespace App\Controller\Admin;
use App\Repository\GalerieRepository;
use App\Repository\PlatsRepository;
use App\Repository\UserRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdminHomeController extends AbstractController {
    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/admin/home", name="admin_home")
     */
    public function adminHome(PlatsRepository $platsRepository ,GalerieRepository $galerieRepository, UserRepository $userRepository){

        $plats = $platsRepository->findBy([] , ['id'=> 'DESC'] , 5);
        $images = $galerieRepository->findBy([] , ['id'=> 'DESC'], 5);
        $users = $userRepository->findBy([] , ['id'=> 'DESC'], 5);


        return $this->render('Admin/home.html.twig',[
            'plats'=> $plats,
            'images'=> $images,
            'users'=> $users
        ]);

    }

}