<?php

declare (strict_types = 1);

use App\Entity\Order;
use App\Entity\User;
use App\Provider\SessionProvider;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\RequestStack;

final class SessionProviderTest extends TestCase
{

    private SessionProvider $sessionProvider;

    protected function setUp(): void
    {
        parent::setUp();
        $mockRequestStack = $this->createMock(RequestStack::class);
        // Instantiate the SessionProvider with the mock session object
        $this->sessionProvider = new SessionProvider($mockRequestStack);
    }

    public function testRemoveSessionByOrderId(): void{
        $mockUser = $this->createMock(User::class);
        $currentDatetime = new DateTime();
        $order = new Order(
            orderPriceNetto: 55,
            orderPriceBrutto: 77,
            orderPriceVAT: 22,
            Date: $currentDatetime,
            User: $mockUser
        );

        $order2 = new Order(
            orderPriceNetto: 11,
            orderPriceBrutto: 22,
            orderPriceVAT: 11,
            Date: $currentDatetime,
            User: $mockUser
        );
    
        $id = "018dc250-2b36-7748-a1a9-6e1e07903da6";
        $order->setId($id);

        $id2 = "12dcfr-2b36-7748-a1a9-6e1e07903da6";
        $order2->setId($id2);
        
        $orderSession = [$order, $order2];

        // Wywołanie metody usuwającej sesję na podstawie identyfikatora zamówienia
        $this->sessionProvider->removeSessionByOrderId($order2, $id2, $orderSession); // corrected $this->sessionProvider
    
        $this->assertContains($order, $orderSession);      
}
}
