<?php

declare (strict_types = 1);

namespace App\Handler\Order;

use App\DTO\OrderDTO;
use App\Entity\Order;
use App\Entity\OrderIngredient;
use App\Entity\OrderProduct;
use App\Provider\IngredientProvider;
use App\Provider\ProductProvider;
use Doctrine\ORM\EntityManagerInterface;

class createOrder
{
    public function __construct(
        private readonly ProductProvider $productProvider,
        private readonly IngredientProvider $ingredientProvider,
        private readonly EntityManagerInterface $entityManager,
    ) {
    }

    public function create(OrderDTO $dto, $productId, $howManyClickPizza, $sizeSave, $dataToDatabase,  $user): void
    {
        $order = new Order(
            orderPriceNetto: $dto->orderPriceNetto,
            orderPriceBrutto: $dto->orderPriceBrutto,
            orderPriceVAT: $dto->orderPriceVAT,
        );

        $order->setUser($user);

        $product = $this->productProvider->loadProductById($productId);

        $orderProduct = new OrderProduct();
        $orderProduct->setProduct($product);
        $orderProduct->setOrders($order);
        $orderProduct->setQuantity($howManyClickPizza);
        $orderProduct->setSize($sizeSave);


//         foreach ($dataToDatabase as $data) {
//     // Sprawdź długość $data przed wywołaniem loadIngredientById
//     $dataLength = strlen($data);

//     // Wywołaj loadIngredientById tylko gdy długość jest większa od zera
//     if ($dataLength > 0) {
//         $ingredient = $this->ingredientProvider->loadIngredientById($data);
//         $orderIngredient = new OrderIngredient();
//         $orderIngredient->setIngredient($ingredient);
//         $orderIngredient->setOrder($order);
//         $orderIngredient->setQuantity(1);

//         // Persistuj ingredient tylko gdy długość jest większa od zera
//         // $order->addOrderIngredient($orderIngredient);
//         $this->entityManager->persist($orderIngredient);
//     }
// }


        $this->entityManager->persist($order);
        $this->entityManager->persist($orderProduct);

        $this->entityManager->flush();

    }

}
