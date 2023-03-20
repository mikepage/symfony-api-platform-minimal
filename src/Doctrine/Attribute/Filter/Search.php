<?php

namespace App\Doctrine\Attribute\Filter;

use App\Doctrine\Filter\Strategy\FilterStrategyInterface;
use App\Doctrine\Filter\Strategy\SearchStrategy;

#[\Attribute(\Attribute::TARGET_CLASS | \Attribute::IS_REPEATABLE)]
class Search extends AbstractFilterAttribute
{
    public function __construct(string $propertyName, FilterStrategyInterface $strategy = SearchStrategy::Partial)
    {
        parent::__construct($propertyName, $strategy);
    }
}