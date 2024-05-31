<?php

namespace App\Controller\Admin;

use App\Entity\Events;
use App\Entity\User;
use App\Entity\Category;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;


class EventsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Events::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnIndex(),
            AssociationField::new('user')->setFormTypeOption('choice_label',
            function ($choice) {
                return $choice->getFullName();
            }),
            TextField::new('title'),
            AssociationField::new('category')->setFormTypeOption('choice_label',
            function ($choice) {
                return $choice->getName();
            })
            ->setHelp('Enter a category for the event'),
            DateTimeField::new('start_datetime'),
            IntegerField::new('duration'),
            TextEditorField::new('description'),
            ImageField::new('picture')->setUploadDir('public/pictures')->setBasePath('pictures'),
        ];
    }

}
