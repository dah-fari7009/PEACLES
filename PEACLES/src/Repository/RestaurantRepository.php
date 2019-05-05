<?php

namespace App\Repository;

use App\Entity\Restaurant;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Doctrine\ORM\Query\Expr;

/**
 * @method Restaurant|null find($id, $lockMode = null, $lockVersion = null)
 * @method Restaurant|null findOneBy(array $criteria, array $orderBy = null)
 * @method Restaurant[]    findAll()
 * @method Restaurant[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RestaurantRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Restaurant::class);
    }

    public function searchAll($key)
    {
        return $this->createQueryBuilder('r')
            ->leftjoin('r.specialties','s')
            ->addSelect('s')
            ->andWhere('s.cuisine LIKE :key')
            ->orWhere('r.username LIKE :key')
            ->orWhere('r.address LIKE :key')
            ->setParameter('key','%'.$key.'%')
            ->getQuery()
            ->getResult();
            
    }


    //put all in lowercase first
    public function searchByName($key)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.username LIKE :key')
            ->setParameter('key','%'.$key.'%')
            ->getQuery()
            ->getResult();
    }

    //A revoir
    public function searchBySpecialty($key)
    {
        return $this->createQueryBuilder('r')
            ->leftjoin('r.specialties','s')
            ->addSelect('s')
            ->andWhere('s.cuisine LIKE :key')
            ->setParameter('key','%'.$key.'%')
            ->getQuery()
            ->getResult();
    }

    public function searchByAddress($key)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.address LIKE :key')
            ->setParameter('key','%'.$key.'%')
            ->getQuery()
            ->getResult();
    }

    public function searchMultiple($keys)
    {
        $query=$this->createQueryBuilder('r')
            ->leftjoin('r.specialties','s')
            ->addSelect('s');
        $length=count($keys);
        for($i=0;$i<$length;$i++)
        {
            $key=$keys[$i];
            $query
            ->andWhere(
                new Expr\Orx(['s.cuisine LIKE :key'.$i,'r.username LIKE :key'.$i, 'r.address LIKE :key'.$i])
            )
            ->setParameter('key'.$i, '%'.$key.'%');
                //'s.cuisine LIKE ? OR r.username LIKE ? OR r.address LIKE ?','%'.$key.'%','%'.$key.'%','%'.$key.'%');
        }
        return $query->getQuery()
            ->getResult();
            

    }

    // /**
    //  * @return Restaurant[] Returns an array of Restaurant objects
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
    public function findOneBySomeField($value): ?Restaurant
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
