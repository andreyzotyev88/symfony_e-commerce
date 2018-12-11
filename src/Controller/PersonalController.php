<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Basket;
use Symfony\Component\HttpFoundation\Request;

class PersonalController extends AbstractController
{
    public function index(){
        return $this->render('personal/index.html.twig', [
            'h1' => 'Personal section',
        ]);
    }

    public function basket(Request $request)
    {
        if ($idBasket = $request->request->get('id_delete')){
            $manager = $this
                ->getDoctrine()
                ->getManager();
            $oneBasket = $this
                ->getDoctrine()
                ->getRepository(Basket::class)
                ->findOneBy(array("id"=>$idBasket));
            $manager->remove($oneBasket);
            $manager->flush();
        }
        $basket = $this->getDoctrine()
            ->getRepository(Basket::class)
            ->findBy(array("user"=>$this->getUser()));
        return $this->render('personal/basket.html.twig', [
            'h1' => 'Basket',
            'basket' => $basket
        ]);
    }
}
