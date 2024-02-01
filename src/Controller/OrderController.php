<?php

namespace App\Controller;

use App\DTO\OrderDTO;
use App\Entity\Order;
use App\Entity\Product;
use App\Entity\Test;
use App\Handler\Order\createOrder;
use App\Provider\ProductProvider;
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

        $dto = new OrderDTO($priceNetto, $priceBrutto, $priceVAT);

        $createOrder->create($dto, $productId, $howManyClickPizza, $sizeSave, $dataToDatabase, $user);

        // Odpowiedź do klienta
        return new JsonResponse(['status' => 'success',
         'price' => $priceBrutto,
          'productId' => $productId,
           'howManyClickPizza' => $howManyClickPizza,
           'dataToDatabase' => $dataToDatabase
        ]);
    }
}
