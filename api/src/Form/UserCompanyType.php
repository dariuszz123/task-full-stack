<?php

namespace App\Form;

use App\Entity\UserCompany;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class UserCompanyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'name',
            TextType::class,
            [
                'constraints' => [
                    new NotBlank(),
                    new Length(['min' => 1, 'max' => 255])
                ]
            ]
        );

        $builder->add(
            'catchPhrase',
            TextType::class,
            [
                'constraints' => [
                    new Length(['min' => 1, 'max' => 255])
                ]
            ]
        );

        $builder->add(
            'bs',
            TextType::class,
            [
                'constraints' => [
                    new Length(['min' => 1, 'max' => 255])
                ]
            ]
        );

        parent::buildForm($builder, $options);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => UserCompany::class,
            ]
        );

        parent::configureOptions($resolver);
    }
}
