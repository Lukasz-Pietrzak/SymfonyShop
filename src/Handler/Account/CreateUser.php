<?php

declare (strict_types = 1);

namespace App\Handler\Account;

use App\DTO\UserAuthenticationDTO;
use App\DTO\UserDTO;
use App\Entity\User;
use App\Entity\UserAuthentication;
use App\Repository\UserAuthenticationRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\SecurityBundle\Security\UserAuthenticator;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class CreateUser
{
    public function __construct(
        private readonly UserPasswordHasherInterface $userPasswordHasher,
        private readonly UserRepository $userRepository,
    ) {
    }

    public function create(UserDTO $dto, $authenticationCode): void
    {


        $user = new User($dto->email, $authenticationCode);
        $user->setPassword(
            $this->userPasswordHasher->hashPassword(
                $user,
                $dto->plainPassword
            )
        );

        $this->userRepository->save($user);
    }
}
