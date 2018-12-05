<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\User;
use App\Form\UserType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class AdminController extends AbstractController
{

    public function index()
    {
        echo "test";
        die();
        return $this->render('admin/index.html.twig', ["title"=>""
        ]);
    }

    public function tableView(Request $request,$table_name){
        $tablesResult = $this->getDoctrine()
            ->getRepository('App\Entity\\'.strtoupper(substr($table_name,0,1)).strtolower(substr($table_name,1)))
            ->findAll();
        $tablesHeader = $tablesResult[0]->getAllNameValuesArrays();
        if(empty($tablesResult)){
            throw $this->createNotFoundException(
                'No have element in this table: '.$table_name
            );
        }else{
            return $this->render('admin/table.html.twig', ["title"=> ucfirst(strtoupper($table_name)) , "tablesResult"=>$tablesResult , "tablesHeader"=>$tablesHeader , "tableName"=>$table_name , "section_name" => "tables"
            ]);
        }
    }

    public function tableEdit(Request $request,$table_name,$id){
        $object = $this->getDoctrine()
            ->getRepository('App\Entity\\'.strtoupper(substr($table_name,"0","1")).substr($table_name,"1"))
            ->find($id);
        $form = $this->createForm('App\Form\\'.strtoupper(substr($table_name,"0","1")).substr($table_name,"1").'Type',$object);
        $form->add('submit',SubmitType::class)
             ->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();
            $this->addFlash('success','Saved');
            return $this->redirectToRoute('admin_table',array("table_name"=>$table_name));
        }
        return $this->render('admin/table.new.html.twig',
            ['add_form' => $form->createView(),'title' => 'Add new element in '.$table_name.' table.' , "section_name" => "tables","tableName"=>$table_name]);
    }

    public function tableNew(Request $request,$table_name){
        $form = $this->createForm('App\Form\\'.strtoupper(substr($table_name,"0","1")).substr($table_name,"1").'Type');
        $form->add('submit',SubmitType::class)
             ->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $formData = $form->getData();
            $element = $this->getDoctrine()->getManager();
            $element->persist($formData);
            $element->flush();
            $this->addFlash('success','Saved');
            return $this->redirectToRoute('admin_table',array("table_name"=>$table_name));
        }

        return $this->render('admin/table.new.html.twig',
            ['add_form' => $form->createView(),'title' => 'Add new element in '.$table_name.' table.' ,"section_name" => "tables","tableName"=>$table_name]);
    }
}
