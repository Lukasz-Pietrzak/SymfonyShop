<?php

namespace App\Handler\Order;

use App\Entity\Order;
use App\Provider\OrderProvider;
use Doctrine\ORM\EntityManagerInterface;

class OrderRemover
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private OrderProvider $orderProvider)
    {
        $this->entityManager = $entityManager;
        $this->orderProvider = $orderProvider;
    }

    public function deleteOrders(array $orders): void
    {
        foreach ($orders as $order) {
            $this->removeOrder($order);
        }

        $this->entityManager->flush();
    }

    private function removeOrder(Order $order): void
    {
        // Usuń produkty związane z zamówieniem
        $this->orderProvider->removeOrderProduct($order);

        // Usuń składniki związane z zamówieniem
        $this->orderProvider->removeOrderIngredient($order);

        // Usuń zamówienie
        $this->entityManager->remove($order);
    }
}
