<?php

namespace App\Entity;

use App\Repository\UserAuthenticationRepository;
use App\Repository\UserRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User extends BaseEntity implements UserInterface, PasswordAuthenticatedUserInterface
{

    public function __construct(
        #[ORM\Column(type: Types::STRING, unique: true)]
        private string $email,
        #[ORM\Column(type: Types::STRING, nullable: true)]
        private string $authenticationCode
    ) {
    }
    #[ORM\Column]
    private array $roles = [];


    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private string $password;

    public function getId(): string
    {
        return $this->id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): void
    {
        $this->roles = $roles;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function setAuthenticationCode(string $authenticationCode): void
    {
        $this->authenticationCode = $authenticationCode;
    }

    public function getAuthenticationCode(): string
    {
        return $this->authenticationCode;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
    }
}
