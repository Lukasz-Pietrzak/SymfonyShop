<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Table;

#[Table('orders')]
#[ORM\Entity()]
class Order extends BaseEntity
{

    #[ORM\OneToMany(mappedBy: 'Orders', targetEntity: OrderProduct::class)]
    private Collection $OrderProduct;

    #[ORM\OneToMany(mappedBy: 'Orders', targetEntity: OrderIngredient::class)]
    private Collection $OrderIngredient;

    public function __construct(
        #[ORM\Column(type: Types::INTEGER)]
        private int $orderPriceNetto,
         #[ORM\Column(type: Types::INTEGER)]
        private int $orderPriceBrutto,
         #[ORM\Column(type: Types::INTEGER)]
        private int $orderPriceVAT,
        #[ORM\ManyToOne]
        private ?User $user = null
        ) {
        $this->OrderProduct = new ArrayCollection();
        $this->OrderIngredient = new ArrayCollection();
    }

    public function getId(): string
    {
        return $this->id;
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
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection<int, OrderProduct>
     */
    public function getOrderProduct(): Collection
    {
        return $this->OrderProduct;
    }

    public function addOrderProduct(OrderProduct $orderProduct): static
    {
        if (!$this->OrderProduct->contains($orderProduct)) {
            $this->OrderProduct->add($orderProduct);
            $orderProduct->setOrders($this);
        }

        return $this;
    }

    public function removeOrderProduct(OrderProduct $orderProduct): static
    {
        if ($this->OrderProduct->removeElement($orderProduct)) {
            // set the owning side to null (unless already changed)
            if ($orderProduct->getOrders() === $this) {
                $orderProduct->setOrders(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, OrderIngredient>
     */
    public function getOrderIngredient(): Collection
    {
        return $this->OrderIngredient;
    }

    public function addOrderIngredient(OrderIngredient $orderIngredient): static
    {
        if (!$this->OrderIngredient->contains($orderIngredient)) {
            $this->OrderIngredient->add($orderIngredient);
            $orderIngredient->setOrders($this);
        }

        return $this;
    }

    public function removeOrderIngredient(OrderIngredient $orderIngredient): static
    {
        if ($this->OrderIngredient->removeElement($orderIngredient)) {
            // set the owning side to null (unless already changed)
            if ($orderIngredient->getOrders() === $this) {
                $orderIngredient->setOrders(null);
            }
        }

        return $this;
    }


}
