<?php
namespace App\Controller\Admin;

use App\Entity\User;
use App\Entity\Review;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField; 
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;

class ReviewCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Review::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle(Crud::PAGE_INDEX, 'Liste des avis');
    }
    
    public function configureFields(string $pageName): iterable
    {
        return [
            DateTimeField::new('startDate'),
            DateTimeField::new('endDate'),
            AssociationField::new('user')->autocomplete()
,            
            TextField::new('nom_agence'),
            TextField::new('comment'),
        ];
    }
}
