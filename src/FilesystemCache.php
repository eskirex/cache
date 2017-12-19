<?php

namespace Eskirex\Component\Cache;

use Eskirex\Component\Cache\Adapters\FilesystemAdapter;

class FilesystemCache extends FilesystemAdapter
{
    public function __construct(string $namespace = null, string $directory = null)
    {
        parent::__construct($namespace, $directory);
    }
}