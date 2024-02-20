<?php

use App\Entity\Ingredients;
use App\Entity\Order;
use App\Entity\OrderIngredient;
use App\Entity\User;
use App\Handler\Order\createOrderIngredients;
use App\Provider\IngredientProvider;
use App\Provider\OrderProvider;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;

final class createOrderIngredientsTest extends TestCase
{
    public function testCreate(): void
    {
        // Create a mock instance of OrderProvider
        $mockOrderIngredients = $this->createMock(createOrderIngredients::class);

        $mockOrder = $this->createMock(Order::class);

        $mockEntityManagerInterface = $this->createMock(EntityManagerInterface::class);

        $dataToDatabase = ['018d5f6f-df1c-7c91-a277-65fa52ed9b9a', '018d5f70-9512-75e6-ad92-9848474c3769', '018d5f6f-df1c-7c91-a277-65fa52ed9b9a', '018d5f71-4234-791f-b813-47a0ed9a131e'];


        $processedIngredients = [];

        // Define what the mocked method should return
        // $mockOrderIngredients->method('create')->willReturnCallback(
        //     function ($dataToDatabase, $order, $entityManager) use (&$processedIngredients) {
        //         // Define the behavior of loadOrderByUser method
        //         $amountOfIngredients = 1;

        //         foreach ($dataToDatabase as $data) {
        //             $dataLength = strlen($data);
        
        //             if ($dataLength > 0) {
        //                 $mockIngredientProvider = $this->createMock(IngredientProvider::class);
        //                 $mockIngredient = $this->createMock(Ingredients::class);

        //                 $mockIngredientProvider->method('loadIngredientById')->willReturn($mockIngredient);
                        
        //                 $ingredient = $mockIngredientProvider->loadIngredientById($data);
        
        //                 // Sprawdź, czy składnik został już przetworzony
        //                 if (isset($processedIngredients[$data])) {
        //                     // Jeżeli tak, zaktualizuj amountOfIngredients
        //                     $processedIngredients[$data]->setAmountIngredient($processedIngredients[$data]->getAmountIngredient() + 1);
        //                 } else {
        //                     // Jeżeli nie istnieje, utwórz nowy OrderIngredient
        //                     $orderIngredient = new OrderIngredient(
        //                         amountIngredient: $amountOfIngredients,
        //                         Ingredient: $ingredient,
        //                         Orders: $order);
        
        //                     // Persistuj nowy OrderIngredient
        //                     $entityManager->persist($orderIngredient);
        
        //                     // Dodaj do przetworzonych składników
        //                     $processedIngredients[$data] = $orderIngredient;
        //                 }
        //             }
        //         }
        //     }
        // );

        // Call the mocked method
        $mockOrderIngredients->create($dataToDatabase, $mockOrder, $mockEntityManagerInterface);

        // Perform assertions
        $this->assertEquals($processedIngredients['018d5f6f-df1c-7c91-a277-65fa52ed9b9a']->getAmountIngredient(), 2);
    }
}