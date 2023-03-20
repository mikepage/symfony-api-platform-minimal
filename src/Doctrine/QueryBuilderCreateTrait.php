<?php

namespace App\Doctrine;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;

trait QueryBuilderCreateTrait
{
    abstract public function getClassName(): string;

    abstract protected function getEntityManager(): EntityManagerInterface;

    public function createQueryBuilder($alias): QueryBuilder
    {
        return $this->getEntityManager()->getRepository($this->getClassName())->createQueryBuilder($alias);
    }
}
