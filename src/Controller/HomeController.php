<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Post;
use App\Form\PostType;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @Route("/home", name="home.") //nu are efect asupra rutes.yaml
 */
class HomeController extends AbstractController
{
    /**
     * @Route("/index", name="index")
     */
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    // Am folosit config - routes.yaml
    // /**
    //  * @Route("/helloUser/{name?}", name="hello_user", methods={"POST"})
    //  */

    public function helloUser(Request $request, $name)
    {
        //fie folosim request ($request->get('name')) sau argumant al functiei
        //return new Response("gicu"); //- afiseaza gicu 
        //$form = $this->createFormBuilder();

        $person = [
            'nume' => 'Cineva',
            'prenume' => 'Important',
            'varsta' => 35
        ];

        return $this->render("home/greet.html.twig", [
            'name' => $name,
            //'formular' => $form
            'persoana' => $person
        ]);
    }

    /**
     * @Route("/newPost", name="newPost")
     */

    public function newpost(Request $request, EntityManagerInterface $em)
    {
        $post = new Post();

        $form = $this->createForm(PostType::class, $post);

        $form->handleRequest($request);

       if ($form->isSubmitted())
       {
            $em->persist($post);
            $em->flush();
       }

        return $this->render("home/newpost.html.twig", [
            'formular' => $form->createView()
        ]);
    }

    /**
     * @Route("/formular", name="formular")
     */
    public function formular()
    {
        //comanda asta (php bin/console make:form) face ce face $this->createFormBuilder()
        $form = $this->createFormBuilder()->add("numeintreg")->getForm();
        $post = new Post();
        $post->setTitle("Overseas media");
        $post->setDescription("Youtube channel for all the diverse stuff");
        // - insert in DB
        // Entity Manager
        $em = $this->getDoctrine()->getManager();
        //creaza sql
        $em->persist($post);
        //$em->remove();
        $em->flush();
        return $this->render("home/formular.html.twig",[
            'formular' => $form->createView()
        ]);
    }

    /**
     * @Route("/entitati", name="entitati")
     */
    public function entitati()
    {
        $em = $this->getDoctrine()->getManager();
        //$receivedPost = $em->getRepository(Post::class)->findAll();
        //$receivedPost = $em->getRepository(Post::class)->findBy(['id' => 1]);
        //$retrieved = $em->getRepository(Post::class)->findOneBy(['id' => 1]);
        
        $retrieved = $em->getRepository('App\Entity\Post')->findOneBy(['id' => 1]);
        //$em->remove($retrieved); $em->flush();
        return $this->render("home/entitati.html.twig",[
            'post' => $retrieved
        ]);
    }

    /**
     * @Route("/showPost/{id}", name="show_post" )
     */

    public function showPost(Request $request, Post $post) 
    {
        // return new Response( $this->render('home/show_post.html.twig', [
        //     'post' => $post
        // ] ));
        return $this->render('home/show_post.html.twig', [
            'post' => $post
        ]);
    }
}
