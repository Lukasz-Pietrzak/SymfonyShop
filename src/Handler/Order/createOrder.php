<?php

declare (strict_types = 1);

namespace App\Handler\Order;

use App\DTO\OrderDTO;
use App\Entity\Order;
use App\Handler\Order\createOrderProduct;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class createOrder
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly createOrderProduct $createOrderProduct,
        private readonly createOrderIngredients $createOrderIngredients,
    ) {
    }

    public function create(OrderDTO $dto, $productId, $howManyClickPizza, $sizeSave, $dataToDatabase, SessionInterface $session): void
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

        if ($dto->user == null) {
            $this->createSession($order, $session);
        }

        $this->entityManager->flush();
    }

    private function createSession(Order $order, SessionInterface $session): void
    {
        // Sprawdzenie, czy sesja już istnieje
        if ($session->has('order')) {
            // Pobranie aktualnych danych z sesji
            $orderSession = $session->get('order');
        } else {
            // Jeśli sesja nie istnieje, utwórz nową pustą tablicę
            $orderSession = array();
        }

        // Dodanie nowej wartości do tablicy orderSession
        $orderSession[] = $order;

        // Ustawienie tablicy orderSession w sesji
        $session->set('order', $orderSession);
    }

}
