<?php
namespace App\Controller\Admin;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdminHomeController extends AbstractController {
    /**
     * @Route("/admin/home", name="adminhome")
     */
    public function home(){

        return $this->render('Admin/home.html.twig');

    }

}