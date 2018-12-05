<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class PersonalController extends AbstractController
{
    public function index(){
        return $this->render('personal/index.html.twig', [
            'h1' => 'Personal section',
        ]);
    }

    public function basket()
    {
        return $this->render('personal/basket.html.twig', [
            'h1' => 'Basket',
        ]);
    }

    public function order()
    {
        return $this->render('personal/order.html.twig', [
            'h1' => 'Order',
        ]);
    }
}
