<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Entity\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegisterController extends AbstractController
{
    /**
     * @Route("/register", name="register")
     */
    public function index(Request $request, UserPasswordEncoderInterface $encoder): Response
    {
        $form = $this->createFormBuilder()
                    ->add('username', TextType::class)
                    ->add('password', RepeatedType::class, [
                        'type' => PasswordType::class,
                        'required' => true,
                        'first_options' => [
                            'label' => 'Password',
                        ],
                        'second_options' => [
                            'label' => 'Confirm password'
                        ]
                    ])
                    ->add('register', SubmitType::class, [
                        'attr' => [
                            'class' => 'btn btn-success float-right'
                        ]])
                    ->getForm();

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
               $data = $form->getData();
               //$data = $request->request->getData();
                $user = new User();
                $user->setUsername($data['username']);
                $user->setPassword($encoder->encodePassword($user, $data['password']));
                $em = $this->getDoctrine()->getManager();
                $em->persist($user);
                $em->flush();
                return $this->redirect($this->generateUrl('app_login'));
            }
            
            return $this->render('register/index.html.twig', [
                'formular_reg' => $form->createView()
            ]);
        // return $this->render('register/index.html.twig', [
        //     'controller_name' => 'RegisterController',
        // ]);
    }
}
