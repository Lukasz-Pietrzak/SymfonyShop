<?php

declare(strict_types=1);

namespace App\DTO;

use App\Entity\Product;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;
#[Vich\Uploadable]
class ProductDTO
{
    public string $name;
    public string $description;

    #[Vich\UploadableField(mapping: 'products', fileNameProperty: 'imageName')]
    public ?File $imageFile = null;
    public ?string $imageName = null;
    public ?int $priceNettoSmall = null;
    public ?int $priceBruttoSmall = null;
    public ?int $vatSmall = null;
    public ?int $priceNettoMedium = null;
    public ?int $priceBruttoMedium = null;
    public ?int $vatMedium = null;
    public ?int $priceNettoLarge = null;
    public ?int $priceBruttoLarge = null;
    public ?int $vatLarge = null;

    public static function from(Product $product): self
    {
        $dto = new self();
        $dto->name = $product->getName();
        $dto->description = $product->getDescription();
        $dto->imageName = $product->getImageName();
        $dto->priceNettoSmall = $product->getPrice()->getPriceNettoSmall();
        $dto->priceBruttoSmall = $product->getPrice()->getPriceBruttoSmall();
        $dto->vatSmall = $product->getPrice()->getVatSmall();
        $dto->priceNettoMedium = $product->getPrice()->getPriceNettoMedium();
        $dto->priceBruttoMedium = $product->getPrice()->getPriceBruttoMedium();
        $dto->vatMedium = $product->getPrice()->getVatMedium();
        $dto->priceNettoLarge = $product->getPrice()->getPriceNettoLarge();
        $dto->priceBruttoLarge = $product->getPrice()->getPriceBruttoLarge();
        $dto->vatLarge = $product->getPrice()->getVatLarge();

        return $dto;
    }

}
