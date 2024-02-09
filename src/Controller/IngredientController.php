<?php

declare (strict_types = 1);

namespace App\Controller;

use App\DTO\BrowserDTO;
use App\DTO\IngredientsDTO;
use App\Form\BrowserFormType;
use App\Form\IngredientsFormType;
use App\Handler\Ingredient\CreateIngredient;
use App\Handler\Ingredient\UpdateIngredient;
use App\Provider\IngredientProvider;
use App\Repository\IngredientRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

// #[AsController('/products')]
class IngredientController extends AbstractController
{
    public function __construct(private readonly Security $security)
    {
    }
    #[Route('/ingredientsList', name: 'ingredient-list')]
    #[IsGranted('ROLE_ADMIN')]
    public function ingredients_list(Request $request, IngredientProvider $ingredientProvider): Response
    {
        $ingredients = $ingredientProvider->loadAll();
        $dto = new BrowserDTO();

        $form = $this->createForm(BrowserFormType::class, $dto);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if (empty($dto->browse_field)) {
                $ingredients = $ingredientProvider->loadAll();
            }else{
                $ingredients = $ingredientProvider->loadProductsByName($dto->browse_field);
            }
            
        }

        return $this->render('list/ingredientList.html.twig', [
            'articleForm' => $form->createView(),
            'ingredient' => $ingredients,
            'message' => 'Search ingredient'
        ]);
    }


    #[Route('/add-ingredient', name: 'create-ingredient')]
    public function createIngredient(
        CreateIngredient $createIngredient,
        Request $request
    ): Response {
        if (!$this->security->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('list');
        }
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $dto = new IngredientsDTO();
        $form = $this->createForm(IngredientsFormType::class, $dto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $createIngredient->create($dto);
            $this->addFlash('success', 'Product has been successfully created');

            return $this->redirectToRoute('list');
        }

        return $this->render('form/form.html.twig', [
            'articleForm' => $form->createView(),
            'message' => "Add ingredient",
        ]);
    }

    #[Route('/edit-ingredient/{id}', name: 'editIngredient')]
    public function update(
        string $id,
        Request $request,
        UpdateIngredient $updateIngredient,
        IngredientProvider $ingredientProvider,
    ): Response {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $ingredient = $ingredientProvider->loadIngredientById($id);

        $dto = IngredientsDTO::from($ingredient);

        $form = $this->createForm(IngredientsFormType::class, $dto);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $updateIngredient->update($ingredient, $dto);
            $this->addFlash('success', 'Product has been successfully edited');

            return $this->redirectToRoute('list');
        }

        return $this->render('form/form.html.twig', [
            'articleForm' => $form->createView(),
            'message' => "Edit",
        ]);
    }

    #[Route('/delete-ingredient/{id}', name: 'deleteIngredient')]
    public function delete(
        string $id,
        IngredientProvider $ingredientProvider,
        IngredientRepository $ingredientRepository,
    ): Response {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $ingredient = $ingredientProvider->loadIngredientById($id);

        $ingredientRepository->remove($ingredient);
        $this->addFlash('success', 'Product has been successfully deleted');

        return $this->redirectToRoute('list');
    }
}
