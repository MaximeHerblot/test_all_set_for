<?php

namespace App\Controller;


use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;


class SignUpController extends AbstractController
{
    /**
     * @Route("/signup", name="signup")
     */
    public function form(UserPasswordHasherInterface $passwordHasher)
    {
        return $this->render('signup/form_signup.html.twig', [
            'error' => ''
        ]);
    }

    /**
     * @Route("/signup_register", name="signup_register")
     */
    public function signup_register(UserPasswordHasherInterface $passwordHasher, ManagerRegistry $doctrine){
        $username = $_POST["username"];
        $password = $_POST["password"];
        try {

            $user = new User();
            $user->setUsername($username);
            $hashedPassword = $passwordHasher->hashPassword($user,$password);
            $user->setPassword($hashedPassword);
            $em = $doctrine->getManager();
            $em->persist($user);
            $em->flush();
        } catch (Exception $e) {
            return $this->render('signup/form_signup.html.twig',[
                'error' => 'This username already exist',
            ]);
        }

        return $this->render('signup/signup_complete.html.twig', [
            'username' => $username,
        ]);

    }
}