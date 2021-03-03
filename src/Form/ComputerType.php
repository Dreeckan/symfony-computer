<?php

namespace App\Form;

use App\Entity\Computer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ComputerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'attr'     => [
                    'maxlength' => 128,
                ],
                'required' => true,
            ])
            ->add('description')
            ->add('type', ChoiceType::class, [
                'choices'  => array_flip(Computer::AVAILABLE_TYPES),
                'multiple' => false,
                'expanded' => false,
            ])
            ->add('devices')
            ->add('components')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Computer::class,
        ]);
    }
}
