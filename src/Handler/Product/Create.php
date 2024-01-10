<?php

declare (strict_types = 1);

namespace App\Handler\Product;

use App\DTO\ProductDTO;
use App\Entity\Price;
use App\Entity\Product;
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
            color: $dto->color,
            producent: $dto->producent,
            barcode: $dto->barcode,
            imageFile: $dto->imageFile,
            price: $this->createPrice($dto),
        );

        $this->productRepository->save($product);

    }

    private function createPrice(ProductDTO $dto): Price 
    {
        return new Price(
            priceNetto: $dto->price_netto,
            priceBrutto: $dto->price_brutto,
            vat: $dto->vat
        );
    }
}
