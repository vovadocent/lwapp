<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserProfileType;
use App\Repository\UserDataRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccountController extends AbstractController
{

    #[Route('/account', name: 'app_account')]
    public function index(Request $request, UserDataRepository $userRepo): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED');

        $userData = $this->getUser()->getUserData();

        $form = $this->createForm(UserProfileType::class, $userData);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userRepo->updateUserData($form->getData());
        }

        return $this->render('account/user-profile.html.twig', [
                    'usr' => $userData,
                    'title' => 'User Profile',
                    'page_heading' => 'User Profile',
                    'upForm' => $form->createView(),
        ]);
    }

    #[Route('/account-info', name: 'app_account_info')]
    public function accountInfo(Request $request, UserDataRepository $userRepo): Response
    {
        $userData = $this->getUser()->getUserData();

        $form = $this->createForm(UserProfileType::class, $userData);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userRepo->updateUserData($form->getData());
            $out = [
                'result' => 1,
                'msg' => 'Your profile data has been updated'
            ];
        } else {
            $out = [
                'result' => 0,
                'msg' => strval($form->getErrors(true, false))
            ];
        }

        return $this->json($out);
    }

}
