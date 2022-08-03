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
     * Undocumented function ( this controller display all ingredients )
     *
     * @param IngredientRepository $repository
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */
    #[Route('/ingredient', name: 'ingredient.index', methods: ['GET'])]
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

     /**
      * This controller show a form wich create an ingredient
      *
      * @param Request $request
      * @param EntityManagerInterface $manager
      * @return Response
      */
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
            
            $this->addFlash(
                'success',
                'Votre ingredient a été créé avec succes !'
            );
            
            return $this->redirectToRoute('ingredient.index');
        } 

        return $this->render('pages/ingredient/new.html.twig', [
             'form' => $form->createView() 
     ]);
    }

    #[Route('/ingredient/edition/{id}', 'ingredient.edit', methods:['GET','POST'])]
    public function edit(IngredientRepository $repository,
             int $id, 
             Request $request,
             EntityManagerInterface $manager
             ) : Response{
                  $ingredient = $repository->findOneBy(["id" => $id]);
                  $form = $this->createForm(IngredientType::class, $ingredient);

                  $form->handleRequest($request);

                  if($form->isSubmitted() && $form->isValid()) {
                      $ingredient = $form->getData();
                     
                      $manager -> persist($ingredient);
                      $manager -> flush();
                      
                      $this->addFlash(
                          'success',
                          'Votre ingredient a été modifié avec succes !'
                      );
                      
                      return $this->redirectToRoute('ingredient.index');
                  } 

        return $this->render('pages/ingredient/edit.html.twig', [
            'form' => $form -> createView()
        ]);
    }

    #[Route('/ingredient/supression/{id}', 'ingredient.delete', methods:['POST'])]
    public function delete(EntityManagerInterface $manager, Ingredient $ingredient) : Response 
    {
        $manager->remove($ingredient);
        $manager->flush();
        $this->addFlash(
            'success',
            'Votre ingredient a été supprimé avec succes !'
        );

        return $this->redirectToRoute('ingredient.index');
    }
}
