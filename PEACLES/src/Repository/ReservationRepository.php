<?php

namespace App\Repository;

use App\Entity\Reservation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Doctrine\Common\Collections\Criteria;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Validator\Constraints\Time;
use Doctrine\ORM\Query\Expr;

/**
 * @method Reservation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Reservation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Reservation[]    findAll()
 * @method Reservation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReservationRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Reservation::class);
    }

     /**
      * @return Reservation[] Returns an array of Reservation objects
     */
    
    /*public function findPastReservations($value)
    {
        $entityManager=$this->getEntityManager();
        $query=$entityManager->createQuery(
            'SELECT r
            FROM App\Entity\Reservation r
            WHERE r.date
            '
        );
    }*/

    static public function createPastReservationCriteria()
    {

        return Criteria::create()
            ->where(
                Criteria::expr()->orX(
                    Criteria::expr()->lt('date',new \DateTime('today')),
                    Criteria::expr()->andX(
                        Criteria::expr()->eq('date',new \DateTime('today')),
                        Criteria::expr()->lt('end',new \DateTime('now'))
                    )
                ))
            ->andwhere(Criteria::expr()->neq('id_client',null))
            ->orderBy(["date" =>'DESC','end' => 'DESC']);
    }

    static public function createUpcomingReservationCriteria()
    {
        return Criteria::create()
            ->where(
                Criteria::expr()->orX(
                    Criteria::expr()->gt('date',new \DateTime('today')),
                    Criteria::expr()->andX(
                        Criteria::expr()->eq('date',new \DateTime('today')),
                        Criteria::expr()->gte('start',new \DateTime('now'))
                    )
                ))
            ->andwhere(Criteria::expr()->neq('id_client',null))
            ->orderBy(["date" =>'ASC','start' => 'ASC']);
    }

    static public function createAvailabilityCriteria()
    {
        return Criteria::create()
            ->where(Criteria::expr()->gte('date',new \DateTime('today')))
            ->andWhere(Criteria::expr()->gte('start',new \DateTime('now')))
            ->andwhere(Criteria::expr()->eq('id_client',null))
            ->orderBy(["date" =>'ASC','start' => 'ASC']);
    }

    public function getAvailableOnDate($date,$id){
        return $this->createQueryBuilder('res')
            ->andWhere('res.id_resto = :id')
            ->andWhere('res.id_client is NULL')
            ->andWhere(
                new Expr\Orx(['res.date = :date',new Expr\Andx(['res.date = :today','res.start >= :now'])])
            )
            ->setParameters(['id'=>$id,'date'=>$date,'today'=>new \DateTime('today'),'now'=>new \DateTime('now')])
            ->getQuery()
            ->getResult();
    }

    static public function createAvailOnDateCriteria($date)
    {
        return Criteria::create()
        ->where(Criteria::expr()->eq('date',new \DateTime($date)))
            ->andWhere(Criteria::expr()->gte('date',new \DateTime('today')))
            ->andwhere(Criteria::expr()->eq('id_client',null))
            ->orderBy(["date" =>'ASC','start' => 'ASC']);
    }

    /*public function findPastReservationsByUser($user){
        $entityManager=$this->getEntityManager();
        $query=$entityManager->createQuery(
            'SELECT r,u.username
            FROM  App\Entity\Reservation r JOIN App\Entity\User u
            ON u.id=:id
            WHERE r.date <= :date AND r.end < :time
            ORDER BY 
            '
        );
    }*/
    
    

    /*
    public function findOneBySomeField($value): ?Reservation
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
