<?php

declare (strict_types = 1);

namespace App\Handler\Order;

use App\DTO\OrderDTO;
use App\Entity\Order;
use App\Provider\IngredientProvider;
use App\Provider\ProductProvider;
use App\Repository\OrderRepository;
use Doctrine\ORM\EntityManagerInterface;

class createOrder
{
    public function __construct(
        private readonly ProductProvider $productProvider,
        private readonly IngredientProvider $ingredientProvider,
        private readonly EntityManagerInterface $entityManager,
    ) {
    }

    public function create(OrderDTO $dto, $productId, $dataToDatabase): void
    {
        $order = new Order(
            orderPriceNetto: $dto->orderPriceNetto,
            orderPriceBrutto: $dto->orderPriceBrutto,
            orderPriceVAT: $dto->orderPriceVAT,
        );

        $product = $this->productProvider->loadProductById($productId);
        $product->addOrder($order);

        
// Zakładam, że $dataToDatabase to tablica
foreach ($dataToDatabase as $data) {
    // Sprawdź długość $data przed wywołaniem loadIngredientById
    $dataLength = strlen($data);
    
    // Wywołaj loadIngredientById tylko gdy długość jest większa od zera
    if ($dataLength > 0) {
        $ingredient = $this->ingredientProvider->loadIngredientById($data);
        $ingredient->addOrder($order);

        // Persistuj ingredient tylko gdy długość jest większa od zera
        $this->entityManager->persist($ingredient);
    }
}

$this->entityManager->persist($order);
$this->entityManager->persist($product);

$this->entityManager->flush();

    }

}
