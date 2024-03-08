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
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Validator\Constraints\Regex;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email',  EmailType::class, [
                'required' => true,
                'constraints' => [
                    new Regex([
                        'pattern' => '/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/',
                        'message' => 'Veuillez entrer une adresse mail valide.'       
                    ])
                    ],
            ]
            )
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
                'by_reference' => false,
                'class' => Allergens::class,
                'choice_label' => 'description',
                'multiple' => true,
            ])
            ->add('diet', EntityType::class, [
                'by_reference' => false,
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
