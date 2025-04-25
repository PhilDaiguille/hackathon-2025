<?php

namespace App\Form;

use App\Entity\Booking;
use App\Entity\Negociation;
use App\Entity\Offer;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Enum\BookingStatus;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


class BookingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('finalPrice')
            ->add('createdAt', null, [
                'widget' => 'single_text',
            ])
            ->add('updatedAt', null, [
                'widget' => 'single_text',
            ])
            ->add('startDate', null, [
                'widget' => 'single_text',
            ])
            ->add('endDate', null, [
                'widget' => 'single_text',
            ])
            ->add('status', ChoiceType::class, [
                'choices' => BookingStatus::cases(),
                'choice_label' => fn(BookingStatus $status) => ucfirst($status->name),
                'choice_value' => fn(?BookingStatus $status) => $status?->value,
            ])
            ->add('idUser', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'id',
            ])
            ->add('idOffer', EntityType::class, [
                'class' => Offer::class,
                'choice_label' => 'id',
            ])
            ->add('negociation', EntityType::class, [
                'class' => Negociation::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Booking::class,
        ]);
    }
}
