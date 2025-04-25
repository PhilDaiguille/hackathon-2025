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
        $isAdmin = $options['is_admin'];
        $userHotel = $options['user_hotel'];

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
            ]);

        if ($isAdmin) {
            $builder->add('idHotel', EntityType::class, [
                'class' => Hotel::class,
                'choice_label' => 'name',
            ]);
        }

        $builder->add('idRoom', EntityType::class, [
            'class' => Room::class,
            'choice_label' => fn(Room $room) => $room->getType() . ' (#' . $room->getId() . ')',
            'query_builder' => function (\App\Repository\RoomRepository $repo) use ($isAdmin, $userHotel) {
                $qb = $repo->createQueryBuilder('r');
                if (!$isAdmin && $userHotel) {
                    $qb->andWhere('r.idHotel = :hotel')->setParameter('hotel', $userHotel);
                }
                return $qb;
            },
        ]);

        $builder->add('booking', EntityType::class, [
            'class' => Booking::class,
            'choice_label' => 'id',
            'required' => false,
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Offer::class,
            'is_admin' => false,
            'user_hotel' => null,
        ]);
    }

}
