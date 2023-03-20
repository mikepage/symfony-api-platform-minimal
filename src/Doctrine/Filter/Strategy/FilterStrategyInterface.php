<?php

namespace App\Doctrine\Filter\Strategy;

interface FilterStrategyInterface
{
    public function getStrategy(): string;
}