<?php

namespace App\Form;

use App\Entity\Game;
use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\Range;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Positive;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class GameType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', null, [
                'required' => true,
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add('description', null, [
                'required' => true,
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add('picture', FileType::class, [
                'mapped' => false,
                'required' => false,
            ])
            ->add('playtime', null, [
                'required' => true,
                'constraints' => [
                    new NotBlank(),
                ],
                'help' => 'Veuillez entrer un nombre supérieur à 0.'
            ])
            ->add('playersMin', IntegerType::class, [
                'required' => true,
                'constraints' => [
                    new Positive(),
                    new NotBlank(),
                    new Range([
                    'min' => 1,
                    'minMessage' => 'Le nombre de joueur minimum doit être positif.'])
                ],
                'help' => 'Veuillez entrer un nombre supérieur à 0'
            ])
            ->add('playersMax', IntegerType::class, [
                'required' => true,
                'constraints' => [
                    new Positive(),
                    new NotBlank(),
                    new Range([
                    'min' => 2,
                    'maxMessage' => 'Le nombre de joueur maximum doit être minimum 2.'])
                ],
                'help' => 'Veuillez entrer un nombre supérieur à 1'
            ])
            ->add('ageMin', IntegerType::class, [
                'required' => true,
                'constraints' => [
                    new Positive(),
                    new NotBlank(),
                    new Range([
                    'min' => 1,
                    'maxMessage' => 'L\'age minimum doit être supérieur à 0'])
                ],
                'help' => 'Veuillez entrer un nombre supérieur à 1'
            ])
            ->add('categories', EntityType::class, [
                'class' => Category::class,
                'multiple' => true,
                'choice_label' => 'name',
                'required' => true,
                'constraints' => [
                    new NotBlank(),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Game::class,
        ]);
    }
}
