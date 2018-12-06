<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\News;
use Symfony\Component\HttpFoundation\Request;

class NewsController extends AbstractController
{
    public function news(Request $request,$page)
    {
        $limitOnPage = 3;
        $newsList = $this->getDoctrine()
            ->getRepository(News::class)
            ->findAllForCurPage($limitOnPage,$page);
        $elementCount = $this->getDoctrine()
            ->getRepository(News::class)
            ->countElement();
        $totalPageNumber = (int)(($elementCount / $limitOnPage) +1);
        return $this->render('news/news.html.twig',[
            'h1'=>'News',
            'news_array'=>$newsList,
            'totalPageNumber' =>$totalPageNumber,
            'currentPage'=>$page
        ]);
    }

    public function newsDetail(Request $request,$symlink)
    {
        $newsDetailObject = $this->getDoctrine()
            ->getRepository(News::class)
            ->getBySymlink($symlink);
        return $this->render('news/news.detail.twig',[
            'h1'=>$newsDetailObject->getTitle(),
            'newsObject'=>$newsDetailObject
        ]);

    }
}
