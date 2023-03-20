<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserRepository extends BaseRepository implements UserLoaderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function findQuery(array $params): ?User
    {
        $properties = $this->getProperties($params);
        $qb = $this->createQueryBuilder('t0');

        if ($properties['id'] ?? false) {
            $qb->where('t0.id = :id');
            $qb->setParameter('id', $properties['id']);
        }

        if ($properties['email'] ?? false) {
            $qb->where('t0.email = :email');
            $qb->setParameter('email', $properties['email']);
        }

        if (!($properties['id'] ?? $properties['email'] ?? false)) {
            return null;
        }

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

    public function listCountQuery(array $params)
    {
        $properties = $this->getProperties($params);

        $qb = $this->createQueryBuilder('t0');
        $this->applyFilterFromProperties($qb, $properties);

        $qb->select($qb->expr()->countDistinct('t0.id'));

        return $qb->getQuery()->getSingleScalarResult();
    }

    public function loadUserByIdentifier(string $identifier): ?UserInterface
    {
        $qb = $this->createQueryBuilder('t0');
        $qb->where('t0.email = :email');
        $qb->setParameter('email', $identifier);

        return $qb->getQuery()->getOneOrNullResult();
    }
}
