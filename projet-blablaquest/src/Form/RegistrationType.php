<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
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

class RegistrationType extends AbstractType
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
            ->add('password', PasswordType::class, [

                'required' => true,
                'mapped' => false,
                'constraints' => [
                    new NotBlank(),
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
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
