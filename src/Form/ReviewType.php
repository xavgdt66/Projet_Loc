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
        // activer/désactiver la protection CSRF pour ce formulaire
        'csrf_protection' => true,
        // le nom du champ HTML masqué qui stocke le jeton
        'csrf_field_name' => '_token',
        // une chaîne arbitraire utilisée pour générer la valeur du jeton
        // utiliser une chaîne différente pour chaque formulaire améliore sa sécurité
        'csrf_token_id'   => 'review_form',

    ]);
}
}
 