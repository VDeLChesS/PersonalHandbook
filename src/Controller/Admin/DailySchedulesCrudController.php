<?php

namespace App\Controller\Admin;

use App\Entity\DailySchedules;
use App\Entity\User;
use App\Entity\Tasks;
use App\Entity\Appointments;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;


class DailySchedulesCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return DailySchedules::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id') -> hideOnForm(),
            AssociationField::new('user')->autocomplete(),
            AssociationField::new('tasks')->autocomplete(),
            AssociationField::new('appointments')->autocomplete(),
            DateField::new('schedule_date'),
            DateTimeField::new('created_at')->hideOnForm(),
            DateTimeField::new('updated_at')->hideOnForm(),

        ];
    }
  
}
