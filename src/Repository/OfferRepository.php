<?php

namespace App\Repository;

use App\Entity\Offer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Offer>
 */
class OfferRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Offer::class);
    }

    public function findBySmartCriteria(array $criteria): array
    {
        $qb = $this->createQueryBuilder('o')
            ->leftJoin('o.idHotel', 'h')
            ->leftJoin('o.idRoom', 'r')
            ->addSelect('h', 'r');

        if (!empty($criteria['city'])) {
            $qb->andWhere('h.city LIKE :city')
                ->setParameter('city', '%' . $criteria['city'] . '%');
        }

        if (!empty($criteria['features'])) {
            foreach ($criteria['features'] as $index => $feature) {
                $param = "feature$index";
                $qb->andWhere("(h.description LIKE :$param OR r.description LIKE :$param)")
                    ->setParameter($param, '%' . $feature . '%');
            }
        }


        return $qb->getQuery()->getResult();
    }

}
