<?php

declare (strict_types = 1);

namespace App\Handler\Order;

use App\DTO\OrderDTO;
use App\Entity\Order;
use App\Handler\Order\createOrderProduct;
use Doctrine\ORM\EntityManagerInterface;

class createOrder
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly createOrderProduct $createOrderProduct,
        private readonly createOrderIngredients $createOrderIngredients,
    ) {
    }

    public function create(OrderDTO $dto, $productId, $howManyClickPizza, $sizeSave, $dataToDatabase): void
    {
        $order = new Order(
            orderPriceNetto: $dto->orderPriceNetto,
            orderPriceBrutto: $dto->orderPriceBrutto,
            orderPriceVAT: $dto->orderPriceVAT,
            Date: $dto->dateTime,
            User: $dto->user
        );

        $this->entityManager->persist($order);

        $this->createOrderProduct->create($productId, $howManyClickPizza, $sizeSave, $order, $this->entityManager);
        $this->createOrderIngredients->create($dataToDatabase, $order, $this->entityManager);

        $this->entityManager->flush();

        dump($order);

    }
}
