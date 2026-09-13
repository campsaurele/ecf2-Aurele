<?php

namespace App\Form;

use App\Entity\Trainee;
use App\Entity\Training;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class TraineeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        // Form builder based on Trainee table
        $builder
            ->add('lastname')
            ->add('name')
            ->add('phone')
            ->add('email')
            ->add('training', EntityType::class, [
                'class' => Training::class,
                'choice_label' => 'name',
            ])
            // Secure webp Format thank's to attr and constraints "parameters"
            ->add('photo', FileType::class, [
                'label' => 'Photo (WebP)',
                'mapped' => false,
                'required' => false,
                'attr' => [
                    'accept' => '.webp',
                ],
                'constraints' => [
                    new Assert\File(
                        maxSize: '5M',
                        mimeTypes: ['image/webp'],
                        mimeTypesMessage: 'Veuillez sélectionner une image au format webp.',
                    ),
                ],
            ])
            ->add('save', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Trainee::class,
        ]);
    }
}
