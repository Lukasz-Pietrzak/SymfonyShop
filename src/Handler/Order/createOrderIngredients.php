<?php

declare (strict_types = 1);

namespace App\Handler\Order;

use App\Entity\Order;
use App\Entity\OrderIngredient;
use App\Provider\IngredientProvider;
use Doctrine\ORM\EntityManagerInterface;

class createOrderIngredients
{

    public function __construct(
        private readonly IngredientProvider $ingredientProvider,
    ) {
    }

    public function create(array $dataToDatabase, Order $order, EntityManagerInterface $entityManager): void
    {

        $amountOfIngredients = 1;

        $processedIngredients = [];

        foreach ($dataToDatabase as $data) {
            $dataLength = strlen($data);

            if ($dataLength > 0) {
                $ingredient = $this->ingredientProvider->loadIngredientById($data);

                // Sprawdź, czy składnik został już przetworzony
                if (isset($processedIngredients[$data])) {
                    // Jeżeli tak, zaktualizuj amountOfIngredients
                    $processedIngredients[$data]->setAmountIngredient($processedIngredients[$data]->getAmountIngredient() + 1);
                } else {
                    // Jeżeli nie istnieje, utwórz nowy OrderIngredient
                    $orderIngredient = new OrderIngredient(
                        amountIngredient: $amountOfIngredients,
                        Ingredient: $ingredient,
                        Orders: $order);

                    // Persistuj nowy OrderIngredient
                   
                    $entityManager->persist($orderIngredient);

                    // Dodaj do przetworzonych składników
                    $processedIngredients[$data] = $orderIngredient;
                }
            }
        }
    }

}
