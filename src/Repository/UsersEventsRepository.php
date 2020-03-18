<?php

namespace App\Repository;

use App\Entity\UsersEvents;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method UsersEvents|null find($id, $lockMode = null, $lockVersion = null)
 * @method UsersEvents|null findOneBy(array $criteria, array $orderBy = null)
 * @method UsersEvents[]    findAll()
 * @method UsersEvents[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UsersEventsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UsersEvents::class);
    }

    // /**
    //  * @return UsersEvents[] Returns an array of UsersEvents objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?UsersEvents
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
