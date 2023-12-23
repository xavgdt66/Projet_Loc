<?php

namespace App\Repository;
 
use App\Entity\Commentsamarche;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Commentsamarche>
 *
 * @method Commentsamarche|null find($id, $lockMode = null, $lockVersion = null)
 * @method Commentsamarche|null findOneBy(array $criteria, array $orderBy = null)
 * @method Commentsamarche[]    findAll()
 * @method Commentsamarche[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommentsamarcheRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Commentsamarche::class);
    }

//    /**
//     * @return Commentsamarche[] Returns an array of Commentsamarche objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Commentsamarche
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
