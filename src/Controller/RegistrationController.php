<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGenerator;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class RegistrationController extends AbstractController
{

    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                    $userPasswordHasher->hashPassword(
                            $user,
                            $form->get('plainPassword')->getData()
                    )
            );

            $entityManager->persist($user);
            $entityManager->flush();
            // do anything else you need here, like send an email

            return $this->redirectToRoute('app_register-success');
        }

        return $this->render('registration/register.html.twig', [
                    'registrationForm' => $form->createView(),
        ]);
    }

    #[Route('/register-success', name: 'app_register-success')]
    public function registerSuccess(UrlGeneratorInterface $urlGen): Response
    {
        $login_url = $urlGen->generate('app_login', [], UrlGenerator::ABSOLUTE_URL);
        return $this->render('registration/register-success.html.twig', [
                    'title' => "Successfully Registered",
                    'message' => "Registration was successful. Follow the <a href='$login_url'>Login</a> link to authorize",
        ]);
    }

}
