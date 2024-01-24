<?php

declare(strict_types=1);

namespace App\DTO;

use App\Entity\Order;

class OrderDTO
{

    public function __construct(
        public int $orderPriceNetto,
        public int $orderPriceBrutto,
        public int $orderPriceVAT,
        // public string $productId
    ){

    }

    // public static function from(Order $order): OrderDTO
    // {
    //     return new self(
    //         $order->getOrderPriceNetto(),
    //         $order->getOrderPriceBrutto(),
    //         $order->getOrderPriceVAT()        );
    // }
}
