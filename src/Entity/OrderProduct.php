<?php

namespace App\Entity;

use App\Repository\OrderProductRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrderProductRepository::class)]
class OrderProduct extends BaseEntity
{
    #[ORM\Column]
    private int $Quantity;

 

    #[ORM\Column(length: 20)]
    private string $Size;

    #[ORM\ManyToOne(inversedBy: 'orderProducts')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Product $Product = null;

    #[ORM\ManyToOne(inversedBy: 'orderProducts')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Order $Orders = null;

    public function getId(): string
    {
        return $this->id;
    }

    public function getQuantity(): int
    {
        return $this->Quantity;
    }

    public function setQuantity(int $Quantity): void
    {
        $this->Quantity = $Quantity;

    }

    public function getSize(): string
    {
        return $this->Size;
    }

    public function setSize(string $Size): void
    {
        $this->Size = $Size;

    }

    public function getProduct(): ?Product
    {
        return $this->Product;
    }

    public function setProduct(?Product $Product): static
    {
        $this->Product = $Product;

        return $this;
    }

    public function getOrders(): ?Order
    {
        return $this->Orders;
    }

    public function setOrders(?Order $Orders): static
    {
        $this->Orders = $Orders;

        return $this;
    }
}
