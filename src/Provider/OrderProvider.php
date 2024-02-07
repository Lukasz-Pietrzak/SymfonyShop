<?php

declare (strict_types = 1);

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

        if (!$order) {
            throw new \InvalidArgumentException('Order not found');
        }

        return $order;

    }

    public function loadOrderById(string $orderId): Order
    {
        $order = $this->orderQueryRepository->find($orderId);

        if (!$order) {
            throw new \InvalidArgumentException('Order not found');
        }

        return $order;

    }

    public function removeOrderProduct(Order $order): void
    {
        foreach ($order->getOrderProduct() as $orderProduct) {
            $order->removeOrderProduct($orderProduct);
            $this->entityManager->remove($orderProduct);
        }

    }

    public function removeOrderIngredient(Order $order): void
    {
        foreach ($order->getOrderIngredient() as $orderIngredient) {
            $order->removeOrderIngredient($orderIngredient);
            $this->entityManager->remove($orderIngredient);
        }

    }

    public function loadAll(): array
    {
        $order = $this->orderQueryRepository->findAll();

        return $order;
    }
}
