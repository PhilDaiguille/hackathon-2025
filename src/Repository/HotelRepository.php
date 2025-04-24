<?php

namespace App\Repository;

use App\Entity\Hotel;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Hotel>
 */
class HotelRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Hotel::class);
    }

    public function findBySmartCriteria(?string $city, array $keywords): array
    {
        $qb = $this->createQueryBuilder('h');

        if ($city) {
            $qb->andWhere('h.city LIKE :city')
                ->setParameter('city', '%' . $city . '%');
        }

        foreach ($keywords as $i => $keyword) {
            $qb->andWhere("h.description LIKE :kw{$i}")
                ->setParameter("kw{$i}", '%' . $keyword . '%');
        }

        return $qb->getQuery()->getResult();
    }


//    /**
//     * @return Hotel[] Returns an array of Hotel objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('h')
//            ->andWhere('h.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('h.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Hotel
//    {
//        return $this->createQueryBuilder('h')
//            ->andWhere('h.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
