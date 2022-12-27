<?php

namespace App\Controller\Admin;

use App\Entity\PlacesMax;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;

class PlacesMaxCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return PlacesMax::class;
    }
    
    public function configureFields(string $pageName): iterable
    {
        return [
                IntegerField::new('nbrPlacesMax')
        ];
    }

}
