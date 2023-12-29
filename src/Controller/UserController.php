<?php

namespace App\Controller;

use App\DTO\UserDTO;
use App\Form\RegistrationFormType;
use App\Handler\Account\CreateUser;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class UserController extends AbstractController
{
    #[Route('/login', name: 'ui_login')]
    public function Login(AuthenticationUtils $authenticationUtils): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();
        return $this->render('login/login.html.twig', [
            'error' => $error,
            'last_username' => $lastUsername
        ]);
    }

    #[Route('/logout', name: 'logout')]
    public function logout(): void
    {
    }

    #[Route('/register', name: 'ui_register')]
    public function register(Request $request, CreateUser $createUser): Response
    {
        $dto = new UserDTO();

        $form = $this->createForm(RegistrationFormType::class, $dto);
        $form->handleRequest($request);

        try {
            if ($form->isSubmitted() && $form->isValid()) {
                $createUser->create($dto);

                $this->addFlash('success', 'You have successfully created account');

                return $this->redirectToRoute('ui_home');
            }
        } catch (UniqueConstraintViolationException) {
            $errorMessage = 'Email already exists in the database.';
            $this->addFlash('error', $errorMessage);
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}
