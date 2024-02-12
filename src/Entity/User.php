<?php

namespace App\Entity;

use App\Entity\UserAddress;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User extends BaseEntity implements UserInterface, PasswordAuthenticatedUserInterface
{

    public function __construct(#[ORM\Column(type: Types::STRING, unique: true)]
    private string $email, #[ORM\Column(type: Types::STRING, nullable: true)]
    private string $authenticationCode)
    {
        $this->Orders = new ArrayCollection();
    }

    #[ORM\Column]
    private array $roles = [];


    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private string $password;

    #[ORM\Column(nullable: true)]
    private ?int $phoneNumber = null;

    #[ORM\OneToOne(targetEntity: UserAddress::class, cascade: ["persist", "remove"], orphanRemoval: true)]
    private UserAddress $userAddress;

    #[ORM\OneToMany(mappedBy: 'User', targetEntity: Order::class)]
    private Collection $Orders;

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

    public function getPhoneNumber(): ?int
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(?int $phoneNumber): static
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    public function getAddress(): ?UserAddress
    {
        return $this->userAddress;
    }

    public function setAddress(?UserAddress $userAddress): static
    {
        $this->userAddress = $userAddress;

        return $this;
    }

    /**
     * @return Collection<int, Order>
     */
    public function getOrders(): Collection
    {
        return $this->Orders;
    }

    public function addOrder(Order $order): static
    {
        if (!$this->Orders->contains($order)) {
            $this->Orders->add($order);
            $order->setUser($this);
        }

        return $this;
    }

    public function removeOrder(Order $order): static
    {
        if ($this->Orders->removeElement($order)) {
            // set the owning side to null (unless already changed)
            if ($order->getUser() === $this) {
                $order->setUser(null);
            }
        }

        return $this;
    }


    
}
