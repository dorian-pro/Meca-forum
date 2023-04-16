<?php

namespace App\Form;

use App\Entity\Address;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        // Ajoute les champs du formulaire pour saisir la ville, le pays et le code postal de l'adresse
        $builder
            ->add('city')
            ->add('country')
            ->add('postalCode')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        // Configure les options par défaut pour le formulaire, en indiquant que le formulaire est lié à l'entité Address
        $resolver->setDefaults([
            'data_class' => Address::class,
        ]);
    }
}
