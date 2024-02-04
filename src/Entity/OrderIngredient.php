<?php

namespace App\Entity;

use App\Repository\OrderIngredientRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Table;

#[Table('Order_ingredient')]
#[ORM\Entity(repositoryClass: OrderIngredientRepository::class)]
class OrderIngredient extends BaseEntity
{
    public function __construct(
        #[ORM\Column]
        private int $amountIngredient,
        #[ORM\ManyToOne(inversedBy: 'orderIngredients')]
        private Ingredients $Ingredient,
        #[ORM\ManyToOne(inversedBy: 'orderIngredients')]
        private Order $order
    )
    {

    }

    public function getId(): string
    {
        return $this->id;
    }


    public function getAmountIngredient(): int
    {
        return $this->amountIngredient;
    }

    public function setAmountIngredient(int $amountIngredient): void
    {
        $this->amountIngredient = $amountIngredient;

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
