<?php

namespace App\Controller;

use App\Entity\Test;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OrderController extends AbstractController
{
    #[Route('/add-to-cart', name: 'add_to_cart', methods: ['POST'])]
    public function addToCart(EntityManagerInterface $entityManager, Request $request): JsonResponse
    {
        // Odczytaj dane przesłane w żądaniu POST
        $requestData = json_decode($request->getContent(), true);

        // Dostęp do przekazanej zmiennej "price"
        $price = $requestData['price'];

        $test = new Test();
        $test->setPrice($price);

        $entityManager->persist($test);
        $entityManager->flush();
        // Tutaj możesz przetworzyć zmienną "price" (np. dodać do koszyka)

        // Odpowiedź do klienta
        return new JsonResponse(['status' => 'success', 'price' => $price]);
    }
}
