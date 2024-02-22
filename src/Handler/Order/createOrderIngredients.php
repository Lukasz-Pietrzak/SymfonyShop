<?php

declare (strict_types = 1);

namespace App\Handler\Order;

use App\Entity\Order;
use App\Entity\OrderIngredient;
use App\Provider\IngredientProvider;
use Doctrine\ORM\EntityManagerInterface;

class createOrderIngredients
{
    protected $processedIngredients;
    protected $order;

    public function __construct(
        private readonly IngredientProvider $ingredientProvider,
    ) {
    }

    public function getProcessedIngredients(){
        return $this->processedIngredients;
    }

    public function create(array $dataToDatabase, Order &$order, EntityManagerInterface $entityManager): void
    {

        $amountOfIngredients = 1;

        $this->processedIngredients = [];

        foreach ($dataToDatabase as $data) {
            $dataLength = strlen($data);

            if ($dataLength > 0) {
                $ingredient = $this->ingredientProvider->loadIngredientById($data);

                // Sprawdź, czy składnik został już przetworzony
                if (isset($this->processedIngredients[$data])) {
                    // Jeżeli tak, zaktualizuj amountOfIngredients
                    $this->processedIngredients[$data]->setAmountIngredient($this->processedIngredients[$data]->getAmountIngredient() + 1);
                } else {
                    // Jeżeli nie istnieje, utwórz nowy OrderIngredient
                    $orderIngredient = new OrderIngredient(
                        amountIngredient: $amountOfIngredients,
                        Ingredient: $ingredient,
                        Orders: $order);

                    $orderIngredient->getOrders()->addOrderIngredient($orderIngredient);
                    // Persistuj nowy OrderIngredient

                    $entityManager->persist($orderIngredient);

                    // Dodaj do przetworzonych składników
                    $this->processedIngredients[$data] = $orderIngredient;
                }
            }
        }
    }

}
