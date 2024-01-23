<?php

declare(strict_types=1);

namespace App\Controller;

use App\Provider\IngredientProvider;
use App\Provider\ProductProvider;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'ui_home')]
    public function homepage(IngredientProvider $ingredientProvider, ProductProvider $productProvider): Response
    {
        $ingredients = $ingredientProvider->loadAll();
        $products = $productProvider->loadAll();
        return $this->render('home/home.html.twig', [
            'ingredients' => $ingredients,
            'products' => $products,
        ]);
    }
}

