<?php

declare (strict_types = 1);

namespace App\Controller;

use App\DTO\BrowserDTO;
use App\Form\BrowserFormType;
use App\Provider\ProductProvider;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;

#[AsController('/menu')]
class MenuController extends AbstractController
{
    public function __construct(private readonly Security $security)
    {
    }
    #[Route('/menu', name: 'ui_menu')]
    public function menu_list(Request $request, ProductProvider $productProvider): Response
    {
        $products = $productProvider->loadAll();
        $dto = new BrowserDTO();

        $form = $this->createForm(BrowserFormType::class, $dto);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if (empty($dto->browse_field)) {
                $products = $productProvider->loadAll();
            }else{
                $products = $productProvider->loadProductsByName($dto->browse_field);
            }
            
        }

        return $this->render('menu/menu.html.twig', [
            'articleForm' => $form->createView(),
            'product' => $products,
            'message' => 'Search product'
        ]);
    }
}