<?php

namespace App\Controller\Admin;

use App\Entity\SuggestedTasks;
use App\Entity\Category;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;


class SuggestedTasksCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return SuggestedTasks::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id') -> hideOnForm(),
            TextField::new('title'),
            AssociationField::new('category')->setFormTypeOption('choice_label',
            function ($choice) {
                return $choice->getName();
            }),
            TextEditorField::new('description'),
            ImageField::new('picture')->setUploadDir('/public/pictures')
                ->setBasePath('pictures')
                ->setUploadedFileNamePattern('[randomhash].[extension]')
                ->setRequired(false),
        ];
    }
    
}
