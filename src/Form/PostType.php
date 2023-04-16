<?php

namespace App\Form;

use App\Entity\Post;
use App\Entity\Vehicle;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class PostType extends AbstractType
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        // Ajoute les champs au formulaire
        $builder
            // Ajoute le champ "title"
            ->add('title')
            // Ajoute le champ "description"
            ->add('description')
            // Ajoute le champ "vehicle" de type "EntityType"
            ->add('vehicle', EntityType::class, [
                // Utilise l'entité "Vehicle" pour ce champ
                'class' => Vehicle::class,
                // Utilise la propriété "vehicle" de l'entité pour l'affichage des choix
                'choice_label' => 'vehicle',
                // Utilise la propriété "id" de l'entité pour la valeur des choix
                'choice_value' => 'id',
                // Ajoute un texte par défaut au champ
                'placeholder' => 'Choisir un véhicule',
                // Utilise une fonction pour construire la requête de sélection des choix
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('v')
                        ->orderBy('v.vehicle', 'ASC');
                }
            ])
            // Ajoute le champ "images" de type "FileType"
            ->add('images', FileType::class, [
                // Masque le label du champ
                'label' => false,
                // Autorise le téléchargement de plusieurs fichiers
                'multiple' => true,
                // Ne mappe pas le champ sur une propriété de l'entité
                'mapped' => false,
                // Rend le champ facultatif
                'required' => false,
                // Ajoute des attributs HTML au champ
                'attr' => [
                    // Autorise uniquement les fichiers d'image TODO a modifier le format autoriser
                    'accept' => 'image/*',
                    // Autorise le téléchargement de plusieurs fichiers
                    'multiple' => 'multiple'
                ]
            ])
            // Ajoute le bouton de soumission du formulaire
            ->add('submit', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Utilise l'entité "Post" pour le formulaire
            'data_class' => Post::class,
        ]);
    }
}
