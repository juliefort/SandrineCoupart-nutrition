<?php

namespace App\Form;

use App\Entity\allergens;
use App\Entity\diet;
use App\Entity\Recipes;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RecipesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('description')
            ->add('timeMade')
            ->add('restingTime')
            ->add('cookingTime')
            ->add('ingredients')
            ->add('steps')
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
            'data_class' => Recipes::class,
        ]);
    }
}
