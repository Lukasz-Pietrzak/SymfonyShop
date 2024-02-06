<?php

namespace App\Entity;

use App\Repository\OrderProductRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrderProductRepository::class)]
class OrderProduct extends BaseEntity
{



    public function __construct(
        #[ORM\Column]
        private int $amountProducts,
        #[ORM\Column(length: 20)]
        private string $size,
        #[ORM\ManyToOne(inversedBy: 'orderProducts')]
        #[ORM\JoinColumn(nullable: false)]
        private ?Product $product = null,
        #[ORM\ManyToOne(inversedBy: 'OrderProduct')]
        #[ORM\JoinColumn(nullable: false)]
        private ?Order $Orders = null
        ) {
        
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getAmountProducts(): int
    {
        return $this->amountProducts;
    }

    public function setAmountProducts(int $amountProducts): void
    {
        $this->amountProducts = $amountProducts;

    }

    public function getSize(): string
    {
        return $this->size;
    }

    public function setSize(string $size): void
    {
        $this->size = $size;

    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): static
    {
        $this->product = $product;

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
