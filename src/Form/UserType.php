<?php

namespace App\Form;

use App\Entity\Allergens;
use App\Entity\Diet;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\SubmitButton;


class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email')
            ->add('roles', CollectionType::class, [
                'entry_type'   => ChoiceType::class,
                'entry_options'  => [
                    'choices'  => [
                        'ROLE_ADMIN' => 'ROLE_ADMIN',
                        'ROLE_USER'  => 'ROLE_USER',
                    ],
                    ]
                ])
            ->add('password')
            ->add('lastName')
            ->add('firstName')
            ->add('allergens', EntityType::class, [
                'class' => Allergens::class,
                'choice_label' => 'description',
                'multiple' => true,
            ])
            ->add('diet', EntityType::class, [
                'class' => Diet::class,
                'choice_label' => 'description',
                'multiple' => true,
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
