<?php

namespace App\Form;

use App\Entity\Post;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;



class PostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        //SE POT ADAUGA OPTIUNI IN CONTROLLER, IN TWIG SAU IN Form\PostType
        $builder
            ->add('title', TextType::class, [
                'attr' => [
                    'placeholder' => 'Enter the title here',
                    'class' => ''
                ] 
            ])
            ->add('description', TextareaType::class)
            ->add('category', EntityType::class, [
                'class' => 'App\Entity\Category'
            ])
            ->add('save', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-success'
                ]
            ])
        ;
    }

    //AICI SE LEAGA FORMULARUL DE CLASA POST
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Post::class,
        ]);
    }
}
