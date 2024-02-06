<?php

declare (strict_types = 1);

namespace App\Handler\Order;

use App\Entity\OrderProduct;
use App\Provider\ProductProvider;

class createOrderProduct
{

    public function __construct(
        private readonly ProductProvider $productProvider,
    ) {
    }

    public function create($productId, $howManyClickPizza, $sizeSave, $order, $entityManager)
    {
        $product = $this->productProvider->loadProductById($productId);

        $orderProduct = new OrderProduct(
            amountProducts: $howManyClickPizza,
            size: $sizeSave,
            product: $product,
            Orders: $order);

        $orderProduct->getOrders()->addOrderProduct($orderProduct);
        
        $entityManager->persist($orderProduct);
        
    }

}
