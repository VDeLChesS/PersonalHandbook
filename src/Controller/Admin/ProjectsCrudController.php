<?php

namespace App\Controller\Admin;

use App\Entity\Projects;
use App\Entity\User;
use App\Entity\Status;
use App\Entity\CodingLanguages;
use App\Repository\StatusRepository;
use App\Repository\CodingLanguagesRepository;
use App\Repository\UserRepository;
use App\Repository\ProjectsRepository;
use App\Repository\TasksRepository;
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
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\UrlField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Option\SearchMode;
use EasyCorp\Bundle\EasyAdminBundle\Config\Option\EA;
use EasyCorp\Bundle\EasyAdminBundle\Config\Option\TextAlign;
use EasyCorp\Bundle\EasyAdminBundle\Config\Option\EA\TextEditor;
use EasyCorp\Bundle\EasyAdminBundle\Config\Option\EA\TextEditorConfig;
use EasyCorp\Bundle\EasyAdminBundle\Config\Option\TextEditorConfig as TextEditorConfigTextEditorConfig;




class ProjectsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Projects::class;
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add('project_name', null, TextField::class, function (TextField $field) {
                return $field->setLabel('Project Name');
            })
            ->add('priority', null, ChoiceField::new('priority')->setChoices(['Low' => 'Low', 'Medium' => 'Medium', 'High' => 'High']), function (ChoiceField $field) {
                return $field->setLabel('Priority');
            })
            ->add('start_date', null, DateField::new('start_date'), function (DateField $field) {
                return $field->setLabel('Start Date');
            })
            ->add('end_date')
            ->add('user')
            ->add('status')
            ->add('coding_language')
            ->add('tasks');
    }
    public function configureFields(string $pageName): iterable
    {
        return [
            FormField::addFieldset('Project Details'),
            IdField::new('id') -> hideOnForm(),
            TextField::new('project_name'),
            TextEditorField::new('description'),
            DateField::new('start_date'),
            DateField::new('end_date')->hideOnForm(),
            ChoiceField::new('priority')->setChoices(['Low' => 'Low', 'Medium' => 'Medium', 'High' => 'High']),
            ImageField::new('picture')->setUploadDir('public/pictures')->setBasePath('pictures'),

            FormField::addFieldset('Project Associations'),
            AssociationField::new('user')->setFormTypeOption('choice_label',
            function ($choice) {
                return $choice->getFullName();
            }),
            AssociationField::new('status')->setFormTypeOption('choice_label',
            function ($choice) {
                return $choice->getName();
            }),
            AssociationField::new('coding_language')->setFormTypeOption('choice_label',
            function ($choice) {
                return $choice->getName();
            }),

            FormField::addFieldset('Project Accessories'),
            UrlField::new('documentation', 'Documentation')->setFormTypeOption('attr', ['placeholder' => 'Enter the URL of the project documentation']),
            UrlField::new('resources', 'Ressources')->setFormTypeOption('attr', ['placeholder' => 'Enter the URL of the project Ressources']),
            ];
    }
}
