<?php 

declare(strict_types=1);

namespace App\Handler\Product;

use App\DTO\ProductDTO;
use App\Entity\Product;
use App\Repository\ProductRepository;

class Update
{
    public function __construct(
        private readonly ProductRepository $productRepository,
        ) {
        }
    
    public function update(Product $product, ProductDTO $dto): void 
    { 
        $product->setName($dto->name);
        $product->setColor($dto->color);
        $product->setProducent($dto->producent);
        $product->setBarcode($dto->barcode);
        $product->getPrice()->setPriceNetto($dto->price_netto);
        $product->getPrice()->setPriceBrutto($dto->price_brutto);
        $product->getPrice()->setVat($dto->vat);

        $this->productRepository->save($product);
    }
}