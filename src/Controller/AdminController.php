<?php

namespace App\Controller;

use App\Entity\Roles;
use App\Service\StringConvertor;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminController extends AbstractController
{
    public function tableView(Request $request,StringConvertor $stringConvertor,$table_name)
    {
        $tablesResult = $this
            ->getDoctrine()
            ->getRepository($stringConvertor->tableNameToFullPath("App","Entity",$table_name))
            ->findAll();
        $empty = false;
        $tablesHeader = false;
        if(empty($tablesResult)){
            $empty = $table_name;
        }else{
            $tablesHeader = $tablesResult[0]->getAllNameValuesArrays();
        }
        return $this->render('admin/table.view.html.twig', [
            "empty" => false,
            "title"=> ucfirst(strtoupper($table_name)),
            "tablesResult"=>$tablesResult,
            "tablesHeader"=>$tablesHeader,
            "tableName"=>$table_name,
            "section_name" => "tables",
            "empty" => $empty
        ]);
    }

    public function tableEdit(Request $request,StringConvertor $stringConvertor,$table_name,$id){
        $object = $this->getDoctrine()
            ->getRepository($stringConvertor->tableNameToFullPath("App","Entity",$table_name))
            ->find($id);
        $form = $this->createForm($stringConvertor->tableNameToFullPath("App","Form",$table_name,"Type"),$object);
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
        return $this->render('admin/table.new.html.twig', [
            'add_form' => $form->createView(),
            'title' => 'Add new element in '.$table_name.' table.' ,
            'section_name' => "tables"
            ,"tableName"=>$table_name
        ]);
    }

    public function tableNew(Request $request,StringConvertor $stringConvertor,$table_name){
        $form = $this->createForm($stringConvertor->tableNameToFullPath("App","Form",$table_name,"Type"));
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
        return $this->render('admin/table.new.html.twig', [
            'add_form' => $form->createView(),
            'title' => 'Add new element in '.$table_name.' table.',
            "section_name" => "tables",
            "tableName"=>$table_name
        ]);
    }
}
