<?php

namespace App\Repository;

use App\Entity\SaisonDefini;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<SaisonDefini>
 *
 * @method SaisonDefini|null find($id, $lockMode = null, $lockVersion = null)
 * @method SaisonDefini|null findOneBy(array $criteria, array $orderBy = null)
 * @method SaisonDefini[]    findAll()
 * @method SaisonDefini[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SaisonDefiniRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SaisonDefini::class);
    }

//    /**
//     * @return SaisonDefini[] Returns an array of SaisonDefini objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?SaisonDefini
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
