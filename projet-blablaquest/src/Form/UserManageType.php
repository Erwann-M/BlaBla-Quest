<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Range;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Positive;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class UserManageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'constraints' => [
                    new Email,
                    new NotBlank,
                ],
            ])
            // min 6 max 25
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options'  => ['label' => 'Mot de passe'],
                'second_options' => ['label' => 'Confirmez le mot de passe'],
                'invalid_message' => 'Les deux mots de passe doivent être identiques',
                'required' => false,
                'mapped' => false,
                'constraints' => [
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Mot de passe trop court (veuillez utiliser au minimum 6 caractères)',
                        'max' => 25,
                        'maxMessage' => 'Mot de passe trop long (25 caractères autorisés).'
                    ]),
                ]
            ])
            // min 4 max 15
            ->add('nickname', TextType::class, [
                'invalid_message' => 'Le pseudo doit être renseigné.',
                'label' => 'Pseudo',
                'required' => true,
                'constraints' => [
                    new NotBlank,

                    new Length([
                        'min' => 4,
                        'max' => 25
                    ]),
                ]
            ])
            ->add('roles', ChoiceType::class, [
                // Finalement on met le multiple à false
                // Mais pour que ça marche, on a besoin d'un DataTransformer
                'multiple' => false,
                'choices' => [
                    'Admin' => 'ROLE_ADMIN',
                    'Utilisateur' => 'ROLE_USER',
                ],
                'expanded' => true, // On veut des checkboxes, c'est plus user friendly
            ])
            ->add('file', FileType::class, [
                'mapped' => false,
                'required' => false,
            ])
            // min 1 max 101
            ->add('area', IntegerType::class, [
                'required' => true,
                'constraints' => [
                    new Positive(),
                    new NotBlank(),
                    new Range([
                        'min' => 1,
                        'max' => 101
                    ])

                ],
            ]);

        // Pour ajouter un DataTransformer sur un champs, il faut récupérer ce champs et lui appliquer 
        // la méthode addModerTransformer()
        $builder->get('roles')->addModelTransformer(new CallbackTransformer(
            // La fonction qui prend la donnée dans l'entité et la transforme dans le type du form
            function ($tagsAsArray) {
                // transform the array to a string
                // Même si getRoles() ajoute toujours ROLE_USER, on ne conserve que le premier role de l'utilisateur
                return $tagsAsArray[0];
            },
            // La fonction qui prend la donnée du form et la transforme pour être compatible avec l'entité
            function ($tagsAsString) {
                // transform the string back to an array
                // Le ChoiceType fournit une string, on a la met dans un tableau
                return [$tagsAsString];
            }
        ));
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
