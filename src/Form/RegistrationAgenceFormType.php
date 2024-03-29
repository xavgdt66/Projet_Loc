<?php
// agence formtype 
namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;

class RegistrationAgenceFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email')
            ->add('profilePicture', FileType::class, [
                'label' => 'Profile Picture',
                'mapped' => false, // Le champ n'est pas lié à une propriété de l'entité User
                'required' => false, // Rendre le champ facultatif
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                            'image/gif', // Ajoutez les types de fichiers supplémentaires ici
                        ],
                        'mimeTypesMessage' => 'Please upload a valid image file',
                    ])
                ],
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
            /* ->add('kbis', FileType::class, [
                // Set required to true if necessary
                'required' => true,
                // Add validation constraints as needed
                'constraints' => [
                    new File([
                        'maxSize' => '10M', // Adjust max size as needed
                        'mimeTypes' => ['application/pdf'], // Restrict to PDFs
                    ]),
                ],
                // Customize attributes (optional)
                'attr' => [
                    'class' => 'form-control-file',
                ],
            ])*/
            ->add('kbis', FileType::class, [
                'label' => 'kbis (PDF file)',

                // unmapped means that this field is not associated to any entity property
                'mapped' => false,

                // make it optional so you don't have to re-upload the PDF file
                // every time you edit the Product details
                'required' => false,

                // unmapped fields can't define their validation using attributes
                // in the associated entity, so you can use the PHP constraint classes
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'application/pdf',
                            'application/x-pdf',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid PDF document',
                    ])
                ],
            ])


            ////////////////////////////   

            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'You should agree to our terms.',
                    ]),
                ],
            ])
            ////////////////////////////
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
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void 
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            // activer/désactiver la protection CSRF pour ce formulaire
            'csrf_protection' => true,
            // le nom du champ HTML masqué qui stocke le jeton
            'csrf_field_name' => '_token',
            // une chaîne arbitraire utilisée pour générer la valeur du jeton
            // utiliser une chaîne différente pour chaque formulaire améliore sa sécurité
            'csrf_token_id'   => 'register_form_agency',

        ]);
    }
}
