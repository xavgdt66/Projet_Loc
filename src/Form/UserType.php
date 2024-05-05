<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Composant\Formulaire\FormView;

use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
          


        if (in_array('ROLE_AGENCY', $options['user_roles'])) {
            $builder->add('nom_agence', TextType::class, [
                // vos options ici
            ])
                ->add('telephone', TextType::class, [
                    'attr' => ['class' => 'tinymce'],

                ])
                ->add('address', TextType::class, [
                    'attr' => ['class' => 'tinymce'],

                ])
                ->add('nom_agence', TextType::class, [
                    'attr' => ['class' => 'tinymce'],

                ])
                ->add('carte_professionnelle', TextType::class, [
                    'attr' => ['class' => 'tinymce'],

                ])
                ->add('siren', TextType::class, [
                    'attr' => ['class' => 'tinymce'],

                ])
                ->add('siret', TextType::class, [
                    'attr' => ['class' => 'tinymce'],

                ])
                ->add('kbis', TextType::class, [
                    'attr' => ['class' => 'tinymce'],

                ])
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
                ]);
        }

        if (in_array('ROLE_LOCATAIRE', $options['user_roles'])) {
            $builder
                
                ->add('first_name', TextType::class)
                ->add('last_name', TextType::class)
                ->add('presentation', TextType::class, [
                    'attr' => ['class' => 'tinymce'],

                ])

                ->add('telephone', TextType::class, [
                    'attr' => ['class' => 'tinymce'],

                ])
                ->add('address', TextType::class, [
                    'attr' => ['class' => 'tinymce'],

                ])
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
                ]);
        }
    }




    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class, 
            'user_roles' => [],
            // activer/désactiver la protection CSRF pour ce formulaire
            'csrf_protection' => true,
            // le nom du champ HTML masqué qui stocke le jeton
            'csrf_field_name' => '_token',
            // une chaîne arbitraire utilisée pour générer la valeur du jeton
            // utiliser une chaîne différente pour chaque formulaire améliore sa sécurité
            'csrf_token_id'   => 'user_type',
        ]);
    }
}
