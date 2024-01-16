<?php

// src/Form/ReviewType.php
namespace App\Form;

use App\Entity\Review;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType; // Importez DateType
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ReviewType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
{
    $builder
        ->add('startDate', DateType::class, [
            'label' => 'Date d\'entrée du locataire (date indiquée sur le bail)',
             // Classe Bootstrap
            // autres options pour personnaliser le champ startDate
        ])
        ->add('endDate', DateType::class, [
            'label' => 'Date de fin du bail',
             // Classe Bootstrap
            // autres options pour personnaliser le champ endDate
        ])
        // Le champ 'rating' a été supprimé
        ->add('comment', TextareaType::class, [
            'label' => 'Commentaire',
            'attr' => ['class' => 'form-control'],
            'required' => false,
        ]);
}


    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Review::class,
        ]);
    }
}
 