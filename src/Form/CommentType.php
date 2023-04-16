<?php

namespace App\Form;

use App\Entity\Comment;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class CommentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // Ajout du champ "comment" pour le commentaire général
        $builder
            ->add('comment', TextareaType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Votre commentaire',
                    'class' => 'form-control'
                ]
            ]);

        // Ajout d'un champ "comment_" pour chaque post spécifié dans les options
        foreach ($options['posts'] as $post) {
            $builder->add('comment_' . $post['id'], TextareaType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Votre commentaire',
                    'class' => 'form-control'
                ]
            ]);
        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        // Définition des options par défaut, dont la liste des posts passée en paramètre
        $resolver->setDefaults([
            'data_class' => Comment::class,
            'posts' => []
        ]);
    }
}