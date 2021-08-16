<?php
namespace App\Controller\Front;

use App\Repository\SubTypeRepository;
use App\Repository\TypeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CarteController extends AbstractController {

    /**
     * @Route("/carte/{id}" , name="carte")
     */
    public function showCard($id , TypeRepository $typeRepository , SubTypeRepository $subTypeRepository ){
        $type = $typeRepository->find($id);
        $subtypes = $subTypeRepository->findAll();
        return $this->render('Front/carte.html.twig', [
            'type'=> $type,
            'subtypes'=> $subtypes


        ]);

    }

}