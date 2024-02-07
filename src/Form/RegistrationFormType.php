<?php
// locataireformtype 
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
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class RegistrationFormType extends AbstractType 
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
            
           

            ->add('presentation', TextareaType::class, [
                'attr' => [
                    'rows' => 10, // Nombre de lignes dans le textarea
                    'cols' => 50  // Largeur du textarea
                ],
                // Les autres options comme 'required' peuvent être ajoutées ici
            ])
            
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
