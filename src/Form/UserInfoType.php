<?php

namespace App\Form;

use App\Entity\UserInfo;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserInfoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        // Ajout des champs pour le formulaire d'inscription
        $builder
            ->add('lastname')
            ->add('firstname')
            ->add('pseudo')
            ->add('phone')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        // Définition de l'entité liée au formulaire
        $resolver->setDefaults([
            'data_class' => UserInfo::class,
        ]);
    }
}
