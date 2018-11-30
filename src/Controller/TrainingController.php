<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class TrainingController extends AbstractController
{

    public function start()
    {
        return $this->render('training/start.html.twig', [
            'controller_name' => 'TrainingController::start',
        ]);
    }

    public function next()
    {
	return $this->render('training/next.html.twig',[
	    'controller_name' => 'TrainingController::next',
	]);
    }

    public function end()
    {
	return $this->render('training/end.html.twig',[
	    'controller_name' => 'TrainingController::end',
	]);
    }
}
