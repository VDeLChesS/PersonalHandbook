<?php

namespace App\Form;

use App\Entity\Addresses;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddressesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('street', TextType::class, [
                'label' => 'Address',
                'attr' => [ 
                    'placeholder' => '123 Main St.',
                    'class' => 'form-control'
                ],
            ])
            ->add('street_secondary', TextType::class, [
                'label' => 'Address 2',
                'attr' => [
                    'placeholder' => 'Aptartment, studio, or floor',
                    'class' => 'form-control'
                ],
            ])
            ->add('city', TextType::class, [
                'label' => 'City',
                'attr' => [
                    'placeholder' => 'Enter city',
                    'class' => 'form-control'
                ],
            ])
            ->add('zip', TextType::class, [
                'label' => 'ZIP',
                'attr' => [
                    'placeholder' => 'Enter ZIP code',
                    'class' => 'form-control'
                ],
            ])
            ->add('country', TextType::class, [
                'label' => 'Country',
                'attr' => [
                    'placeholder' => 'Enter country',
                    'class' => 'form-control'
                ],
            ])
            ->add('is_current', CheckboxType::class, [
                'label' => 'Is this your current address?',
                'required' => false,
                'attr' => [
                    'class' => 'form-check-input'
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Addresses::class,
        ]);
    }
}
