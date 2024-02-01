<?php 

declare(strict_types=1);

namespace App\Provider;

use App\DTO\ProductDTO;
use App\Entity\Product;
use App\Repository\ProductQueryRepository;
use App\Repository\ProductRepository;

class ProductProvider
{
    public function __construct(
        private readonly ProductQueryRepository $productQueryRepository,
        ) {
    }

    public function loadProductById($productId):Product 
    {
        $product = $this->productQueryRepository->find($productId);

        if(!$product){
            throw new \InvalidArgumentException('Product not found');
        }
        
        return $product;

    }

    public function loadProductsByName($productName):array 
    {
        $product = $this->productQueryRepository->findBy(['name' => $productName]);


        if(!$product){
            throw new \InvalidArgumentException('Product not found');
        }
        
        return $product;

    }

    public function loadAll(): array 
    {
        $products = $this->productQueryRepository->findAll();
        
        return $products;
    }
}
