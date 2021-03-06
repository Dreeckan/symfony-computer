<?php

namespace App\Form;

use App\Entity\Component;
use App\Entity\Computer;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ComponentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class)
            ->add('type', ChoiceType::class, [
                'choices'  => Component::AVAILABLE_TYPES,
                'multiple' => false,
                'expanded' => false,
            ])
            ->add('brand', TextType::class)
            ->add('price', MoneyType::class, [
                'currency' => 'EUR',
                'divisor'  => 100,
            ])
            ->add('computers', EntityType::class, [
                'class'    => Computer::class,
                'multiple' => true,
                'required' => false,
                'attr' => [
                    'data-choices' => true,
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Component::class,
        ]);
    }
}
