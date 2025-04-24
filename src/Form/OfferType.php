<?php

namespace App\Form;

use App\Entity\Booking;
use App\Entity\Hotel;
use App\Entity\Offer;
use App\Entity\Room;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OfferType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('acceptanceThreshold')
            ->add('refusalThreshold')
            ->add('availableFrom', null, [
                'widget' => 'single_text',
            ])
            ->add('availableUntil', null, [
                'widget' => 'single_text',
            ])
            ->add('createdAt', null, [
                'widget' => 'single_text',
            ])
            ->add('updatedAt', null, [
                'widget' => 'single_text',
            ])
            ->add('idHotel', EntityType::class, [
                'class' => Hotel::class,
                'choice_label' => 'id',
            ])
            ->add('idRoom', EntityType::class, [
                'class' => Room::class,
                'choice_label' => 'id',
            ])
            ->add('booking', EntityType::class, [
                'class' => Booking::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Offer::class,
        ]);
    }
}
