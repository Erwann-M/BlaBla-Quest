<?php

namespace App\Form;


use App\Entity\Game;
use App\Entity\Event;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class EventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom de l\'évènement',
                'invalid_message' => 'Le nom de l\'évènement doit être renseigné.',
                'required' => true,
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add('description', TextareaType::class, [
                'invalid_message' => 'La description de l\'évènement doit être renseigné.',
                'required' => true,
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add('dateTime', DateType::class, [
                'label' => 'Date de l\'évènement',
                'invalid_message' => 'La date de l\'évènement doit être renseigné.',
                'required' => true,
                'widget' => 'single_text',
            ])
            ->add('entrantsNumbers', IntegerType::class, [
                'label' => 'Nombre de participants maximum',
                'invalid_message' => 'La nombre de participants de l\'évènement doit être renseigné.',
                'required' => true,
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add('area', IntegerType::class, [
                'label' => 'Département',
                'invalid_message' => 'La localisation de l\'évènement doit être renseigné.',
                'required' => true,
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add('game', EntityType::class, [
                'label' => 'Jeu de l\'évènement',
                'invalid_message' => 'Le jeu de l\'évènement doit être renseigné.',
                'class' => Game::class,
                'choice_label' => 'name',
                'required' => true,
                'constraints' => [
                    new NotBlank(),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
        ]);
    }
}