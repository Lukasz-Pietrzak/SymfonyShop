<?php

declare (strict_types = 1);

namespace App\Controller;

use App\DTO\ProductDTO;
use App\Form\ProductType;
use App\Handler\Product\Create;
use App\Handler\Product\Update;
use App\Provider\ProductProvider;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;

#[AsController('/products')]
class ProductController extends AbstractController
{
    public function __construct(private readonly Security $security)
    {
    }
    #[Route('/list', name: 'list')]
    public function products_list(ProductProvider $productProvider): Response
    {
        $products = $productProvider->loadAll();

        return $this->render('layout/list.html.twig', [
            'product' => $products,
        ]);
    }

    #[Route('/add-product', name: 'create')]
    public function create(
        Create $create,
        Request $request
    ): Response {
        if (!$this->security->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('list');
        }
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $dto = new ProductDTO();
        $form = $this->createForm(ProductType::class, $dto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $create->create($dto);
            $this->addFlash('success', 'Product has been successfully created');

            return $this->redirectToRoute('list');
        }

        return $this->render('layout/form.html.twig', [
            'articleForm' => $form->createView(),
            'message' => "Add",
        ]);
    }

    #[Route('/edit-product/{id}', name: 'edit')]
    public function update(
        string $id,
        Request $request,
        Update $update,
        ProductProvider $productProvider,
    ): Response {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $product = $productProvider->loadProductById($id);

        $dto = ProductDTO::from($product);

        $form = $this->createForm(ProductType::class, $dto);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $update->update($product, $dto);
            $this->addFlash('success', 'Product has been successfully edited');

            return $this->redirectToRoute('list');
        }

        return $this->render('layout/form.html.twig', [
            'articleForm' => $form->createView(),
            'message' => "Edit",
        ]);
    }

    #[Route('/delete-product/{id}', name: 'delete')]
    public function delete(
        string $id,
        ProductProvider $productProvider,
        ProductRepository $productRepository,
    ): Response {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $product = $productProvider->loadProductById($id);

        $productRepository->remove($product);
        $this->addFlash('success', 'Product has been successfully deleted');

        return $this->redirectToRoute('list');
    }
}
