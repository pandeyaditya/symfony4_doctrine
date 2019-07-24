<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Product;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends AbstractController
{

    /**
    * @Route("/product",name="create_product")
    * 
    */
    public function createProduct():Response{
        $entityManager = $this->getDoctrine()->getManager();
        $product = new Product();
        $product->setName('keyboard');
        $product->setPrice(2000);
        $entityManager->persist($product);
        $entityManager->flush();
        return new Response('Saved new Product with id '.$product->getId());
    }

    /**
    * @Route("/product/{id}", name="product_show")
    */
    public function show($id){
        $product = $this->getDoctrine()
                    ->getRepository(Product::class)
                    ->find($id);

        if(!$product){
            throw $this->createNotFoundException(
                'No product found for id'. $id
            );
        }

        return new Response('Check out this great product '.$product->getName());
    }

    /**
    * @Route("/products", name="products_all")
    */
    public function all(){
        $repository = $this->getDoctrine()
                    ->getRepository(Product::class);

        $products = $repository->findAll();

        return $this->render('product/products.html.twig', [
            'products' => $products,
        ]);
    }
}
