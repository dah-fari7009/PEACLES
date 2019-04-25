<?php

namespace App\Repository;

use App\Entity\ReservationInfos;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ReservationInfos|null find($id, $lockMode = null, $lockVersion = null)
 * @method ReservationInfos|null findOneBy(array $criteria, array $orderBy = null)
 * @method ReservationInfos[]    findAll()
 * @method ReservationInfos[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReservationInfosRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ReservationInfos::class);
    }

    // /**
    //  * @return ReservationInfos[] Returns an array of ReservationInfos objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ReservationInfos
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
