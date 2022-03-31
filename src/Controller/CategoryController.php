<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController {

    #[Route('/categoria', name: 'app_category')]
    public function index(ManagerRegistry $doctrine): Response {
        $category_repo = $doctrine->getRepository(Category::class);

        $category_list = $category_repo->findAll();

        return $this->render('category/index.html.twig', [
                    'title' => 'categoria',
                    'category_list' => $category_list
        ]);
    }

    #[Route('/crearcategoria', name: 'new_category')]
    public function create(Request $request, ManagerRegistry $doctrine): Response {
        $category = new Category();

        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $doctrine->getManager();
            $em->persist($category);
            $em->flush();
            return $this->redirectToRoute('app_category');
        }

        return $this->render('category/create.html.twig', [
                    'title' => 'nueva categoria',
                    'form' => $form->createView()
        ]);
    }

}
