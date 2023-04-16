<?php

namespace App\Form;

use App\Entity\Passionate;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PassionateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('passionate', ChoiceType::class, [
                'choices' => [
                    'Automobile' => 'Automobile',
                    'Motocycle' => 'Motocycle',
                    'Poid lourd' => 'Poid lourd',
                    'Engin Nautique' => 'Engin Nautique',
                    'Engin agricole' => 'Engin agricole',
                    'Aviation' => 'Aviation'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Passionate::class,
        ]);
    }
}
