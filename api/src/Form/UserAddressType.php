<?php

namespace App\Form;

use App\Entity\UserAddress;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class UserAddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'street',
            TextType::class,
            [
                'constraints' => [
                    new NotBlank(),
                    new Length(['min' => 1, 'max' => 255]),
                ]
            ]
        );

        $builder->add(
            'suite',
            TextType::class,
            [
                'constraints' => [
                    new Length(['min' => 1, 'max' => 255]),
                ]
            ]
        );

        $builder->add(
            'city',
            TextType::class,
            [
                'constraints' => [
                    new NotBlank(),
                    new Length(['min' => 1, 'max' => 255]),
                ]
            ]
        );

        $builder->add(
            'zipcode',
            TextType::class,
            [
                'property_path' => 'zipCode',
                'constraints' => [
                    new NotBlank(),
                    new Length(['min' => 1, 'max' => 255]),
                ]
            ]
        );

        $builder->add('geo', UserAddressGeoType::class);

        parent::buildForm($builder, $options);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => UserAddress::class
            ]
        );

        parent::configureOptions($resolver);
    }
}
