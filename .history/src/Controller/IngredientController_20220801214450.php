<?php

namespace App\Controller;

use App\Entity\Ingredient;
use App\Form\IngredientType;
use App\Repository\IngredientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class IngredientController extends AbstractController
{
    /**
     * Undocumented function ( this function display all ingredients )
     *
     * @param IngredientRepository $repository
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */
    #[Route('/ingredient', name: 'ingredient_index', methods: ['GET'])]
    public function index(IngredientRepository $repository, PaginatorInterface $paginator, Request $request): Response
    {
        $ingredients = $paginator->paginate(
            $repository->findAll(), /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            10 /*limit per page*/
        );

        // $ingredients =  $repository->findAll();  
        // dd($ingredients);
        return $this->render('pages/ingredient/index.html.twig', [
            // 'controller_name' => 'IngredientController',
            'ingredients' => $ingredients,
        ]);
    }

    #[Route('/ingredient/nouveau', 'ingredient.new', methods:['GET','POST'])]
    public function new(
        Request $request,
        EntityManagerInterface $manager 
        ) : Response
    {
        $ingredient = new Ingredient();
        $form = $this->createForm(IngredientType::class, $ingredient);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $ingredient = $form->getData();
           
            $manager -> persist($ingredient);
            $manager -> flush();
            return $this->redirectToRoute('ingredient.index');

            $this->addFlash(
                'success',
                'Votre ingredient a été créé avec succes !'
            );

        } 

        return $this->render('pages/ingredient/new.html.twig', [
             'form' => $form->createView() 
     ]);
    }
}
