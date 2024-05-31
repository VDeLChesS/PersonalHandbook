<?php

namespace App\Controller\Admin;

use App\Entity\Addresses;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;


class AddressesCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Addresses::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            AssociationField::new('user')->setFormTypeOption('choice_label',
            function ($choice) {
                return $choice->getFullName();
            }),
            TextField::new('street'),
            TextField::new('street_secondary'),
            TextField::new('city'),
            TextField::new('zip'),
            TextField::new('country'),
        ];
    }
    
}
