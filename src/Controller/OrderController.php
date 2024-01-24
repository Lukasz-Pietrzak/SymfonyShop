<?php

namespace App\Controller;

use App\DTO\OrderDTO;
use App\Entity\Order;
use App\Entity\Product;
use App\Entity\Test;
use App\Handler\Order\createOrder;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OrderController extends AbstractController
{
    #[Route('/add-to-cart', name: 'add_to_cart', methods: ['POST'])]
    public function addToCart(EntityManagerInterface $entityManager, createOrder $createOrder, Request $request): JsonResponse
    {
        // Odczytaj dane przesłane w żądaniu POST
        $requestData = json_decode($request->getContent(), true);

        $VAT = 0.77;

        // Dostęp do przekazanej zmiennej "price"
        $priceBrutto = $requestData['price'];
        $priceNetto = $priceBrutto * $VAT;
        $priceVAT = $priceBrutto - $priceNetto;

        $productId = $requestData['productId'];

//         $order = $entityManager->getRepository(Order::class)->find($requestData['orderId']);

// // Stwórz nowy obiekt Product na podstawie productId (zakładam, że productId jest dostępne w $requestData)
// $product = $entityManager->getRepository(Product::class)->find($requestData['productId']);


        $dto = new OrderDTO($priceNetto, $priceBrutto, $priceVAT);

        $createOrder->create($dto, $productId);


        // Tutaj możesz przetworzyć zmienną "price" (np. dodać do koszyka)

        // Odpowiedź do klienta
        return new JsonResponse(['status' => 'success', 'price' => $priceBrutto, 'productId' => $productId]);
    }
}
