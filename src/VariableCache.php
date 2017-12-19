<?php

namespace Eskirex\Component\Cache;

use Eskirex\Component\Cache\Adapters\VariableAdapter;

class VariableCache extends VariableAdapter
{
    public function __construct(string $namespace = null)
    {
        parent::__construct($namespace);
    }
}