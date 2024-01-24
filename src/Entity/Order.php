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

#[ORM\ManyToMany(targetEntity: Product::class, inversedBy: 'order_id')]
private Collection $product_id;

    public function __construct(#[ORM\Column(type: Types::INTEGER)]
private int $orderPriceNetto, #[ORM\Column(type: Types::INTEGER)]
   private int $orderPriceBrutto, #[ORM\Column(type: Types::INTEGER)]
   private int $orderPriceVAT)
    {
        $this->product_id = new ArrayCollection();
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
    public function getProductId(): Collection
    {
        return $this->product_id;
    }

    public function addProductId( $productId): static
    {
        if (!$this->product_id->contains($productId)) {
            $this->product_id->add($productId);
        }

        return $this;
    }

    public function removeProductId(Product $productId): static
    {
        $this->product_id->removeElement($productId);

        return $this;
    }

}