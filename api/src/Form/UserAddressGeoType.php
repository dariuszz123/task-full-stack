<?php


namespace App\Form;


use App\Entity\UserAddressGeo;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Range;

class UserAddressGeoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'lat',
            NumberType::class,
            [
                'scale' => 8,
                'constraints' => [
                    new Range(['min' => -90, 'max' => 90])
                ]
            ]
        );

        $builder->add(
            'lng',
            NumberType::class,
            [
                'scale' => 8,
                'constraints' => [
                    new Range(['min' => -180, 'max' => 180])
                ]
            ]
        );

        parent::buildForm($builder, $options);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => UserAddressGeo::class
            ]
        );

        parent::configureOptions($resolver);
    }
}
