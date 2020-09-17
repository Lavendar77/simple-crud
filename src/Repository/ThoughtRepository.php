<?php

namespace App\Repository;

use App\Entity\Thought;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Thought|null find($id, $lockMode = null, $lockVersion = null)
 * @method Thought|null findOneBy(array $criteria, array $orderBy = null)
 * @method Thought[]    findAll()
 * @method Thought[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ThoughtRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Thought::class);
    }

    // /**
    //  * @return Thought[] Returns an array of Thought objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Thought
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
