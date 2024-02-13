<?php

namespace App\Controller;

use App\DTO\OrderDTO;
use App\Event\OrderDeletedEvent;
use App\Handler\Order\createOrder;
use App\Provider\OrderProvider;
use App\Provider\SessionProvider;
use App\Provider\UserProvider;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class OrderController extends AbstractController
{
    #[Route('/add-to-cart', name: 'add_to_cart', methods: ['POST'])]
    public function addToCart(createOrder $createOrder, Request $request, SessionInterface $session): JsonResponse
    {
        // Odczytaj dane przesłane w żądaniu POST
        $requestData = json_decode($request->getContent(), true);

        $VAT = 0.77;

        // Dostęp do przekazanej zmiennej "price"
        $priceBrutto = $requestData['price'];
        $priceNetto = $priceBrutto * $VAT;
        $priceVAT = $priceBrutto - $priceNetto;

        $jsonProductId = $requestData['productId'];

        $productId = trim($jsonProductId, '"');

        $howManyClickPizza = $requestData['howManyClickPizza'];
        $dataToDatabase = $requestData['dataToDatabase'];

        $sizeSave = $requestData['sizeSave'];

        $user = $this->getUser();

        $currentDateTime = new DateTime();

        $dto = new OrderDTO($priceNetto, $priceBrutto, $priceVAT, $currentDateTime, $user);

        $createOrder->create($dto, $productId, $howManyClickPizza, $sizeSave, $dataToDatabase, $session);

        // Odpowiedź do klienta
        return new JsonResponse(['status' => 'success',
            'price' => $priceBrutto,
            'productId' => $productId,
            'howManyClickPizza' => $howManyClickPizza,
            'dataToDatabase' => $dataToDatabase,
        ]);
    }

    #[Route('/shopping-cart', name: 'shopping_cart')]
    public function shoppingCart(OrderProvider $orderProvider, SessionInterface $session): Response
    {
        $user = $this->getUser();

        $totalPrice = 0;

        if ($user !== null) {
            $order = $orderProvider->loadOrderByUser($user);

            //Calculating total price from all order each user
            foreach ($order as $singleOrder) {
                $totalPrice += $singleOrder->getOrderPriceBrutto();
            }

            return $this->render('shoppingCart.html.twig', [
                'order' => $order,
                'totalPrice' => $totalPrice,
            ]);

        } else {
            $orderData = $session->get('order');

            if ($session->has('order')) {

                foreach ($orderData as $singleOrder) {
                    $totalPrice += $singleOrder->getOrderPriceBrutto();
                }
            }

            return $this->render('shoppingCart.html.twig', [
                'order' => $orderData,
                'totalPrice' => $totalPrice,
            ]);
        }
    }

    #[Route('/delete-order/{id}', name: 'delete_order')]
    public function delete(
        string $id,
        OrderProvider $orderProvider,
        EventDispatcherInterface $eventDispatcher,
        Security $security,
        UserProvider $userProvider,
        SessionProvider $sessionProvider
    ): Response {
        if (!$security->isGranted('ROLE_ADMIN')) {

            $order = $orderProvider->loadOrderById($id);
            $event = new OrderDeletedEvent($order);
            $eventDispatcher->dispatch($event, OrderDeletedEvent::NAME);

            $user = $this->getUser();

            if ($user === null) {
                $sessionProvider->removeSessionByOrderId($order, $id);
            }

            $this->addFlash('success', 'Order has been successfully deleted');
            return $this->redirectToRoute('shopping_cart');

        } elseif ($security->isGranted('ROLE_ADMIN')) {
            $user = $userProvider->loadUserById($id);

            $orders = $orderProvider->loadOrderByUser($user);

            $orderProvider->removeOrders($orders);

            $this->addFlash('success', 'Order has been successfully confirmed and deleted');
            return $this->redirectToRoute('order_list');
        }
    }

    #[Route('/order-list', name: 'order_list')]
    #[IsGranted('ROLE_ADMIN')]
    public function order_list(
        OrderProvider $orderProvider,
        UserProvider $userProvider,
    ): Response {
        $user = $userProvider->loadAll();

        $totalPrice = 0;
        $amountOrder = 0;

        $orderProvider->loadAllOrdersByUser($user, $totalPrice, $amountOrder);

        // Calculating total price from all order each user and how many orders are there
        foreach ($user as $singleOrder) {
            foreach ($singleOrder->getOrders() as $order) {
                $totalPrice += $order->getOrderPriceBrutto();
                $amountOrder++;
            }
        }

        return $this->render('list/orderList.html.twig', [
            'userek' => $user,
            'totalPrice' => $totalPrice,
            'amountOrder' => $amountOrder,
        ]);

    }
}
