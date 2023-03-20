<?php

namespace App\Doctrine\Filter;

use App\Doctrine\Attribute\Filter as Attribute;
use App\Doctrine\Filter\Strategy\FilterStrategyInterface;
use App\Doctrine\Filter\Strategy\SearchStrategy;
use Doctrine\ORM\QueryBuilder;

class SearchFilter extends AbstractFilter
{
    public function getSupportedAttribute(): string
    {
        return Attribute\Search::class;
    }

    public function applyFilter(
        QueryBuilder $qb,
        string $alias,
        string $property,
        mixed $value,
        ?FilterStrategyInterface $strategy = null,
    ): void {
        if (!is_string($value)) {
            return;
        }

        $value = strtolower($value);
        $value = $this->addWildcards($strategy, $value);

        $parameterName = $this->generateParameterName($alias, $property);

        $qb->andWhere(sprintf('LOWER(%s.%s) LIKE :%s', $alias, $property, $parameterName));
        $qb->setParameter($parameterName, $value);
    }

    public function addWildcards(?FilterStrategyInterface $strategy, string $value): string
    {
        return match ($strategy) {
            default => sprintf('%%%s%%', $value),
            SearchStrategy::Exact => $value,
            SearchStrategy::Start => sprintf('%s%%', $value),
            SearchStrategy::End => sprintf('%%%s', $value),
        };
    }
}