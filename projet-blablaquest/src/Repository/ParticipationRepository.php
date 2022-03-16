<?php

namespace App\Repository;

use App\Entity\Participation;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Participation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Participation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Participation[]    findAll()
 * @method Participation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */

class ParticipationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Participation::class);
    }
    
    public function findByValidated($id)
    {
        return $this->createQueryBuilder('p')
        ->innerJoin('p.event', 'e')
        ->andWhere('e.id = :id')
        ->andWhere('p.isValidated = true')
        ->setParameter('id', $id)
        ->getQuery()
        ->getResult();
    }

    public function findAllParticipant($id)
    {
        return $this->createQueryBuilder('p')
        ->innerJoin('p.event', 'e')
        ->andWhere('e.id = :id')
        ->setParameter('id', $id)
        ->getQuery()
        ->getResult();
    }
    
    // public function findByExampleField($value)
    // {
    //     return $this->createQueryBuilder('p')
    //         ->andWhere('p.exampleField = :val')
    //         ->setParameter('val', $value)
    //         ->orderBy('p.id', 'ASC')
    //         ->setMaxResults(10)
    //         ->getQuery()
    //         ->getResult()
    //     ;
    // }
    /*
    public function findOneBySomeField($value): ?Participation
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
