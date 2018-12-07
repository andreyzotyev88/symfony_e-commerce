<?php

namespace App\Controller;

use App\Entity\News;
use App\Entity\Product;
use App\Entity\Category;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CatalogController extends AbstractController
{
    public function catalog()
    {
        $categories = $this
            ->getDoctrine()
            ->getRepository(Category::class)
            ->findAll();
        return $this->render('catalog/catalog.html.twig', [
            'h1'=>'Catalog',
            'categoriesList'=>$categories
        ]);
    }
    public function catalogDetail($product)
    {
        echo $product;
        die();
    }

    public function catalogSection(Request $request,$section,$page)
    {
       $productOnPage = 3;
       $offset = ($page-1)*$productOnPage;
       $categories = $this
            ->getDoctrine()
            ->getRepository(Category::class)
            ->findAll();
       $products = $this->getDoctrine()
           ->getRepository(Product::class)
           ->findAllProductBySectionSymlinkWithOffset($section,$offset,$productOnPage);

       $totalElement = $this->getDoctrine()
           ->getRepository(Product::class)
           ->countElement($section)[0]['count'];
       $maxPage = (int)($totalElement/$productOnPage);

       return $this->render('catalog/catalog.section.html.twig',[
          'h1'=>'Section:'.$products[0]->getCategory()->getTitle(),
           'productsList'=>$products,
           'section'=>$section,
           'curpage'=>$page,
           'maxpage'=>$maxPage,
           'categoriesList'=>$categories
       ]);
    }
}
