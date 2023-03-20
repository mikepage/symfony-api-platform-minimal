<?php

namespace App\Doctrine\Attribute\Filter;

use App\Doctrine\Filter\Strategy\FilterStrategyInterface;

abstract class AbstractFilterAttribute
{
    public function __construct(
        public readonly string $propertyName,
        public readonly FilterStrategyInterface $strategy,
    ) {
    }

    public function getPropertyName(): string
    {
        return $this->propertyName;
    }

    public function getStrategy(): FilterStrategyInterface
    {
        return $this->strategy;
    }
}