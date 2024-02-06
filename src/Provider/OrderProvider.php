<?php 

declare(strict_types=1);

namespace App\Provider;

use App\Entity\Order;
use App\Entity\User;
use App\Repository\OrderQueryRepository;
use Doctrine\ORM\EntityManagerInterface;

class OrderProvider
{
    public function __construct(
        private readonly OrderQueryRepository $orderQueryRepository,
        private readonly EntityManagerInterface $entityManager,
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

    public function loadOrderById(string $orderId): Order 
    {
        $order = $this->orderQueryRepository->find($orderId);

        if(!$order){
            throw new \InvalidArgumentException('Order not found');
        }
        
        return $order;

    }

    // public function loadOrderByUser(User $user): Order
    // {
    //     $queryBuilder = $this->entityManager->createQueryBuilder();
        
    //     $order = $queryBuilder->select('o', 'oi', 'op')
    //         ->from(Order::class, 'o')
    //         ->leftJoin('o.orderIngredients', 'oi')
    //         ->leftJoin('o.orderProducts', 'op')
    //         ->where('o.user = :user')
    //         ->setParameter('user', $user)
    //         ->getQuery()
    //         ->getSingleResult();
        
    //     if(!$order){
    //         throw new \InvalidArgumentException('Order not found');
    //     }
        
    //     return $order;
    // }
    

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
