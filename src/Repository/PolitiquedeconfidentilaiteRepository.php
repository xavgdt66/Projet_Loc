<?php

namespace App\Repository;

use App\Entity\Politiquedeconfidentilaite;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Politiquedeconfidentilaite>
 *
 * @method Politiquedeconfidentilaite|null find($id, $lockMode = null, $lockVersion = null)
 * @method Politiquedeconfidentilaite|null findOneBy(array $criteria, array $orderBy = null)
 * @method Politiquedeconfidentilaite[]    findAll()
 * @method Politiquedeconfidentilaite[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PolitiquedeconfidentilaiteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Politiquedeconfidentilaite::class);
    }

//    /**
//     * @return Politiquedeconfidentilaite[] Returns an array of Politiquedeconfidentilaite objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Politiquedeconfidentilaite
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
