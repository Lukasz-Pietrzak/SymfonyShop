<?php

declare (strict_types = 1);

use App\Entity\Order;
use App\Entity\User;
use App\Provider\SessionProvider;
use Monolog\Test\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Session\Storage\MockArraySessionStorage;

final class SessionProviderTest extends TestCase
{
    protected $session;
    protected $sessionProvider;
    protected $requestStack;
    // Boot the Symfony kernel

    protected function setUp(): void
    {
        parent::setUp();
        $this->session = new Session(new MockArraySessionStorage());

        $request = $this->createMock(Request::class);
        // Mock the session for the request
        $session = $this->createMock(SessionInterface::class);
        // Set the session in the request
        $request->method('getSession')->willReturn($session);

        $this->requestStack = new RequestStack();
        // Push the mock request into the RequestStack
        $this->requestStack->push($request);

        // Instantiate the SessionProvider with the mock session object
        $this->sessionProvider = new SessionProvider($this->requestStack);
    }

    public function testRemoveSessionByOrderId(): void
    {
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
            orderPriceNetto: 33,
            orderPriceBrutto: 55,
            orderPriceVAT: 22,
            Date: $currentDatetime,
            User: $mockUser
        );

        $id = "018dc250-2b36-7748-a1a9-6e1e07903da6";
        $order->setId($id);

        $id2 = "820dvf-2b36-7748-a1a9-6e1e07903da6"; 
        $order2->setId($id2);

        $this->session->set('order', [$order2, $order]);
        $orderSession = $this->session->get('order', []);
        // var_dump($orderSession);
        // Wywołanie metody usuwającej sesję na podstawie identyfikatora zamówienia
        $this->sessionProvider->removeSessionByOrderId($order, $id, $orderSession); // corrected $this->sessionProvider

        $this->assertNotContains($order, $orderSession);
    
    }
}
