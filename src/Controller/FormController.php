<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\PostType;
use App\Entity\Post;
use Symfony\Component\HttpFoundation\Request;


class FormController extends AbstractController
{
    /**
     * @Route("/form", name="form")
     */
    public function index(Request $request): Response
    {
        $post = new Post();
        //DACA am punce ceva info in $post atunci folmularul ar avea ceva 
             //date prepoulate
        //comanda asta (php bin/console make:form) face ce face $this->createFormBuilder()
        //$form = $this->createFormBuilder()
        
        //$post->setTitle("Formularul Unu");
        //$post->setDescription("Descrierea: Unu si jumatate");
        //SE POT ADAUGA OPTIUNI IN CONTROLLER, IN TWIG SAU IN Form\PostType
        $form = $this->createForm(PostType::class, $post,
                                 ['action' => $this->generateUrl('form'), // NUMELE RUTEI
                                 'method' => 'POST' ]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($post);
            $em->flush();
        }
        //Foloseste view: templates.form.index
        return $this->render('form/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
