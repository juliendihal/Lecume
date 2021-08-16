<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{

    /**
     * @Route("/inscription" , name="inscription")
     *
     */
    public function addUser(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $userPasswordHasher) {
        /* création d'une instance d'un user */
        $user = new User();

        /* récupération de la méthode createForm de l'Abstract Controller*/
        $userForm = $this->createForm(UserType::class, $user);

        /* liaison du formulaire aux données, userFrom contient le gabarit et les données entrées dans le formulaire */
        $userForm->handleRequest($request);

        /* stocke en session un message flash qui sera affiché sur la page suivante */
        if ($userForm->isSubmitted() && $userForm->isValid()){


            $user->setRoles(['ROLE_USER']);

            /* récupère les données envoyées par l'utilisateur*/
            $plainPassword = $userForm->get('password')->getData();

            /* on hashe le mot de passe rentré par l'utilisateur */
            $hashedPassword = $userPasswordHasher->hashPassword($user, $plainPassword);

            $user->setPassword($hashedPassword);

            /* envoi en bdd */
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('home');
        }

        return $this->render('security/adduser.html.twig', [
            'userForm'=>$userForm->createView()
        ]);
    }




    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
