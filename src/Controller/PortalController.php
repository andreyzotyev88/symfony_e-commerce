<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class PortalController extends AbstractController
{

    public function index()
    {
        return $this->render('portal/index.html.twig', [
            'h1'=>'Main page'
        ]);
    }

    public function contact()
    {
        return $this->render('portal/contact.html.twig', [
            'h1'=>'Contact'
        ]);    }






}
