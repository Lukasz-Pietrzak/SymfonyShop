<?php

declare (strict_types = 1);

namespace App\Form;

use App\DTO\ProductDTO;
use App\Entity\Product;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
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
            ])
            // ->add('imageName')
            // ->add('imageSize')
            // ->add('updatedAt');
            ->add('imageFile', VichImageType::class, [
                'required' => false,
                'allow_delete' => false,
                // 'delete_label' => 'Remove Image',
                'download_uri' => false,
                'image_uri' => true,
                // 'imagine_pattern' => 'product_photo_320x240',
                'asset_helper' => true,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ProductDTO::class,
        ]);
    }
}
