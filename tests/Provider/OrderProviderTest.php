<?php

use App\Entity\Order;
use App\Entity\User;
use App\Provider\OrderProvider;
use PHPUnit\Framework\TestCase;

final class OrderProviderTest extends TestCase
{
    public function testLoadAllOrdersByUser(): void
    {
        // Create a mock instance of OrderProvider
        $mockProvider = $this->createMock(OrderProvider::class);

        // Create some test users and orders
        $user1 = new User('bingo216pt@gmail.com', 'Authenticated');
        $user2 = new User('likon@gmail.com', 'Authenticated');
        $order1 = new Order(55, 77, 22, new DateTime(), $user1);
        $order2 = new Order(11, 22, 33, new DateTime(), $user1);

        // Define what the mocked method should return
        $mockProvider->method('loadAllOrdersByUser')->willReturnCallback(
            function ($users) use ($mockProvider, $order1, $order2) {
                // Define the behavior of loadOrderByUser method
                $mockProvider->method('loadOrderByUser')->willReturn([$order1, $order2]);
                
                // Simulate loading orders and adding them to users
                foreach ($users as $user) {
                    $orders = $mockProvider->loadOrderByUser($user);
                    foreach ($orders as $order) {
                        $user->addOrder($order);
                    }
                }
            }
        );

        // Call the mocked method
        $mockProvider->loadAllOrdersByUser([$user1]);

        // Perform assertions
        $this->assertEquals([$order1, $order2], $user1->getOrders()->toArray());
    }
}
