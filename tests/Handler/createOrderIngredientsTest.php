<?php

use App\Entity\Order;
use App\Entity\User;
use App\Handler\Order\createOrderIngredients;
use App\Provider\IngredientProvider;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;

final class createOrderIngredientsTest extends TestCase
{
    protected Order $order;
    protected EntityManagerInterface $mockEntityManagerInterface;
    protected createOrderIngredients $createOrderIngredients;

    protected function setUp(): void
    {
        parent::setUp();
        $mockUser = $this->createMock(User::class);
        $currentDatetime = new DateTime();
        
        $this->order = new Order(
            orderPriceNetto: 55,
            orderPriceBrutto: 77,
            orderPriceVAT: 22,
            Date: $currentDatetime,
            User: $mockUser
        );

        $mockIngredientProvider = $this->createMock(IngredientProvider::class);

        $this->mockEntityManagerInterface = $this->createMock(EntityManagerInterface::class);
        
        $this->createOrderIngredients = new createOrderIngredients($mockIngredientProvider);
    }

    public function testCreate(): void
    {
        $dataToDatabase = ['018d5f6f-df1c-7c91-a277-65fa52ed9b9a', '018d5f70-9512-75e6-ad92-9848474c3769', '018d5f6f-df1c-7c91-a277-65fa52ed9b9a', '018d5f71-4234-791f-b813-47a0ed9a131e'];

        // Call the mocked method
        $this->createOrderIngredients->create($dataToDatabase, $this->order, $this->mockEntityManagerInterface);

        $howManyTheSameId = 2;
        // Perform assertions
        $this->assertEquals($this->createOrderIngredients->getProcessedIngredients()['018d5f6f-df1c-7c91-a277-65fa52ed9b9a']->getAmountIngredient(), $howManyTheSameId);
    }

    public function testCreateCollection(): void
    {
        $dataToDatabase = ['018d5f6f-df1c-7c91-a277-65fa52ed9b9a', '018d5f70-9512-75e6-ad92-9848474c3769', '018d5f6f-df1c-7c91-a277-65fa52ed9b9a', '018d5f71-4234-791f-b813-47a0ed9a131e'];

        // Call the mocked method
        $this->createOrderIngredients->create($dataToDatabase, $this->order, $this->mockEntityManagerInterface);
        // Perform assertions
        $this->assertNotEmpty(
            $this->createOrderIngredients->getProcessedIngredients()['018d5f6f-df1c-7c91-a277-65fa52ed9b9a']->getOrders()->getOrderIngredient()
        );
            }

}