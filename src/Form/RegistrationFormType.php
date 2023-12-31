<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email')
            /*->add('profile_picture', VichFileType::class, [
                'required' => false,
                'allow_delete' => true,
                'download_uri' => true,
                'label' => 'Choisir un fichier',
            ])*/
            ->add('brochure', FileType::class, [
                'label' => 'Brochure (PNG file)',
            
                // unmapped means that this field is not associated to any entity property
                'mapped' => false,
            
                // make it optional so you don't have to re-upload the file
                // every time you edit the Product details
                'required' => false,
            
                // unmapped fields can't define their validation using attributes
                // in the associated entity, so you can use the PHP constraint classes
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/png',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid PNG image',
                    ])
                ],
            ])
            

            ->add('presentation')
            ->add('first_name')
            ->add('last_name')
            ->add('telephone')
            ->add('address')
            ->add('employement_status', ChoiceType::class, [
                'choices'  => [
                    "CDI (hors période d'essai)" => 'cdi_outsidfse_trial',
                    "CDI (en période d'essai)" => 'cdi_trial',
                    'CDD' => 'cdd',
                    "Intérimaire" => 'temporary',
                    "Indépendant / Freelance" => 'freelance',
                    'Fonctionnaire' => 'civil_servant',
                    "Sans emploi" => 'unemployed',
                    "Chômeur·se" => 'job_seeker',
                    'Retraité·e' => 'retired',
                    "Étudiant·e" => 'student',
                    "Alternant·e" => 'apprentice',
                    'Stagiaire' => 'intern',
                ],
            ])
            
            ->add('net_income')
            ->add('guarantee', ChoiceType::class, [
                'choices'  => [
                    "Aucun garant" => 'no_guarantor',
                    "Proche(s) se portant garant" => 'relative_guarantor',
                    'Assurance/Banque' => 'insurance_bank',
                    'Garantie visale' => 'guarantee_visale',
                ],
            ])
            




            ->add('agreeTerms', CheckboxType::class, [
                                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'You should agree to our terms.',
                    ]),
                ],
            ])
            ->add('plainPassword', PasswordType::class, [
                                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
