<?php
declare(strict_types=1);

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Table;

#[Table('ingredients')]
#[ORM\Entity()]
class Ingredients extends BaseEntity
{
    #[ORM\ManyToOne(inversedBy: 'Ingredient')]
    private ?Order $orders = null;

    #[ORM\ManyToMany(targetEntity: Order::class, mappedBy: 'Ingredient')]
    private Collection $Orders;

    public function __construct(#[ORM\Column(type: Types::STRING)]
    private ?string $ingredient = null, #[ORM\Column(type: Types::INTEGER)]
    private ?int $priceNetto = null, #[ORM\Column(type: Types::INTEGER)]
    private ?int $priceBrutto = null, #[ORM\Column(type: Types::INTEGER)]
    private ?int $VAT = null, #[ORM\Column(type: Types::STRING)]
    private ?string $category = null)
    {
        $this->Orders = new ArrayCollection();
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getIngredient(): ?string
    {
        return $this->ingredient;
    }

    public function setIngredient(?string $ingredient): void
    {
        $this->ingredient = $ingredient;
    }

    public function getPriceNetto(): ?int
    {
        return $this->priceNetto;
    }

    public function setPriceNetto(?int $priceNetto): void
    {
        $this->priceNetto = $priceNetto;
    }

    public function getPriceBrutto(): ?int
    {
        return $this->priceBrutto;
    }

    public function setPriceBrutto(?int $priceBrutto): void
    {
        $this->priceBrutto = $priceBrutto;
    }

    public function getVAT(): ?int
    {
        return $this->VAT;
    }

    public function setVAT(?int $VAT): void
    {
        $this->VAT = $VAT;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(?string $category): void
    {
        $this->category = $category;
    }

    public function getOrders(): ?Order
    {
        return $this->orders;
    }

    public function setOrders(?Order $orders): static
    {
        $this->orders = $orders;

        return $this;
    }

    public function addOrder(Order $order): static
    {
        if (!$this->Orders->contains($order)) {
            $this->Orders->add($order);
            $order->addIngredient($this);
        }

        return $this;
    }

    public function removeOrder(Order $order): static
    {
        if ($this->Orders->removeElement($order)) {
            $order->removeIngredient($this);
        }

        return $this;
    }
}
