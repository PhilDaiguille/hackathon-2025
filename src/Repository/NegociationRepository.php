<?php

namespace App\Repository;

use App\Entity\Negociation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Negociation>
 */
class NegociationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Negociation::class);
    }

    // Ici tu pourras ajouter des méthodes personnalisées si besoin
}
