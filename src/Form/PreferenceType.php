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
        $builder->add('categories', ChoiceType::class, [
            'label' => 'Vos préférences',
            'choices' => [
                'Campagne' => 'campagne',
                'Mer' => 'mer',
                'Montagnes' => 'montagnes',
                'Spa' => 'spa',
                'Petit-déjeuner inclus' => 'petit_dejeuner',
                'Piscine' => 'piscine',
            ],
            'expanded' => true,
            'multiple' => true,
            'attr' => ['class' => 'space-y-2'],
            'label_attr' => ['class' => 'block text-sm font-medium text-gray-700 mb-2'],
            'choice_attr' => function ($choice, $key, $value) {
                return ['class' => 'mr-2 text-black'];
            },
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Preference::class,
        ]);
    }
}
