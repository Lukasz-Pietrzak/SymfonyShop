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

#[ORM\ManyToMany(targetEntity: Product::class, inversedBy: 'orders')]
private Collection $Product;

#[ORM\ManyToMany(targetEntity: Ingredients::class, inversedBy: 'Orders')]
private Collection $Ingredient;


    public function __construct(#[ORM\Column(type: Types::INTEGER)]
private int $orderPriceNetto, #[ORM\Column(type: Types::INTEGER)]
       private int $orderPriceBrutto, #[ORM\Column(type: Types::INTEGER)]
    private int $orderPriceVAT)
    {
        $this->Product = new ArrayCollection();
        $this->Ingredient = new ArrayCollection();
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
     * @return Collection<int, Product>
     */
    public function getProduct(): Collection
    {
        return $this->Product;
    }

    public function addProduct(Product $product): static
    {
        if (!$this->Product->contains($product)) {
            $this->Product->add($product);
        }

        return $this;
    }

    public function removeProduct(Product $product): static
    {
        $this->Product->removeElement($product);

        return $this;
    }

    /**
     * @return Collection<int, Ingredients>
     */
    public function getIngredient(): Collection
    {
        return $this->Ingredient;
    }

    public function addIngredient(Ingredients $ingredient): static
    {
        if (!$this->Ingredient->contains($ingredient)) {
            $this->Ingredient->add($ingredient);
        }

        return $this;
    }

    public function removeIngredient(Ingredients $ingredient): static
    {
        $this->Ingredient->removeElement($ingredient);

        return $this;
    }

}