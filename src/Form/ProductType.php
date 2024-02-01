<?php

declare (strict_types = 1);

namespace App\Form;

use App\DTO\ProductDTO;
use App\Entity\Product;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Vich\UploaderBundle\Form\Type\VichImageType;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'constraints' => [new NotBlank()],
                'required' => false,
            ])
            ->add('description', TextareaType::class, [
                'constraints' => [new NotBlank()],
                'required' => false,
                'attr' => [
                    'style' => 'height: 150px;',
                ],
            ])
            
            
            
            ->add('priceNettoSmall', NumberType::class)
            ->add('priceBruttoSmall', NumberType::class)
            ->add('vatSmall', NumberType::class)
            // ... other fields ...
            ->add('priceNettoMedium', NumberType::class)
            ->add('priceBruttoMedium', NumberType::class)
            ->add('vatMedium', NumberType::class)
            // ... other fields ...
            ->add('priceNettoLarge', NumberType::class)
            ->add('priceBruttoLarge', NumberType::class)
            ->add('vatLarge', NumberType::class)
            ->add('imageFile', VichImageType::class, [
                'required' => false,
                'allow_delete' => false,
                // 'delete_label' => 'Remove Image',
                'image_uri' => true,
                'download_uri' => true,
                'asset_helper' => true,
                'constraints' => [
                    new NotBlank(['message' => 'Please upload an image file.']),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ProductDTO::class,
        ]);
    }
}
