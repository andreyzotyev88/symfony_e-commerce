<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Entity\User;
use App\Form\UserType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use App\Security\LoginFormAuthenticator;

class SecurityController extends AbstractController
{

    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error,'h1'=>'auth']);
    }

    public function register(Request $request,UserPasswordEncoderInterface $passwordEncoder,GuardAuthenticatorHandler $guardHandler , LoginFormAuthenticator $authenticator){
        $user = new User();
        $form = $this->createForm(UserType::class,$user);
        $form->add('Submit',SubmitType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $password = $passwordEncoder->encodePassword($user,$user->getPassword());
            $user->setPassword($password);
            $manager = $this
                ->getDoctrine()
                ->getManager();;
            $manager->persist($user);
            $manager->flush();
            return $guardHandler->authenticateUserAndHandleSuccess($user,$request,$authenticator,'main');
        }

        return $this->render('security/register.html.twig', [
            'h1'=>'Registration',
            'form'=> $form->createView()
        ]);
    }
}
