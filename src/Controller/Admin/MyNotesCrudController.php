<?php

namespace App\Controller\Admin;

use App\Entity\MyNotes;
use App\Entity\User;
use App\Entity\Categories;
use App\Entity\Status;
use App\Repository\StatusRepository;
use App\Repository\CategoriesRepository;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;   
use EasyCorp\Bundle\EasyAdminBundle\Field\CodeEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Option\SearchMode;
use EasyCorp\Bundle\EasyAdminBundle\Config\Option\EA;
use EasyCorp\Bundle\EasyAdminBundle\Config\Option\TextAlign;
use EasyCorp\Bundle\EasyAdminBundle\Config\Option\EA\TextEditor;
use EasyCorp\Bundle\EasyAdminBundle\Config\Option\EA\TextEditorConfig;
use EasyCorp\Bundle\EasyAdminBundle\Config\Option\TextEditorConfig as TextEditorConfigTextEditorConfig;



class MyNotesCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return MyNotes::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Note')
            ->setEntityLabelInPlural('Notes')
            ->setSearchFields(['title', 'description', 'category' ,'sub_category'])
            ->setDefaultSort(['created_at' => 'DESC'])
            ->setAutofocusSearch()
            ->setSearchMode(SearchMode::ANY_TERMS)
            ->setPaginatorPageSize(10)
            ->setPaginatorRangeSize(5)
            

            ->setEntityLabelInSingular(function (?MyNotes $note, ?string $entityLabelInSingular) {
                return $note ? $note->getTitle() : 'Note'; 
            })
            ->setEntityLabelInPlural(function(?MyNotes $note, ?string $entityLabelInPlural) {
                return $note ? $note->getTitle() : 'Notes'; 
            })
            ->setPaginatorUseOutputWalkers(true)
            ->setPaginatorFetchJoinCollection(true)
             
            ;
    }
    
    public function configureFields(string $pageName): iterable
    {
        yield FormField::addColumn('col-xxl-8');
        yield FormField::addFieldset();
        yield TextField::new('title');
        yield AssociationField::new('user')->setFormTypeOption('choice_label',
            function ($choice) {
                return $choice->getFullName();
            });
        yield AssociationField::new('category')->setFormTypeOption('choice_label',
            function ($choice) {
                return $choice->getName();
            })
            ->setHelp('Enter a category for the note');
        yield TextField::new('sub_category') -> setHelp('Enter a sub-category for the note');

        yield FormField::addColumn('col-xxl-10');
        yield FormField::addFieldset();
        yield CodeEditorField::new('description')->hideOnIndex()
            ->setNumOfRows(35)->setLanguage('markdown')
            ->setHelp('Use Markdown to format the blog post contents. HTML is allowed too.');
        yield ImageField::new('picture')->setUploadDir('public/pictures')->setBasePath('pictures');
        yield DateTimeField::new('created_at')->hideOnForm();

    }
    
}
