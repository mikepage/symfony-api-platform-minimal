<?php

namespace App\Repository;

use App\Entity\OrganisationRelation;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

class OrganisationRelationRepository extends BaseRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OrganisationRelation::class);
    }

    public function findQuery(array $params): ?OrganisationRelation
    {
        $properties = $this->getProperties($params);

        $qb = $this->createQueryBuilder('t0');
        $qb->where('t0.id = :id');
        $qb->setParameter('id', $properties['id']);

        return $qb->getQuery()->getOneOrNullResult();
    }

    public function listQuery(array $params): \ArrayIterator
    {
        $properties = $this->getProperties($params);

        $qb = $this->createQueryBuilder('t0');
        $this->applyFilterFromProperties($qb, $properties);

        $paginator = new Paginator($qb, $fetchJoinCollection = true);
        return $paginator->getIterator();
    }

    public function listCountQuery(array $params): ?int
    {
        $properties = $this->getProperties($params);

        $qb = $this->createQueryBuilder('t0');
        $this->applyFilterFromProperties($qb, $properties);

        $qb->select($qb->expr()->countDistinct('t0.id'));

        return $qb->getQuery()->getSingleScalarResult();
    }
}
