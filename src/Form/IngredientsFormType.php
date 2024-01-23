<?php

namespace App\Form;

use App\DTO\IngredientsDTO;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class IngredientsFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('ingredient', TextType::class, [
            'constraints' => [new NotBlank()],
            'required' => false,
        ])
        ->add('priceNetto', NumberType::class, [
            'constraints' => [new NotBlank()],
            'required' => false,
        ])
        ->add('priceBrutto', NumberType::class, [
            'constraints' => [new NotBlank()],
            'required' => false,
        ])
        ->add('VAT', NumberType::class, [
            'constraints' => [new NotBlank()],
            'required' => false,
            'label' => 'VAT',
        ])
        ->add('category', ChoiceType::class, [
            'label' => 'Category',
            'choices' => [
                'Cheese' => 'cheese',
                'Cold Cut and Meat' => 'coldCutAndMeat',
                'Vegetable and Fruit' => 'vegetableAndFruit',
                'Spice' => 'spice',
                'Sausage' => 'sausage',
            ],
            'multiple' => false,
            'required' => false,
            'constraints' => [new NotBlank()],
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => IngredientsDTO::class,
        ]);
    }
}
