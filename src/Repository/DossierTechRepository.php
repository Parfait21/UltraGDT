<?php

namespace App\Repository;

use App\Entity\DossierTech;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<DossierTech>
 *
 * @method DossierTech|null find($id, $lockMode = null, $lockVersion = null)
 * @method DossierTech|null findOneBy(array $criteria, array $orderBy = null)
 * @method DossierTech[]    findAll()
 * @method DossierTech[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DossierTechRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DossierTech::class);
    }

//    /**
//     * @return DossierTech[] Returns an array of DossierTech objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('d.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?DossierTech
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
