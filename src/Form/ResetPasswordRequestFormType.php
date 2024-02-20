<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class ResetPasswordRequestFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'attr' => ['autocomplete' => 'email'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter your email',
                    ]),
                ],
            ])  
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            
            // activer/désactiver la protection CSRF pour ce formulaire
            'csrf_protection' => true,
            // le nom du champ HTML masqué qui stocke le jeton
            'csrf_field_name' => '_token',
            // une chaîne arbitraire utilisée pour générer la valeur du jeton
            // utiliser une chaîne différente pour chaque formulaire améliore sa sécurité
            'csrf_token_id'   => 'resset_password',

        ]);
    }
}
