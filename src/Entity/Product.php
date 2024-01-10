<?php

declare (strict_types = 1);

namespace App\Entity;

use App\Entity\Price;
use App\Repository\ProductRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Table;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[Table('product')]
#[Vich\Uploadable]
#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product extends BaseEntity
{
    public function __construct(
        #[ORM\Column(type : Types::STRING)]
        private string $name,
        #[ORM\Column(type: Types::STRING)]
        private string $color,
        #[ORM\Column(type: Types::STRING)]
        private string $producent,
        #[ORM\Column(type: Types::INTEGER)]
        private int $barcode,
        #[ORM\OneToOne(targetEntity: Price::class, cascade: ["persist", "remove"], orphanRemoval: true)]
        private Price $price,
        #[Vich\UploadableField(mapping: 'products', fileNameProperty: 'imageName', size: 'imageSize')]
        private ?File $imageFile = null,
        #[ORM\Column(nullable: true)]
        private ?string $imageName = null,
        #[ORM\Column(nullable: true)]
        private ?int $imageSize = null,
        #[ORM\Column(nullable: true)]
        private ?\DateTimeImmutable $updatedAt = null,
    ) {
    }

    // #[ORM\Column(nullable: true)]
    // private ?string $imageName = null;
    // #[ORM\Column(nullable: true)]
    // private ?int $imageSize = null;
    // #[ORM\Column(nullable: true)]
    // private ?\DateTimeImmutable $updatedAt = null;

    public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;

        if (null !== $imageFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImageName(?string $imageName): void
    {
        $this->imageName = $imageName;
    }

    public function getImageName(): ?string
    {
        return $this->imageName;
    }

    public function setImageSize(?int $imageSize): void
    {
        $this->imageSize = $imageSize;
    }

    public function getImageSize(): ?int
    {
        return $this->imageSize;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getColor(): string
    {
        return $this->color;
    }

    public function getProducent(): string
    {
        return $this->producent;
    }

    public function getBarcode(): int
    {
        return $this->barcode;
    }

    public function getPrice(): Price
    {
        return $this->price;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function setColor(string $color): void
    {
        $this->color = $color;
    }

    public function setProducent(string $producent): void
    {
        $this->producent = $producent;
    }

    public function setBarcode(int $barcode): void
    {
        $this->barcode = $barcode;
    }

    public function setPrice(Price $price): void
    {
        $this->price = $price;
    }

}
