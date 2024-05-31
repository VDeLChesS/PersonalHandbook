<?php

namespace App\Controller\Admin;

use App\Entity\Tasks;
use App\Entity\User;
use App\Entity\Category;
use App\Entity\Status;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use App\Form\CategoriesAutocompleteField;
use App\Form\UserAutocompleteField;




class TasksCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Tasks::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id') -> onlyOnIndex(),
            AssociationField::new('user')->setFormTypeOption('choice_label',
            function ($choice) {
                return $choice->getFullName();
            }),
            TextField::new('title'),
            AssociationField::new('category')->setFormTypeOption('choice_label',
            function ($choice) {
                return $choice->getName();
            }),
            AssociationField::new('status')->setFormTypeOption('choice_label',
            function ($choice) {
                return $choice->getName();
            }),
            DateField::new('due_date'),
            TimeField::new('due_time'),
            IntegerField::new('duration'),
            ChoiceField::new('priority')->setChoices(['Low' => 'Low', 'Medium' => 'Medium', 'High' => 'High']),
            TextEditorField::new('description'),
            ImageField::new('picture')->setUploadDir('public/pictures')->setBasePath('pictures'),
            DateTimeField::new('created_at')->hideOnForm(),
            DateTimeField::new('updated_at')->hideOnForm(),
        ];
    }
    
}
