<?php

declare (strict_types = 1);

namespace App\Handler\Product;

use App\DTO\ProductDTO;
use App\Entity\Price;
use App\Entity\Product;
use App\Handler\Interface\InterfaceCreate;
use App\Repository\ProductRepository;

class Create 
{
    public function __construct(
        private readonly ProductRepository $productRepository,
        ) {
    }

    public function create(ProductDTO $dto): void
    {
        $product = new Product(
            name: $dto->name,
            description: $dto->description,
            imageFile: $dto->imageFile,
            price: $this->createPrice($dto),
        );

        $this->productRepository->save($product);

    }

    private function createPrice(ProductDTO $dto): Price 
    {
        return new Price(
            priceNettoSmall: $dto->priceNettoSmall,
            priceBruttoSmall: $dto->priceBruttoSmall,
            vatSmall: $dto->vatSmall,
            priceNettoMedium: $dto->priceNettoMedium,
            priceBruttoMedium: $dto->priceBruttoMedium,
            vatMedium: $dto->vatMedium,
            priceNettoLarge: $dto->priceNettoLarge,
            priceBruttoLarge: $dto->priceBruttoLarge,
            vatLarge: $dto->vatLarge
        );
    }
}
