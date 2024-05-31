<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Entity\Category;
use App\Entity\Status;
use App\Entity\Addresses;
use App\Entity\DailySchedules;
use App\Entity\Tasks;
use App\Entity\MyNotes;
use App\Entity\Appointments;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use Doctrine\ORM\Mapping as ORM;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureFields(string $pageName): iterable
    {
        
        yield FormField::addTab('User Information');
        yield IdField::new('id') -> hideOnForm();
        yield FormField::addFieldset('User Personal Information');
        yield TextField::new('fname', 'First Name')->setColumns('col-sm-6 col-lg-5 col-xxl-3');
        yield TextField::new('lname', 'Last Name')->setColumns('col-sm-6 col-lg-5 col-xxl-3');
        yield FormField::addRow();
        yield ChoiceField::new('gender')->setChoices([' ' => ' ', 'Male' => 'Male', 'Female' => 'Female', 'Other' => 'Other']) -> setColumns('col-sm-6 col-lg-5 col-xxl-3');
        yield DateField::new('dob', 'Date Of Birth') -> setColumns('col-sm-6 col-lg-5 col-xxl-3');
        yield FormField::addRow();
        yield TextField::new('phone', 'Phone Number')->setColumns('col-sm-6 col-lg-5 col-xxl-3');
        yield EmailField::new('email', 'Email Address')->setColumns('col-sm-6 col-lg-5 col-xxl-3');
        yield FormField::addRow();
        yield ChoiceField::new('roles')->setChoices(['ROLE_USER' => 'ROLE_USER', 'ROLE_ADMIN' => 'ROLE_ADMIN'])->allowMultipleChoices()->setColumns('col-sm-6 col-lg-5 col-xxl-3');
        yield TextField::new('password')->setFormType(PasswordType::class)->setColumns('col-sm-6 col-lg-5 col-xxl-3');
        yield FormField::addRow();    
        yield ImageField::new('picture')->setUploadDir('public/pictures')->setBasePath('pictures')->setColumns('col-sm-6 col-lg-5 col-xxl-3');
        yield FormField::addTab('User Address');
        /* yield CollectionField::Addresses->useEntryCrudForm(AddressesCrudController::class)->setHelp('Enter an address for the user');*/

        yield FormField::addTab('User Tasks');

        yield FormField::addTab('User Appointments');

        yield FormField::addTab('User Daily Schedules');

        yield FormField::addTab('User Notes');

        yield FormField::addTab('User Projects');
        /*yield FormField::addFieldset('Task Information');
        yield FormField::addColumn(8);
        yield AssociationField::new('tasks')->setHelp('Enter a task for the user')->autocomplete();
        yield AssociationField::new('appointments')->setHelp('Enter an appointment for the user')->autocomplete();
        yield AssociationField::new('daily_schedules')->setHelp('Enter a daily schedule for the user')->autocomplete();
        yield AssociationField::new('My_notes')->setHelp('Enter a note for the user')->autocomplete(); */
    }
}