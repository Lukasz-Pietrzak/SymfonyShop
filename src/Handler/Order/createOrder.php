<?php

declare (strict_types = 1);

namespace App\Handler\Order;

use App\DTO\OrderDTO;
use App\Entity\Order;
use App\Repository\OrderRepository;

class createOrder
{
    public function __construct(
        private readonly OrderRepository $orderRepository,
    ) {
    }

    public function create(OrderDTO $dto, $productId): void
    {
        $order = new Order(
            orderPriceNetto: $dto->orderPriceNetto,
            orderPriceBrutto: $dto->orderPriceBrutto,
            orderPriceVAT: $dto->orderPriceVAT,
        );

        // $order->addProductId($productId);

        // $order->addProductId($dto->productId);

        $this->orderRepository->save($order);
    }

}
