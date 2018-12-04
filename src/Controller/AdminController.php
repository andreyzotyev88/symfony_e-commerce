<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\User;
use App\Form\UserType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class AdminController extends AbstractController
{

    public function index()
    {
        return $this->render('admin/index.html.twig', ["title"=>""
        ]);
    }

    public function tableView(Request $request,$table_name){
        $tablesResult = $this->getDoctrine()
            ->getRepository('App\Entity\\'.$table_name)
            ->findAll();
        if(empty($tablesResult)){
            throw $this->createNotFoundException(
                'No have element in this table: '.$table_name
            );
        }else{
            return $this->render('admin/table.html.twig', ["title"=> ucfirst(strtoupper($table_name)) , "tablesResult"=>$tablesResult
            ]);
        }
    }

    public function tableEdit(Request $request,$table_name,$id){
        echo "Edit";
        die();
    }

    public function tableNew(Request $request,$table_name){
        $form = $this->createForm('App\Form\\'.strtoupper(substr($table_name,"0","1")).substr($table_name,"1").'Type');
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $formData = $form->getData();
            $element = $this->getDoctrine()->getManager();
            $element->persist($formData);
            $element->flush();
            $this->addFlash('success','Saved');
            return $this->redirectToRoute('admin_table',array("table_name"=>$table_name));
        }
        return $this->render('admin/table.new.html.twig',
            ['add_form' => $form->createView(),'title' => 'Add new element in '.$table_name.' table.']);
    }
}
