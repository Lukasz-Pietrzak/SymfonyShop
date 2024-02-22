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
    protected Order $order;
    protected array $orderSession;

    public function getOrder(){
        return $this->order;
    }

    public function getOrderSession(){
        return $this->orderSession;
    }

    public function create(OrderDTO $dto, string $productId, int $howManyClickPizza, string $sizeSave, array $dataToDatabase, SessionInterface $session): void
    {
        $this->order = new Order(
            orderPriceNetto: $dto->orderPriceNetto,
            orderPriceBrutto: $dto->orderPriceBrutto,
            orderPriceVAT: $dto->orderPriceVAT,
            Date: $dto->dateTime,
            User: $dto->user
        );

        $this->entityManager->persist($this->order);

        $this->createOrderProduct->create($productId, $howManyClickPizza, $sizeSave, $this->order, $this->entityManager);
        $this->createOrderIngredients->create($dataToDatabase, $this->order, $this->entityManager);

        if ($dto->user !== null) {
        $this->order->getUser()->addOrder($this->order);
        }else{
            $this->createSession($this->order, $session);
        }
        
        $this->entityManager->flush();
    }

    private function createSession(Order $order, SessionInterface $session): void
    {
        // Sprawdzenie, czy sesja już istnieje
        if ($session->has('order')) {
            // Pobranie aktualnych danych z sesji
            $this->orderSession = $session->get('order');
        } else {
            // Jeśli sesja nie istnieje, utwórz nową pustą tablicę
            $this->orderSession = array();
        }

        // Dodanie nowej wartości do tablicy orderSession
        $this->orderSession[] = $order;

        // Ustawienie tablicy orderSession w sesji
        $session->set('order', $this->orderSession);
    }

}
