<?php 

declare(strict_types=1);

namespace App\Provider;

use App\Entity\Ingredients;
use App\Repository\IngredientQueryRepository;

class IngredientProvider
{
    public function __construct(
        private readonly IngredientQueryRepository $ingredientQueryRepository,
        ) {
    }

    public function loadIngredientById($ingredientId):Ingredients 
    {
        $ingredient = $this->ingredientQueryRepository->find($ingredientId);

        if(!$ingredient){
            throw new \InvalidArgumentException('Ingredient not found');
        }
        
        return $ingredient;

    }


    public function loadIngredientsByName(string $ingredientName):array 
    {
        $ingredient = $this->ingredientQueryRepository->findBy(['ingredient' => $ingredientName]);

        if(!$ingredient){
            throw new \InvalidArgumentException('ingredient not found');
        }
        
        return $ingredient;

    }

    public function loadAll():array 
    {
        $ingredients = $this->ingredientQueryRepository->findAll();
        
        return $ingredients;
    }
}
