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
    #[ORM\ManyToOne(inversedBy: 'Product')]
    private ?Order $orders = null;

    public function __construct(
        #[ORM\Column(type : Types::STRING)]
        private string $name,
        #[ORM\Column(type: Types::TEXT)]
        private string $description,
        #[ORM\OneToOne(targetEntity: Price::class, cascade: ["persist", "remove"], orphanRemoval: true)]
        private Price $price,
        // #[ORM\OneToOne(targetEntity: Ingredients::class, cascade: ["persist", "remove"], orphanRemoval: true)]
        // private Ingredients $ingredients,
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

    public function getPrice(): Price
    {
        return $this->price;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function setPrice(Price $price): void
    {
        $this->price = $price;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getOrders(): ?Order
    {
        return $this->orders;
    }

    public function setOrders(?Order $orders): static
    {
        $this->orders = $orders;

        return $this;
    }

}
