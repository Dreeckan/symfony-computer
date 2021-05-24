<?php

namespace App\Form;

use App\Entity\Component;
use App\Entity\Computer;
use App\Entity\Device;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
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
            ->add('name', TextType::class)
            ->add('description')
            ->add('type', ChoiceType::class, [
                'choices'  => array_flip(Computer::AVAILABLE_TYPES),
                'multiple' => false,
                'expanded' => true,
            ])
            ->add('devices', EntityType::class, [
                'class'         => Device::class,
                'multiple'      => true,
                'expanded'      => false,
                'query_builder' => function (EntityRepository $repository) {
                    return $repository
                        ->createQueryBuilder('d')
                        ->orderBy('d.name', 'ASC')
                    ;
                },
//                'choice_label' => 'name', // Pour afficher un élément Device, on va chercher son nom et on l'affiche
            ])
            ->add('components', EntityType::class, [
                'class'         => Component::class,
                'multiple'      => true,
                'expanded'      => false,
                'query_builder' => function (EntityRepository $repository) {
                    return $repository
                        ->createQueryBuilder('c')
                        ->orderBy('c.name', 'ASC')
                    ;
                },
//                'choice_label' => 'name', // Pour afficher un élément Device, on va chercher son nom et on l'affiche
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Computer::class,
        ]);
    }
}
