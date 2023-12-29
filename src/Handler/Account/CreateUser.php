<?php

declare (strict_types = 1);

namespace App\Handler\Account;

use App\DTO\UserDTO;
use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class CreateUser
{
    public function __construct(
        private readonly UserPasswordHasherInterface $userPasswordHasher,
        private readonly UserRepository $userRepository,
    ) {
    }

    public function create(UserDTO $dto): void
    {
        $user = new User($dto->email);
        $user->setPassword(
            $this->userPasswordHasher->hashPassword(
                $user,
                $dto->plainPassword
            )
        );

        $this->userRepository->save($user);
    }
}
