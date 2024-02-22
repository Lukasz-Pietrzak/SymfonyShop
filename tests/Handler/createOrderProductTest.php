<?php

// use App\DTO\OrderDTO;
// use App\Entity\Order;
// use App\Entity\OrderProduct;
// use App\Entity\Product;
// use App\Entity\User;
// use App\Handler\Order\createOrder;
// use App\Handler\Order\createOrderIngredients;
// use App\Handler\Order\createOrderProduct;
// use App\Provider\IngredientProvider;
// use App\Provider\ProductProvider;
// use Doctrine\ORM\EntityManagerInterface;
// use phpDocumentor\Reflection\Types\This;
// use PHPUnit\Framework\TestCase;

// final class createOrderProductTest extends TestCase
// {
//     protected createOrderProduct $createOrderProduct;
//     protected Order $order;
//     protected EntityManagerInterface $entityManager;

//     protected function setUp(): void
//     {
//         parent::setUp();

//         $productProvider = $this->createMock(ProductProvider::class);
//         // Mocking ProductProvider to return a product for ID 33
//         $productProvider->method('loadProductById')->willReturn(new Product(55,));

//         $this->entityManager = $this->createMock(EntityManagerInterface::class);
//         $this->entityManager->expects($this->once())->method('persist');

//         $mockUser = $this->createMock(User::class);

//         $currentDatetime = new DateTime();

//         $this->order = new Order(
//             orderPriceNetto: 55,
//             orderPriceBrutto: 77,
//             orderPriceVAT: 22,
//             Date: $currentDatetime,
//             User: $mockUser
//         );

//         $this->createOrderProduct = new createOrderProduct($productProvider);
//     }

//     public function testCreateOrderProduct(): void
//     {
//         $productId = '33';
//         $howManyClickPizza = 5;
//         $sizeSave = 'Small';

//         // Expecting EntityManagerInterface's persist method to be called once

//         // Call the mocked method
//         $this->createOrderProduct->create($productId, $howManyClickPizza, $sizeSave, $this->order, $this->entityManager);

//         // Fetching the arguments passed to the persist method
//         $arguments = $this->getPersistArguments();
//         $this->assertInstanceOf(OrderProduct::class, $arguments[0]);
//         // Optionally, you can add further assertions to ensure the correctness of the created OrderProduct entity.
//     }

//     private function getPersistArguments(): array
//     {
//         return method_exists($this->entityManager, 'getExpectedArguments')
//             ? $this->entityManager->getExpectedArguments('persist')
//             : [];
//     }
// }
