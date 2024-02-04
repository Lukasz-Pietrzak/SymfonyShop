<?php

declare (strict_types = 1);

namespace App\Handler\Order;

use App\Entity\OrderIngredient;
use App\Provider\IngredientProvider;

class createOrderIngredients
{

    public function __construct(
        private readonly IngredientProvider $ingredientProvider,
    ) {
    }

    public function create($dataToDatabase, $order, $entityManager)
    {

        $amountOfIngredients = 1;

        $processedIngredients = [];
        
        foreach ($dataToDatabase as $data) {
            $dataLength = strlen($data);
        
            if ($dataLength > 0) {
                $ingredient = $this->ingredientProvider->loadIngredientById($data);
        
                // Klucz identyfikujący składnik i zamówienie
                $key = $ingredient->getId();
        
                // Sprawdź, czy składnik został już przetworzony
                if (isset($processedIngredients[$key])) {
                    // Jeżeli tak, zaktualizuj amountOfIngredients
                    $processedIngredients[$key]->setAmountIngredient($processedIngredients[$key]->getAmountIngredient() + 1);
                } else {
                    // Jeżeli nie istnieje, utwórz nowy OrderIngredient
                    $orderIngredient = new OrderIngredient($amountOfIngredients, $ingredient, $order);
        
                    // Persistuj nowy OrderIngredient
                    $entityManager->persist($orderIngredient);
        
                    // Dodaj do przetworzonych składników
                    $processedIngredients[$key] = $orderIngredient;
                }
            }
        }
    }


}







