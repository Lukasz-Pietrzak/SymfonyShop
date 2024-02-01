<?php
declare(strict_types=1);

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Table;

#[Table('ingredients')]
#[ORM\Entity()]
class Ingredients extends BaseEntity
{


    #[ORM\OneToMany(mappedBy: 'Ingredient', targetEntity: OrderIngredient::class)]
    private Collection $orderIngredients;

    public function __construct(#[ORM\Column(type: Types::STRING)]
    private ?string $ingredient = null, #[ORM\Column(type: Types::INTEGER)]
    private ?int $priceNetto = null, #[ORM\Column(type: Types::INTEGER)]
    private ?int $priceBrutto = null, #[ORM\Column(type: Types::INTEGER)]
    private ?int $VAT = null, #[ORM\Column(type: Types::STRING)]
    private ?string $category = null)
    {
        $this->orderIngredients = new ArrayCollection();
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getIngredient(): ?string
    {
        return $this->ingredient;
    }

    public function setIngredient(?string $ingredient): void
    {
        $this->ingredient = $ingredient;
    }

    public function getPriceNetto(): ?int
    {
        return $this->priceNetto;
    }

    public function setPriceNetto(?int $priceNetto): void
    {
        $this->priceNetto = $priceNetto;
    }

    public function getPriceBrutto(): ?int
    {
        return $this->priceBrutto;
    }

    public function setPriceBrutto(?int $priceBrutto): void
    {
        $this->priceBrutto = $priceBrutto;
    }

    public function getVAT(): ?int
    {
        return $this->VAT;
    }

    public function setVAT(?int $VAT): void
    {
        $this->VAT = $VAT;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(?string $category): void
    {
        $this->category = $category;
    }

    /**
     * @return Collection<int, OrderIngredient>
     */
    public function getOrderIngredients(): Collection
    {
        return $this->orderIngredients;
    }

    public function addOrderIngredient(OrderIngredient $orderIngredient): static
    {
        if (!$this->orderIngredients->contains($orderIngredient)) {
            $this->orderIngredients->add($orderIngredient);
            $orderIngredient->setIngredient($this);
        }

        return $this;
    }

    public function removeOrderIngredient(OrderIngredient $orderIngredient): static
    {
        if ($this->orderIngredients->removeElement($orderIngredient)) {
            // set the owning side to null (unless already changed)
            if ($orderIngredient->getIngredient() === $this) {
                $orderIngredient->setIngredient($this);
            }
        }

        return $this;
    }
    

}
