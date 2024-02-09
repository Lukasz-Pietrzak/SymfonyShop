<?php

declare (strict_types = 1);

namespace App\Provider;

use App\Entity\User;
use App\Repository\UserQueryRepository;

class UserProvider
{
    public function __construct(
        private readonly UserQueryRepository $userQueryRepository,
    ) {
    }

    public function loadProductByAuthCode($authenticationCode): User
    {
        $user = $this->userQueryRepository->findOneBy(['authenticationCode' => $authenticationCode]);

        if (!$user) {
            throw new \InvalidArgumentException('User not found');

        }

        return $user;
    }

    public function loadUserById(string $userId): User
    {
        $user = $this->userQueryRepository->find($userId);

        if (!$user) {
            throw new \InvalidArgumentException('User not found');
        }

        return $user;

    }

    public function loadAll(): array
    {
        $order = $this->userQueryRepository->findAll();

        return $order;
    }
}
