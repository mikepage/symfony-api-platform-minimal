<?php

namespace App\Doctrine;

use App\Doctrine\Attribute\Filter\AbstractFilterAttribute;
use App\Doctrine\Filter\AbstractFilter;
use Doctrine\ORM\QueryBuilder;

trait QueryBuilderFilterTrait
{
    use FiltersAwareTrait;

    abstract public function getClassName();

    public function applyFilterFromProperties(QueryBuilder $qb, array $properties): void
    {
        $alias = $qb->getRootAliases()[0] ?? null;

        $attributes = $this->getClassAttributesByPropertyName();
        $filters = $this->getFiltersBySupportedAttribute();

        foreach ($properties as $property => $value) {
            if (!is_string($property)) {
                continue;
            }

            $attribute = $attributes[$property] ?? null;
            if ($attribute === null) {
                continue;
            }

            $filter = $filters[$attribute::class] ?? null;
            if ($filter === null) {
                continue;
            }

            $filter->applyFilter($qb, $alias, $property, $value, $attribute->getStrategy());
        }
    }

    /**
     * @return array<string,AbstractFilterAttribute>
     */
    private function getClassAttributesByPropertyName(): array
    {
        $result = [];
        foreach ($this->getClassAttributes() as $attribute) {
            $instance = $attribute->newInstance();
            $result[$instance->getPropertyName()] = $instance;
        }

        return $result;
    }

    /**
     * @return array<string,AbstractFilter>
     */
    private function getFiltersBySupportedAttribute(): array
    {
        $result = [];
        foreach ($this->getFilters() as $filter) {
            $result[$filter->getSupportedAttribute()] = $filter;
        }

        return $result;
    }

    /**
     * @return array<\ReflectionAttribute>
     */
    private function getClassAttributes(): array
    {
        $class = new \ReflectionClass($this->getClassName());
        return $class->getAttributes(AbstractFilterAttribute::class, \ReflectionAttribute::IS_INSTANCEOF);
    }
}