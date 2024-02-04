<?php

declare(strict_types=1);

namespace App\DTO;

use App\Entity\Order;
use App\Entity\User;
use Doctrine\Common\Collections\Collection;

class OrderDTO
{

    public function __construct(
        public int $orderPriceNetto,
        public int $orderPriceBrutto,
        public int $orderPriceVAT,
        public ?User $user = null,
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
