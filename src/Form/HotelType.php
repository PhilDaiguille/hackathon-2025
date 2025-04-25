<?php

namespace App\Form;

use App\Entity\Hotel;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HotelType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('description')
            ->add('streetName')
            ->add('streetNumber')
            ->add('postalCode')
            ->add('city')
            ->add('country')
            ->add('rating')
            ->add('adminEmail')
            ->add('stars', null, [
                'label' => 'Nombre d’étoiles'
            ]);

        if ($options['is_admin']) {
            $builder
                ->add('createdAt', null, [
                    'widget' => 'single_text',
                ])
                ->add('updatedAt', null, [
                    'widget' => 'single_text',
                ]);
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Hotel::class,
            'is_admin' => false // valeur par défaut
        ]);
    }
}
