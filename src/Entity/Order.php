<?php

namespace App\Entity;

use App\Repository\UserAuthenticationRepository;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Table;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[Table('orders')]
#[ORM\Entity()]
class Order extends BaseEntity
{

#[ORM\OneToOne(inversedBy: 'orders', cascade: ['persist', 'remove'])]
private ?User $User = null;

#[ORM\OneToMany(mappedBy: 'Ingredient', targetEntity: OrderIngredient::class)]
private Collection $orderIngredients;

#[ORM\OneToMany(mappedBy: 'Orders', targetEntity: OrderProduct::class, orphanRemoval: true)]
private Collection $orderProducts;

    public function __construct(#[ORM\Column(type: Types::INTEGER)]
private int $orderPriceNetto, #[ORM\Column(type: Types::INTEGER)]
           private int $orderPriceBrutto, #[ORM\Column(type: Types::INTEGER)]
 private int $orderPriceVAT)
    {
        $this->orderIngredients = new ArrayCollection();
        $this->orderProducts = new ArrayCollection();
    }
   
    public function getOrderPriceNetto(): int
    {
        return $this->orderPriceNetto;
    }

    public function setOrderPriceNetto(int $orderPriceNetto): void
    {
        $this->orderPriceNetto = $orderPriceNetto;
    }

    public function getOrderPriceBrutto(): int
    {
        return $this->orderPriceBrutto;
    }

    public function setOrderPriceBrutto(int $orderPriceBrutto): void
    {
        $this->orderPriceBrutto = $orderPriceBrutto;
    }

    public function getOrderPriceVAT(): int
    {
        return $this->orderPriceVAT;
    }

    public function setOrderPriceVAT(int $orderPriceVAT): void
    {
        $this->orderPriceVAT = $orderPriceVAT;
    }

    public function getUser(): ?User
    {
        return $this->User;
    }

    public function setUser(?User $User): static
    {
        $this->User = $User;

        return $this;
    }


        /**
     * @return Collection<int, OrderIngredient>
     */
    public function getOrderIngredients(): Collection
    {
        return $this->orderIngredients;
    }

    public function addOrderIngredient(OrderIngredient $orderIngredient): static
    {
        if (!$this->orderIngredients->contains($orderIngredient)) {
            $this->orderIngredients->add($orderIngredient);
            $orderIngredient->setOrder($this);
        }

        return $this;
    }

    public function removeOrderIngredient(OrderIngredient $orderIngredient): static
    {
        if ($this->orderIngredients->removeElement($orderIngredient)) {
            // set the owning side to null (unless already changed)
            if ($orderIngredient->getOrder() === $this) {
                $orderIngredient->setOrder($this);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, OrderProduct>
     */
    public function getOrderProducts(): Collection
    {
        return $this->orderProducts;
    }

    public function addOrderProduct(OrderProduct $orderProduct): static
    {
        if (!$this->orderProducts->contains($orderProduct)) {
            $this->orderProducts->add($orderProduct);
            $orderProduct->setOrders($this);
        }

        return $this;
    }

    public function removeOrderProduct(OrderProduct $orderProduct): static
    {
        if ($this->orderProducts->removeElement($orderProduct)) {
            // set the owning side to null (unless already changed)
            if ($orderProduct->getOrders() === $this) {
                $orderProduct->setOrders(null);
            }
        }

        return $this;
    }

}