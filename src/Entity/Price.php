<?php

declare (strict_types = 1);

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Table;

#[Table('product_price')]
#[ORM\Entity()]
class Price extends BaseEntity
{
    public function __construct(
        #[ORM\Column(type: Types::INTEGER, nullable: true)]
        private ?int $priceNettoSmall = null,
        #[ORM\Column(type: Types::INTEGER, nullable: true)]
        private ?int $priceBruttoSmall = null,
        #[ORM\Column(type: Types::INTEGER, nullable: true)]
        private ?int $vatSmall = null,
        #[ORM\Column(type: Types::INTEGER, nullable: true)]
        private ?int $priceNettoMedium = null,
        #[ORM\Column(type: Types::INTEGER, nullable: true)]
        private ?int $priceBruttoMedium = null,
        #[ORM\Column(type: Types::INTEGER, nullable: true)]
        private ?int $vatMedium = null,
        #[ORM\Column(type: Types::INTEGER, nullable: true)]
        private ?int $priceNettoLarge = null,
        #[ORM\Column(type: Types::INTEGER, nullable: true)]
        private ?int $priceBruttoLarge = null,
        #[ORM\Column(type: Types::INTEGER, nullable: true)]
        private ?int $vatLarge = null,
    ) {
    }

    public function getPriceNettoSmall(): ?int
    {
        return $this->priceNettoSmall;
    }

    public function getPriceBruttoSmall(): ?int
    {
        return $this->priceBruttoSmall;
    }

    public function getVatSmall(): ?int
    {
        return $this->vatSmall;
    }

    public function getPriceNettoMedium(): ?int
    {
        return $this->priceNettoMedium;
    }

    public function getPriceBruttoMedium(): ?int
    {
        return $this->priceBruttoMedium;
    }

    public function getVatMedium(): ?int
    {
        return $this->vatMedium;
    }

    public function getPriceNettoLarge(): ?int
    {
        return $this->priceNettoLarge;
    }

    public function getPriceBruttoLarge(): ?int
    {
        return $this->priceBruttoLarge;
    }

    public function getVatLarge(): ?int
    {
        return $this->vatLarge;
    }

    public function setPriceNettoSmall(?int $priceNettoSmall): void
    {
        $this->priceNettoSmall = $priceNettoSmall;
    }

    public function setPriceBruttoSmall(?int $priceBruttoSmall): void
    {
        $this->priceBruttoSmall = $priceBruttoSmall;
    }

    public function setVatSmall(?int $vatSmall): void
    {
        $this->vatSmall = $vatSmall;
    }

    public function setPriceNettoMedium(?int $priceNettoMedium): void
    {
        $this->priceNettoMedium = $priceNettoMedium;
    }

    public function setPriceBruttoMedium(?int $priceBruttoMedium): void
    {
        $this->priceBruttoMedium = $priceBruttoMedium;
    }

    public function setVatMedium(?int $vatMedium): void
    {
        $this->vatMedium = $vatMedium;
    }

    public function setPriceNettoLarge(?int $priceNettoLarge): void
    {
        $this->priceNettoLarge = $priceNettoLarge;
    }

    public function setPriceBruttoLarge(?int $priceBruttoLarge): void
    {
        $this->priceBruttoLarge = $priceBruttoLarge;
    }

    public function setVatLarge(?int $vatLarge): void
    {
        $this->vatLarge = $vatLarge;
    }

}
