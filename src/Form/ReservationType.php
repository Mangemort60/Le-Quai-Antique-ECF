<?php

namespace App\Form;

use App\Entity\Reservations;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class ReservationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $builder
            ->add('nbrCouvert', IntegerType::class, [
                'label' => 'Nombre de couvert',
                'attr' => ['min' => 1, 'max' => 10],

            ])
            ->add('date', DateType::class, [
                'placeholder' => [
                    'year' => 'Year',
                    'month' => 'Month',
                    'day' => 'Day',
                ],
                'model_timezone' => 'Europe/Paris',
                'data' => new \DateTime(),
            ])
            ->add('heure', TimeType::class,
                [
                    'input_format' => 'H:m:ss',
                    'input'  => 'datetime',
                    'widget' => 'choice',
                    'hours' => ['12', '13', '14', '19', '20', '21'],
                    'minutes' => ['00', '15','30','45']
                ]

            )
            ->add('allergie', TextType::class,[
                'required' => false,
                'label' => 'Eventuelles allergies',


            ])
            ->add('soumettre', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reservations::class,
        ]);
    }
}
