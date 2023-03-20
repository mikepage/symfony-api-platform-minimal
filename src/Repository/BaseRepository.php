<?php

namespace App\Repository;

use App\Doctrine\PropertyHelperTrait;
use App\Doctrine\QueryBuilderFilterTrait;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectRepository;

class BaseRepository extends ServiceEntityRepository implements ObjectRepository
{
    use PropertyHelperTrait;
    use QueryBuilderFilterTrait;

    final public const FILTER_ORDER_KEY = 'order';

    public function __construct(protected ManagerRegistry $registry, $entityClass = null)
    {
        parent::__construct($registry, $entityClass);
    }

    protected function listDefaultOrder(): array
    {
        return [];
    }
}
