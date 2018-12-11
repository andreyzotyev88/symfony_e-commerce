<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Roles;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminController extends AbstractController
{
    public function tableView(Request $request,$table_name)
    {
        $tablesResult = $this
            ->getDoctrine()
            ->getRepository('App\Entity\\'.strtoupper(substr($table_name,0,1)).strtolower(substr($table_name,1)))
            ->findAll();
        if(empty($tablesResult)){
            return $this->render('admin/table.view.html.twig', [
                "empty" => $table_name,
                "section_name" => "tables",
                "tableName"=>$table_name,
                "title"=> ucfirst(strtoupper($table_name)),
            ]);
        }else{
            $tablesHeader = $tablesResult[0]->getAllNameValuesArrays();
            return $this->render('admin/table.view.html.twig', [
                "empty" => false,
                "title"=> ucfirst(strtoupper($table_name)),
                "tablesResult"=>$tablesResult,
                "tablesHeader"=>$tablesHeader,
                "tableName"=>$table_name,
                "section_name" => "tables",
            ]);
        }
    }

    public function tableEdit(Request $request,$table_name,$id){
        echo 'App\Entity\\'.strtoupper(substr($table_name,"0","1")).substr($table_name,"1");
        $object = $this->getDoctrine()
            ->getRepository('App\Entity\\'.strtoupper(substr($table_name,"0","1")).substr($table_name,"1"))
            ->find($id);
        $form = $this->createForm('App\Form\\'.strtoupper(substr($table_name,"0","1")).substr($table_name,"1").'Type',$object);
        $form->add('submit',SubmitType::class);
        if($table_name == "user"){
            $form->add('roles',EntityType::class,[
                'class'=> Roles::class,
                'choice_label'=> 'Name',
                'auto_initialize' => true
            ]);
        }
        $form->handleRequest($request);

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
        $form->add('submit',SubmitType::class);
        if($table_name == "user"){
            $form->add('roles',EntityType::class,[
                'class'=> Roles::class,
                'choice_label'=> 'Name',
                'auto_initialize' => true
            ]);
        }
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
            ['add_form' => $form->createView(),'title' => 'Add new element in '.$table_name.' table.' ,"section_name" => "tables","tableName"=>$table_name]);
    }
}
