<?php 
namespace App\tests\Handler\Order;

use App\DTO\OrderDTO;
use App\Handler\Order\createOrder;
use App\Provider\OrderProvider;
use App\Provider\UserProvider;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class createOrderTest extends KernelTestCase
{
    public function testCreateOrder(): void
    {
         // (1) boot the Symfony kernel
         self::bootKernel();

         // (2) use static::getContainer() to access the service container
         $container = static::getContainer();
 
         // (3) run some service & test the result
         $createOrder = $container->get(createOrder::class);
         $userProvider = $container->get(UserProvider::class);
        //  $mockUser = $this->createMock(User::class);
        $user = $userProvider->loadUserById('018d5f73-31f1-7c62-a262-711e88bb5cfc');

         $sessionInterface = $this->createMock(SessionInterface::class);

        $priceBrutto = 500;
        $priceNetto = 350;
        $priceVAT = $priceBrutto - $priceNetto;

        $productId = '018d61eb-ea4e-7293-af8b-e9063d353b8e';

        $howManyClickPizza = 5;

        $dataToDatabase = ['018d5f6f-df1c-7c91-a277-65fa52ed9b9a', '018d5f6f-df1c-7c91-a277-65fa52ed9b9a', '018d5f70-9512-75e6-ad92-9848474c3769'];

        $sizeSave = 'Small';

        $currentDateTime = new DateTime();

        $dto = new OrderDTO($priceNetto, $priceBrutto, $priceVAT, $currentDateTime, $user);

        $createOrder->create($dto, $productId, $howManyClickPizza, $sizeSave, $dataToDatabase, $sessionInterface);
 
        $this->assertNotEmpty($createOrder->getOrder()->getOrderIngredient());
        $this->assertNotEmpty($createOrder->getOrder()->getOrderProduct());
        $this->assertEquals($createOrder->getOrder()->getOrderPriceNetto(), $priceNetto);

    }

    public function testCreateSession(): void
    {
         // (1) boot the Symfony kernel
         self::bootKernel();

         // (2) use static::getContainer() to access the service container
         $container = static::getContainer();
 
         // (3) run some service & test the result
         $createOrder = $container->get(createOrder::class);
        //  $userProvider = $container->get(UserProvider::class);
        //  $mockUser = $this->createMock(User::class);
        $user = null;

         $sessionInterface = $this->createMock(SessionInterface::class);

        $priceBrutto = 500;
        $priceNetto = 350;
        $priceVAT = $priceBrutto - $priceNetto;

        $productId = '018d61eb-ea4e-7293-af8b-e9063d353b8e';

        $howManyClickPizza = 5;

        $dataToDatabase = ['018d5f6f-df1c-7c91-a277-65fa52ed9b9a', '018d5f6f-df1c-7c91-a277-65fa52ed9b9a', '018d5f70-9512-75e6-ad92-9848474c3769'];

        $sizeSave = 'Small';

        $currentDateTime = new DateTime();

        $dto = new OrderDTO($priceNetto, $priceBrutto, $priceVAT, $currentDateTime, $user);

        $createOrder->create($dto, $productId, $howManyClickPizza, $sizeSave, $dataToDatabase, $sessionInterface);
 
        // Pobranie tablicy orderSession
    $orderSessions = $createOrder->getOrderSession();
    
    // Iteracja po elementach tablicy
    foreach ($orderSessions as $orderSession) {
        // Sprawdzenie czy element tablicy jest obiektem
        if (is_object($orderSession)) {
            // Testowanie metody getOrderPriceNetto() na obiekcie
            $this->assertEquals($orderSession->getOrderPriceNetto(), $priceNetto);
        } else {
            // Jeśli element tablicy nie jest obiektem, wypisz błąd
            $this->fail('Element tablicy nie jest obiektem.');
        }
    }
    }
}