<?php

namespace App\Controller\Admin;

use App\Entity\Politiquedeconfidentilaite;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class PolitiquedeconfidentilaiteCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Politiquedeconfidentilaite::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            
            yield TextEditorField::new('pol'),
            
        ];
    }
    
}
