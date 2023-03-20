<?php

namespace App\Doctrine;

trait QueryNameHelperTrait
{
    public function generateJoin(string $parentAlias, string $association): string
    {
        return sprintf('%s.%s', $parentAlias, $association);
    }

    public function generateJoinAlias(string $parentAlias, string $association): string
    {
        return sprintf('%s_%s', $parentAlias, $association);
    }

    public function generatePath(string $alias, string $property): string
    {
        return sprintf('%s.%s', $alias, $property);
    }

    public function generateParameterName(string $alias, string $property): string
    {
        return sprintf('%s_%s', $alias, $property);
    }
}