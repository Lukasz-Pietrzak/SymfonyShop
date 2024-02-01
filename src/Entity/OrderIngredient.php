<?php

namespace App\Entity;

use App\Repository\OrderIngredientRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Table;

#[Table('Order_ingredient')]
#[ORM\Entity(repositoryClass: OrderIngredientRepository::class)]
class OrderIngredient extends BaseEntity
{
    #[ORM\Column]
    private int $Quantity;

    #[ORM\ManyToOne(inversedBy: 'orderIngredients')]
    private Ingredients $Ingredient;

    #[ORM\ManyToOne(inversedBy: 'orderIngredients')]
    private Order $order;

    public function __construct()
    {
    }

    public function getId(): string
    {
        return $this->id;
    }


    public function getQuantity(): int
    {
        return $this->Quantity;
    }

    public function setQuantity(int $Quantity): void
    {
        $this->Quantity = $Quantity;

    }

    public function getIngredient(): Ingredients
    {
        return $this->Ingredient;
    }

    public function setIngredient(Ingredients $Ingredient): void
    {
        $this->Ingredient = $Ingredient;

    }

    public function getOrder(): Order
    {
        return $this->order;
    }

    public function setOrder(Order $order): void
    {
        $this->Ingredient = $order;

    }

}
