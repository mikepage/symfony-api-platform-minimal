<?php

namespace App\Doctrine\Filter\Strategy;

enum SearchStrategy: string implements FilterStrategyInterface
{
    case Partial = 'partial';
    case Exact = 'exact';
    case Start = 'start';
    case End = 'end';

    public function getStrategy(): string
    {
        return $this->value;
    }
}