<?php
// src/Form/UserSearchType.php
namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, [
                'required' => false,
                
            ])
            ->add('search', SubmitType::class, []);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            // activer/désactiver la protection CSRF pour ce formulaire
            'csrf_protection' => true,
            // le nom du champ HTML masqué qui stocke le jeton
            'csrf_field_name' => '_token',
            // une chaîne arbitraire utilisée pour générer la valeur du jeton
            // utiliser une chaîne différente pour chaque formulaire améliore sa sécurité
            'csrf_token_id'   => 'search_form',

        ]);
    }
}
