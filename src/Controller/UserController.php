<?php

namespace App\Controller;

use App\DTO\UserDTO;
use App\Form\RegistrationFormType;
use App\Handler\Account\CreateUser;
use App\Message\EmailNotification;
use App\Provider\UserProvider;
use App\Repository\UserRepository;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class UserController extends AbstractController
{
    #[Route('/login', name: 'ui_login')]
    public function Login(
        AuthenticationUtils $authenticationUtils,
    ): Response {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();
        return $this->render('login/login.html.twig', [
            'error' => $error,
            'last_username' => $lastUsername,
        ]);
    }

    #[Route('/authentication/{slug}', name: 'ui_authentication')]
    public function Authentication(
        UserProvider $userProvider,
        UserRepository $userRepository,
        string $slug,
    ): Response {
        $user = $userProvider->loadProductByAuthCode($slug);

        if ($user) {
            $user->setAuthenticationCode('Authenticated');
            $userRepository->save($user);

            $this->addFlash('success', 'Your email has been successfully confirmed');
            return $this->redirectToRoute('ui_login');
        }
    }

    #[Route('/account', name: 'ui_account')]
    public function Account(
        AuthenticationUtils $authenticationUtils,
    ): Response {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();
        return $this->render('login/login.html.twig', [
            'error' => $error,
            'last_username' => $lastUsername,
        ]);
    }

    #[Route('/logout', name: 'logout')]
    public function logout(): void
    {
    }

    #[Route('/register', name: 'ui_register')]
    public function register(Request $request, CreateUser $createUser, MessageBusInterface $bus): Response
    {
        $dto = new UserDTO;

        $form = $this->createForm(RegistrationFormType::class, $dto);
        $form->handleRequest($request);

        try {
            if ($form->isSubmitted() && $form->isValid()) {
                $authenticationCode = bin2hex(random_bytes(12));
                $createUser->create($dto, $authenticationCode);

                $bus->dispatch(new EmailNotification(
                    $dto->email,
                    'Confirm your email address',
                    'emails/signup.html.twig',
                    'Lukasiero',
                    $authenticationCode
                ));

                $this->addFlash('success', 'Please confirm your email adress');

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
