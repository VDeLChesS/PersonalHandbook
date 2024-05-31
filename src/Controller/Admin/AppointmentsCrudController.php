<?php

namespace App\Controller\Admin;

use App\Entity\Appointments;
use App\Entity\User;
use App\Entity\Status;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;



class AppointmentsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Appointments::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id') -> hideOnForm(),
            TextField::new('title'),
            TextEditorField::new('description'),
            TimeField::new('start_time'),
            TimeField::new('end_time'),
            DateField::new('date'),
            AssociationField::new('user')->autocomplete(),
            AssociationField::new('status')->setFormTypeOption('choice_label', 
            function ($choice) {
                return $choice->getName();
            }),
            DateTimeField::new('created_at')->hideOnForm(),
            DateTimeField::new('updated_at')->hideOnForm(),
        ];
    }
}
