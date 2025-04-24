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

        // Recherche par ville si précisée
        if (!empty($criteria['city'])) {
            $qb->andWhere('h.city LIKE :city')
                ->setParameter('city', '%' . $criteria['city'] . '%');
        }

        // Recherche par mots-clés dans description de l’hôtel ou de la chambre
        if (!empty($criteria['keywords'])) {
            $i = 0;
            foreach ($criteria['keywords'] as $keyword) {
                $param = "kw$i";
                $qb->andWhere("(h.description LIKE :$param OR r.description LIKE :$param)")
                    ->setParameter($param, '%' . $keyword . '%');
                $i++;
            }
        }

        return $qb->getQuery()->getResult();
    }

    //    /**
    //     * @return Offer[] Returns an array of Offer objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('o')
    //            ->andWhere('o.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('o.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Offer
    //    {
    //        return $this->createQueryBuilder('o')
    //            ->andWhere('o.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
