<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CatalogController extends AbstractController
{
    public function catalog()
    {
        return $this->render('catalog/catalog.html.twig', [
            'h1'=>'Catalog'
        ]);
    }
    public function catalogDetail()
    {

    }

    public function catalogSection()
    {

    }
}
