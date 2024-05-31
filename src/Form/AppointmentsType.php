<?php

namespace App\Form;

use App\Entity\Appointments;
use App\Entity\Status;
use App\Entity\User;
use App\Entity\Categories;
use App\Repository\UserRepository;
use App\Repository\AppointmentsRepository;
use App\Repository\StatusRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AppointmentsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Title',
                'attr' => [
                    'class' => 'form-control',
                    'style' => 'margin-bottom: 10px; background-color: rgba(100, 30, 50, 0.2); color: white;'
                ],
            ])
            ->add('category', EntityType::class, [
                'class' => Categories::class,
                'choice_label' => 'name',
                'label' => 'Category',
                'attr' => [
                    'class' => 'form-control',
                    'style' => 'margin-bottom: 10px; background-color: rgba(100, 30, 50, 0.2); color: white;'
                ],
            ])
            ->add('location', TextType::class, [
                'label' => 'Location / Address',
                'attr' => [
                    'class' => 'form-control',
                    'style' => 'margin-bottom: 10px; background-color: rgba(100, 30, 50, 0.2); color: white;'
                ],
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Infos and Details about the appointment',
                'attr' => [
                    'class' => 'form-control',
                    'style' => 'margin-bottom: 10px; background-color: rgba(100, 30, 50, 0.2); color: white;'
                ],
            ])
            ->add('date', DateType::class, [
                'label' => 'Date',
                'attr' => [
                    'class' => 'form-control',
                    'style' => 'margin-bottom: 10px; background-color: rgba(100, 30, 50, 0.2); input[type="date"]::-webkit-calendar-picker-indicator {display: none;}, color: white;'
                ],
            ])
            ->add('start_time', TimeType::class, [
                'label' => 'Start Time',
                'attr' => [
                    'class' => 'form-control',
                    'style' => 'margin-bottom: 10px; background-color: rgba(100, 30, 50, 0.2); color: white;'
                ],
            ])
            ->add('end_time', TimeType::class, [
                'label' => 'End Time',
                'attr' => [
                    'class' => 'form-control',
                    'style' => 'margin-bottom: 10px; background-color: rgba(100, 30, 50, 0.2); color: white;'
                ]
            ])
            
              
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Appointments::class,
        ]);
    }
}
