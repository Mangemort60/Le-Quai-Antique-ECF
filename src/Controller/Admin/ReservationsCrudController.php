<?php

namespace App\Controller\Admin;

use App\Entity\Reservations;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TimeField;

class ReservationsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Reservations::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [

            IntegerField::new('nbr_couvert')->setLabel('Nombre de couvert'),
            DateTimeField::new('Date')->setFormat('dd.MM.yyyy')->setTimezone('Europe/Paris'),
            TimeField::new('heure')->setFormat('HH:mm')->setTimezone('Europe/Paris'),
            TextField::new('allergie'),
            TextField::new('clientEmail')
        ];
    }

}
