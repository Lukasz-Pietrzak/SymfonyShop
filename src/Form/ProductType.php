<?php

declare (strict_types = 1);

namespace App\Form;

use App\DTO\ProductDTO;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'constraints' => [new NotBlank()],
                'required' => false,
            ])
            ->add('color', TextType::class, [
                'constraints' => [new NotBlank()],
                'required' => false,
            ])
            ->add('producent', TextType::class, [
                'constraints' => [new NotBlank()],
                'required' => false,
            ])
            ->add('barcode', NumberType::class, [
                'constraints' => [new NotBlank()],
                'required' => false,
            ])
            ->add('price_netto', NumberType::class, [
                'constraints' => [new NotBlank()],
                'required' => false,
            ])
            ->add('price_brutto', NumberType::class, [
                'constraints' => [new NotBlank()],
                'required' => false,
            ])
            ->add('vat', NumberType::class, [
                'constraints' => [new NotBlank()],
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ProductDTO::class,
        ]);
    }
}
