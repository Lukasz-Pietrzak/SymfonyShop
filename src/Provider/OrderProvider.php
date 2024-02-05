<?php 

declare(strict_types=1);

namespace App\Provider;

use App\Entity\Order;
use App\Entity\User;
use App\Repository\OrderQueryRepository;

class OrderProvider
{
    public function __construct(
        private readonly OrderQueryRepository $orderQueryRepository,
        ) {
    }

    public function loadOrderByUser(User $user): array 
    {
        $order = $this->orderQueryRepository->findBy(['user' => $user]);

        if(!$order){
            throw new \InvalidArgumentException('Order not found');
        }
        
        return $order;

    }

    // public function loadProductsByName($productName):array 
    // {
    //     $product = $this->productQueryRepository->findBy(['name' => $productName]);


    //     if(!$product){
    //         throw new \InvalidArgumentException('Product not found');
    //     }
        
    //     return $product;

    // }

    public function loadAll(): array 
    {
        $order = $this->orderQueryRepository->findAll();
        
        return $order;
    }
}
