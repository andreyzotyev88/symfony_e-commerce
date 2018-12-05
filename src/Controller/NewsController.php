<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class NewsController extends AbstractController
{
    public function news()
    {
        return $this->render('news/news.html.twig',[
            'h1'=>'News'
        ]);
    }

    public function newsDetail()
    {

    }
}
