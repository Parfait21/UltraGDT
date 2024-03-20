<?php

namespace App\Repository;

use App\Entity\Saisons;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\Tools\Pagination\Paginator;

class SaisonsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Saisons::class);
    }

    /**
     * Récupère les saisons paginées pour un client spécifique.
     *
     * @param int $clientId L'ID du client
     * @param int $page     Le numéro de la page
     * @param int $nbre     Le nombre d'éléments par page
     *
     * @return Paginator
     */
    public function findPaginatedByClientId(int $clientId, int $page, int $nbre): Paginator
    {
        $queryBuilder = $this->createQueryBuilder('s')
            ->join('s.clientId', 'c')
            ->where('c.id = :clientId')
            ->setParameter('clientId', $clientId)
            ->orderBy('s.id', 'ASC');

        $query = $queryBuilder->getQuery();

        // Créez un objet Paginator pour paginer les résultats
        $paginator = new Paginator($query);

        // Configurez la pagination
        $paginator->getQuery()
            ->setFirstResult(($page - 1) * $nbre)
            ->setMaxResults($nbre);

        return $paginator;
    }
}

