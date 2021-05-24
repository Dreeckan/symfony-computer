<?php

namespace App\Form;

use App\Entity\Computer;
use App\Entity\Device;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DeviceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class)
            ->add('brand', TextType::class)
            ->add('description', TextareaType::class)
            ->add('price', MoneyType::class, [
                'currency' => 'EUR', // Défini la monnaie utilisée
                'divisor'  => 100,   // On stocke les prix en centimes, il faut donc diviser les prix affichés par 100, par rapport à la base
            ])
            ->add('type', ChoiceType::class, [
                'choices'  => array_flip(Device::AVAILABLE_TYPES),
                'multiple' => false,
                'expanded' => false,
            ])
            ->add('computers', EntityType::class, [
                'class'    => Computer::class,
                'multiple' => true,
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Device::class,
        ]);
    }
}
