<?php

namespace App\Doctrine\Attribute\Filter;

#[\Attribute(\Attribute::TARGET_CLASS | \Attribute::IS_REPEATABLE)]
class Range extends AbstractFilterAttribute
{
}