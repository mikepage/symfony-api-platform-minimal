<?php

namespace App\Doctrine\Filter;

use App\Doctrine\Filter\Strategy\FilterStrategyInterface;
use App\Doctrine\QueryNameHelperTrait;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\Mapping\ClassMetadata;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;

#[AutoconfigureTag('app.doctrine_filter')]
abstract class AbstractFilter
{
    use QueryNameHelperTrait;

    abstract public function getSupportedAttribute(): string;

    abstract public function applyFilter(
        QueryBuilder $qb,
        Query\Expr\Andx $conditions,
        string $alias,
        string $property,
        mixed $value,
        ?FilterStrategyInterface $strategy = null,
    ): void;

    protected function getTypeOfField(ClassMetadata $classMetadata, string $property): string
    {
        return $classMetadata->getTypeOfField($property);
    }

    protected function getClassMetadata(QueryBuilder $queryBuilder, string $resourceClass): ClassMetadata
    {
        return $queryBuilder->getEntityManager()->getClassMetadata($resourceClass);
    }
}
