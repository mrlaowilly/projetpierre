<?php

namespace App\Form;

use App\Entity\BoardGame;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BoardGameType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, [
                'label' => 'nom',
            ])
            ->add('description', null, [
                'label' => 'Description',
            ])
            ->add('releasedAt', DateType::class, [
                'html5' => true,
                'widget' => 'single_text',
                'label' => 'Date de sortie',
                'attr' => [
                    'max' => date('Y-m-d'),
                ]
            ])
            ->add('ageGroup', IntegerType::class, [
                'label' => 'A partir de',
                'attr' => [
                    'min' => 0,
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => BoardGame::class,
        ]);
    }
}
