<?php

declare (strict_types = 1);

namespace App\Handler\Ingredient;

use App\DTO\IngredientsDTO;
use App\Entity\Ingredients;
use App\Repository\IngredientRepository;

class CreateIngredient
{
    public function __construct(
        private readonly IngredientRepository $ingredientRepository,
    ) {
    }

    public function create(IngredientsDTO $dto): void
    {
        $ingredient = new Ingredients(
            ingredient: $dto->ingredient,
            priceNetto: $dto->priceNetto,
            priceBrutto: $dto->priceBrutto,
            VAT: $dto->VAT,
            category: $dto->category
        );

        $this->ingredientRepository->save($ingredient);
    }

}
