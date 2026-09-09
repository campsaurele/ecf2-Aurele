<?php

namespace App\Form;

use App\Entity\Absences;
use App\Entity\Reasons;
use App\Entity\Trainee;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AbsenceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dateTime')
            ->add('reason', EntityType::class, [
                'class' => Reasons::class,
                'choice_label' => 'name',
            ])
            ->add('trainee', EntityType::class, [
                'class' => Trainee::class,
                'choice_label' => 'name',
            ])
            ->add('save', SubmitType::class)

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Absences::class,
        ]);
    }
}
