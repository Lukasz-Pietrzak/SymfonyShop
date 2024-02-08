<?php 
// src/EventListener/OrderDeletedListener.php

namespace App\EventListener\OrderDeleted;

use App\Event\OrderDeletedEvent;
use App\Provider\OrderProvider;
use Doctrine\ORM\EntityManagerInterface;

class OrderDeletedListener
{
    private $orderProvider;
    private $entityManager;

    public function __construct(OrderProvider $orderProvider, EntityManagerInterface $entityManager)
    {
        $this->orderProvider = $orderProvider;
        $this->entityManager = $entityManager;
    }

    public function onOrderDeleted(OrderDeletedEvent $event)
    {
        $order = $event->getOrder();

        // Usuń produkty związane z zamówieniem
        $this->orderProvider->removeOrderProduct($order);

        // Usuń składniki związane z zamówieniem
        $this->orderProvider->removeOrderIngredient($order);

        // Usuń zamówienie z bazy danych
        $this->entityManager->remove($order);
        $this->entityManager->flush();

    }
}
