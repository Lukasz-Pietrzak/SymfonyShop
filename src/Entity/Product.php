<?php

declare (strict_types = 1);

namespace App\Entity;

use App\Entity\Price;
use App\Repository\ProductRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Table;

#[Table('product')]
#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product extends BaseEntity
{
    public function __construct(
        #[ORM\Column(type: Types::STRING)]
        private string $name,
        #[ORM\Column(type: Types::STRING)]
        private string $color,
        #[ORM\Column(type: Types::STRING)]
        private string $producent,
        #[ORM\Column(type: Types::INTEGER)]
        private int $barcode,
        #[ORM\OneToOne(targetEntity: Price::class, cascade: ["persist", "remove"], orphanRemoval: true)]
        private Price $price,
    ) {
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getColor(): string
    {
        return $this->color;
    }

    public function getProducent(): string
    {
        return $this->producent;
    }

    public function getBarcode(): int
    {
        return $this->barcode;
    }

    public function getPrice(): Price
    {
        return $this->price;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function setColor(string $color): void
    {
        $this->color = $color;
    }

    public function setProducent(string $producent): void
    {
        $this->producent = $producent;
    }

    public function setBarcode(int $barcode): void
    {
        $this->barcode = $barcode;
    }

    public function setPrice(Price $price): void
    {
        $this->price = $price;
    }

}
