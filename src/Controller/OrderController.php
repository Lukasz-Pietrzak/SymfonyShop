<?php

namespace App\Controller;

use App\DTO\OrderDTO;
use App\Handler\Order\createOrder;
use App\Provider\OrderProvider;
use App\Repository\OrderIngredientRepository;
use App\Repository\OrderProductRepository;
use App\Repository\OrderQueryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OrderController extends AbstractController
{
    #[Route('/add-to-cart', name: 'add_to_cart', methods: ['POST'])]
    public function addToCart(createOrder $createOrder, Request $request): JsonResponse
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

        $dto = new OrderDTO($priceNetto, $priceBrutto, $priceVAT, $user);

        $createOrder->create($dto, $productId, $howManyClickPizza, $sizeSave, $dataToDatabase, $user);


        // Odpowiedź do klienta
        return new JsonResponse(['status' => 'success',
         'price' => $priceBrutto,
          'productId' => $productId,
           'howManyClickPizza' => $howManyClickPizza,
           'dataToDatabase' => $dataToDatabase
        ]);
    }

    #[Route('/shopping-cart', name: 'shopping_cart')]
    public function shoppingCart(OrderProvider $orderProvider): Response
    {
        $user = $this->getUser();        

        $order = $orderProvider->loadOrderByUser($user);

        $totalPrice = 0;

        //Calculating total price from all order each user
            foreach ($order as $singleOrder) {
                $totalPrice += $singleOrder->getOrderPriceBrutto();
            }

        return $this->render('shoppingCart.html.twig', [
            'order' => $order,
            'totalPrice' => $totalPrice
        ]);
    }

  
    #[Route('/delete-order/{id}', name: 'delete_order')]
    public function delete(
        string $id,
        OrderProvider $orderProvider,
        EntityManagerInterface $entityManager
    ): Response {
        $order = $orderProvider->loadOrderById($id);
    
        $orderProvider->removeOrderProduct($order);
        
        $orderProvider->removeOrderIngredient($order);

        $entityManager->remove($order);

        $entityManager->flush();
    
        $this->addFlash('success', 'Order has been successfully deleted');
    
        return $this->redirectToRoute('shopping_cart');
    }
}