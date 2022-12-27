<?php

namespace App\Controller\Admin;

use App\Entity\Horaires;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TimeField;

class HorairesCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Horaires::class;
    }


     public function configureFields(string $pageName): iterable
     {
         return [
             TextField::new('jour'),
             TimeField::new('ouvertureMidi')->renderAsChoice()->setTimezone('Europe/Paris')->setFormat('HH:mm '),
             TimeField::new('fermetureMidi')->renderAsChoice()->setTimezone('Europe/Paris')->setFormat('HH:mm '),
             TimeField::new('ouvertureSoir')->renderAsChoice()->setTimezone('Europe/Paris')->setFormat('HH:mm '),
             TimeField::new('fermetureSoir')->renderAsChoice()->setTimezone('Europe/Paris')->setFormat('HH:mm'),
             BooleanField::new('ouvert'),
         ];
     }

}
