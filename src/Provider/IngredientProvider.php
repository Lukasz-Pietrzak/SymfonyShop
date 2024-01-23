<?php 

declare(strict_types=1);

namespace App\Provider;

use App\Entity\Ingredients;
use App\Entity\Product;
use App\Repository\IngredientQueryRepository;
use App\Repository\ProductQueryRepository;

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
            throw new \InvalidArgumentException('Product not found');
        }
        
        return $ingredient;

    }


    public function loadProductsByName($ingredientName):array 
    {
        $product = $this->ingredientQueryRepository->findBy(['ingredient' => $ingredientName]);


        if(!$product){
            throw new \InvalidArgumentException('Product not found');
        }
        
        return $product;

    }

    public function loadAll():array 
    {
        $ingredients = $this->ingredientQueryRepository->findAll();
        
        return $ingredients;
    }
}
