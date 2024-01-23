<?php 

declare(strict_types=1);

namespace App\Handler\Product;

use App\DTO\ProductDTO;
use App\Entity\Product;
use App\Handler\Interface\InterfaceUpdate;
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
        $product->setDescription($dto->description);
        
        if (!empty($dto->imageFile)) {
            $product->setImageFile($dto->imageFile);
        }
        
        // Small
        $product->getPrice()->setPriceNettoSmall($dto->priceNettoSmall);
        $product->getPrice()->setPriceBruttoSmall($dto->priceBruttoSmall);
        $product->getPrice()->setVatSmall($dto->vatSmall);
        
        // Medium
        $product->getPrice()->setPriceNettoMedium($dto->priceNettoMedium);
        $product->getPrice()->setPriceBruttoMedium($dto->priceBruttoMedium);
        $product->getPrice()->setVatMedium($dto->vatMedium);
        
        // Large
        $product->getPrice()->setPriceNettoLarge($dto->priceNettoLarge);
        $product->getPrice()->setPriceBruttoLarge($dto->priceBruttoLarge);
        $product->getPrice()->setVatLarge($dto->vatLarge);
        
        $this->productRepository->save($product);
        
    }
}