<?php

namespace App\Doctrine;

use App\Doctrine\Filter\AbstractFilter;
use Symfony\Component\DependencyInjection\Attribute\TaggedIterator;
use Symfony\Contracts\Service\Attribute\Required;

trait FiltersAwareTrait
{
    /** @var iterable<AbstractFilter> */
    private readonly iterable $filters;

    #[Required]
    public function setFilters(#[TaggedIterator('app.doctrine_filter')] iterable $filters): void
    {
        $this->filters = $filters;
    }

    /**
     * @return iterable<AbstractFilter>
     */
    public function getFilters(): iterable
    {
        return $this->filters;
    }
}