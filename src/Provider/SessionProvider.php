<?php

declare(strict_types=1);

namespace App\Provider;

use App\Entity\Order;
use Symfony\Component\HttpFoundation\RequestStack;

class SessionProvider
{
    private RequestStack $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    public function removeSessionByOrderId(Order $order, string $id): void
    {
        $request = $this->requestStack->getCurrentRequest();
        $session = $request->getSession();

        $orderSession = $session->get('order', []); // Pobierz tablicę z sesji, domyślnie pusta tablica, jeśli nie ma danych w sesji

        // Przeszukaj tablicę w poszukiwaniu obiektu o zadanym id i usuń ten obiekt
        foreach ($orderSession as $key => $order) {
            if ($order->getId() == $id) {
                unset($orderSession[$key]); // Usuń obiekt z tablicy
                break; // Przerwij pętlę, gdy obiekt zostanie znaleziony i usunięty
            }
        }

        // Zapisz zmodyfikowaną tablicę z powrotem do sesji
        $session->set('order', $orderSession);
    }
}
