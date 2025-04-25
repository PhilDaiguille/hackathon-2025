<?php

namespace App\Form;

use App\Entity\Preference;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PreferenceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('categories', ChoiceType::class, [
                'choices'  => [
                    'Campagne' => 'campagne',
                    'Mer' => 'mer',
                    'Montagne' => 'montagne',
                    'Spa' => 'spa',
                    'Petit déjeuner inclus' => 'petit_dejeuner',
                    'Piscine' => 'piscine',
                ],
                'expanded' => true,
                'multiple' => true,
                'label'    => 'Vos préférences',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Preference::class,
        ]);
    }
}
