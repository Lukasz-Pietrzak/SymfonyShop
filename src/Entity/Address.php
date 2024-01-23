<?php

namespace App\Entity;

use App\Repository\UserAuthenticationRepository;
use App\Repository\UserRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Table;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[Table('user_address')]
#[ORM\Entity()]
class Adress extends BaseEntity
{

    public function __construct(
        #[ORM\Column(type: Types::STRING, unique: true)]
        private string $firstAndLastName,
        #[ORM\Column(type: Types::INTEGER, nullable: true)]
        private int $address,
        #[ORM\Column(type: Types::STRING, nullable: true)]
        private int $postCode,
        #[ORM\Column(type: Types::STRING, nullable: true)]
        private string $city,
    ) {
    }
   
    public function getFirstAndLastName(): string
    {
        return $this->firstAndLastName;
    }

    public function setFirstAndLastName(string $firstAndLastName): void
    {
        $this->firstAndLastName = $firstAndLastName;
    }

    public function getAddress(): int
    {
        return $this->address;
    }

    public function setAddress(int $address): void
    {
        $this->address = $address;
    }

    public function getPostCode(): int
    {
        return $this->postCode;
    }

    public function setPostCode(int $postCode): void
    {
        $this->postCode = $postCode;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function setCity(string $city): void
    {
        $this->city = $city;
    }

}