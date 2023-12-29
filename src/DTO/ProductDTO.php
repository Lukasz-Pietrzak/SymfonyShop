<?php

declare(strict_types=1);

namespace App\DTO;

use App\Entity\Product;

class ProductDTO 
{
    public string $name;
    public string $color;
    public string $producent;
    public int $barcode;
    public int $price_netto;
    public int $price_brutto;
    public int $vat;
    
    public static function from(Product $product){
        $dto = new self();
        $dto->name = $product->getName();
        $dto->color = $product->getColor();
        $dto->producent = $product->getProducent();
        $dto->barcode = $product->getBarcode();
        $dto->price_netto = $product->getPrice()->getPriceNetto();
        $dto->price_brutto = $product->getPrice()->getPriceBrutto();
        $dto->vat = $product->getPrice()->getVat();

        return $dto;
    }
}
