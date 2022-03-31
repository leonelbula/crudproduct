<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class ProductController extends AbstractController {

    #[Route('/', name: 'app_product')]
    public function index(ManagerRegistry $doctrine): Response {
        $product = $doctrine->getRepository(Product::class);

        $product_list = $product->findAll();

        return $this->render('product/index.html.twig', [
                    'title' => 'Productos',
                    'product_list' => $product_list
        ]);
    }

    #[Route('/crearproducto', name: 'new_product')]
    public function create(Request $request, ManagerRegistry $doctrine): Response {
        $product = new Product();

        $form = $this->createForm(ProductType::class, $product);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $doctrine->getManager();
            $em->persist($product);
            $em->flush();

            return $this->redirectToRoute('app_product');
        }

        return $this->render('product/create.html.twig', [
                    'title' => 'Nuevo Producto',
                    'form' => $form->createView()
        ]);
    }

    #[Route('/verproducto/{id}', name: 'detail_producto')]
    public function details($id, ManagerRegistry $doctrine): Response {
        if (!$id) {
            return $this->redirectToRoute('app_product');
        }

        $em = $doctrine->getManager();

        $product_detail = $em->getRepository(Product::class)->find($id);

        return $this->render('product/detail.html.twig', [
                    'title' => 'Detalles Producto',
                    'product' => $product_detail
        ]);
    }

    #[Route('/editarproducto/{id}', name: 'edit_producto')]
    public function edit($id, Request $request, ManagerRegistry $doctrine): Response {
        if (!$id) {
            return $this->redirectToRoute('app_product');
        }
        $em = $doctrine->getManager();

        $product = $em->getRepository(Product::class)->find($id);

        $form = $this->createForm(ProductType::class, $product);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($product);
            $em->flush();

            return $this->redirectToRoute('app_product');
        }

        return $this->render('product/create.html.twig', [
                    'title' => 'Editar Producto',
                    'edit' => true,
                    'form' => $form->createView()
        ]);
    }

    #[Route('/delete/{id}', name: 'delete_product')]
    public function delete($id, ManagerRegistry $doctrine): Response {
        if (!$id) {
            return $this->redirectToRoute('app_product');
        }
        $em = $doctrine->getManager();

        $product = $em->getRepository(Product::class)->find($id);

        $em->remove($product);

        $em->flush();

        return $this->redirectToRoute('app_product');
    }

}
