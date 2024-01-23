<?php

declare(strict_types=1);

namespace App\DTO;

use App\Entity\Ingredients;

class IngredientsDTO
{
    public string $ingredient;
    public int $priceNetto;
    public int $priceBrutto;
    public int $VAT;
    public string $category;

    public static function from(Ingredients $ingredients): IngredientsDTO
    {
        $dto = new self();
        $dto->ingredient = $ingredients->getIngredient();
        $dto->priceNetto = $ingredients->getPriceNetto();
        $dto->priceBrutto = $ingredients->getPriceBrutto();
        $dto->VAT = $ingredients->getVAT();
        $dto->category = $ingredients->getCategory();

        return $dto;
    }
}
