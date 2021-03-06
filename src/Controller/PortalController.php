<?php

namespace App\Controller;

use App\Entity\News;
use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;

class PortalController extends AbstractController
{

    public function index()
    {
        $news = $this->getDoctrine()
            ->getRepository(News::class)
            ->findFewNews(3);
        $products = $this->getDoctrine()
            ->getRepository(Product::class)
            ->findFewProduct(4);
        return $this->render('portal/index.html.twig', [
            'h1'=>'Main page',
            'news'=>$news,
            'products'=>$products
        ]);
    }

    public function contact(Request $request)
    {
        $formSend = false;
        $form = $this->createForm('App\Form\FeedbackType');
        $form->add('submit',SubmitType::class)
            ->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $feedback = $form->getData();
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($feedback);
            $manager->flush();
            $this->addFlash('success','Saved');
            $formSend = true;
        }
        return $this->render('portal/contact.html.twig', [
            'h1'=>'Contact',
            'formFeedback'=>$form->createView(),
            'formSend'=>$formSend
        ]);
    }






}
