<?php

namespace App\Form;

use App\Entity\MyNotes;
use App\Entity\User;
use App\Entity\Categories;
use App\Service\FileUploader;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MyNotesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'attr' => [
                    'placeholder' => 'Title',
                    'class' => 'form-control mytitle',
                    'autocomplete' => 'off',
                    'required' => 'required',
                    'autofocus' => 'autofocus'
                ],
            ])
            ->add('category', EntityType::class, [
                'class' => Categories::class,
                'choice_label' => 'name',
                'label' => 'Category',
                'attr' => [
                    'class' => 'form-control mycategory',
                    'required' => 'required',
                ],
            ])
            ->add('subcategory', TextType::class, [
                'label' => 'Subcategory',
                'attr' => [
                    'placeholder' => 'Subcategory',
                    'class' => 'form-control mysubcategory',
                    'autocomplete' => 'off',
                    'required' => 'required',
                ],
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Note',
                'attr' => [
                    'placeholder' => 'Note',
                    'class' => 'form-control mynote',
                    'autocomplete' => 'off',
                    'required' => 'required',
                ],
            ])
            ->add('picture', FileType::class, [
                'label' => 'Image (JPG, PNG, GIF)',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/*',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid image file',
                    ])
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => MyNotes::class,
        ]);
    }
}
