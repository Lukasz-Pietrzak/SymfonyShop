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
        #[ORM\Column(type: Types::INTEGER)]
        private int $priceNetto,
        #[ORM\Column(type: Types::INTEGER)]
        private int $priceBrutto,
        #[ORM\Column(type: Types::INTEGER)]
        private int $vat,
    ) {
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getPriceNetto(): int
    {
        return $this->priceNetto;
    }

    public function getPriceBrutto(): int
    {
        return $this->priceBrutto;
    }

    public function getVat(): int
    {
        return $this->vat;
    }

    public function setPriceNetto(int $priceNetto): void
    {
        $this->priceNetto = $priceNetto;
    }

    public function setPriceBrutto(int $priceBrutto): void
    {
        $this->priceBrutto = $priceBrutto;
    }

    public function setVat(int $vat): void
    {
        $this->vat = $vat;
    }

}
