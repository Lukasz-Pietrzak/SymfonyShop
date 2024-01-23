<?php

declare (strict_types = 1);

namespace App\Handler\Ingredient;

use App\DTO\IngredientsDTO;
use App\Entity\Ingredients;
use App\Repository\IngredientRepository;

class UpdateIngredient
{
    public function __construct(
        private readonly IngredientRepository $ingredientRepository,
    ) {
    }

    public function update(Ingredients $ingredients, IngredientsDTO $dto): void
    {
        $ingredients->setIngredient($dto->ingredient);
        $ingredients->setPriceNetto($dto->priceNetto);
        $ingredients->setPriceBrutto($dto->priceBrutto);
        $ingredients->setVAT($dto->VAT);
        $ingredients->setCategory($dto->category);

        $this->ingredientRepository->save($ingredients);
    }

}
