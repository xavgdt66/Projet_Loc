<?php
namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => false,  // Désactive l'étiquette à côté du champ
                'attr' => [
                    'placeholder' => 'Votre nom',
                ],
            ])
            ->add('email', EmailType::class, [
                'label' => false,  // Désactive l'étiquette à côté du champ
                'attr' => [
                    'placeholder' => 'Votre adresse email',
                ],
            ])
            ->add('message', TextareaType::class, [
                'label' => false,  // Désactive l'étiquette à côté du champ
                'attr' => [
                    'placeholder' => 'Votre message',
                    'rows' => 6,
                ],
            ])
        ;
    } 

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([]);
    }
}
