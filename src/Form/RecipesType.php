<?php

namespace App\Form;

use App\Entity\Allergens;
use App\Entity\Diet;
use App\Entity\Recipes;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

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
                'expanded' => true,
            ])
            ->add('diet', EntityType::class, [
                'class' => Diet::class,
                'choice_label' => 'description',
                'multiple' => true,
                'expanded' => true,
            ])
            ->add('imageFile', VichImageType::class, [
                'label' => 'Image : '
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Recipes::class,
        ]);
    }
}
