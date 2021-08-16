<?php
namespace App\Controller\Front;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController{

    /**
     * @Route("/contact" , name="contact")
     */
    public function contact()
    {
        return $this->render('Front/contact.html.twig');
    }

}
