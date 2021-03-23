<?php

namespace LithiumDev\Impersonate;

use Illuminate\Support\Facades\Facade;
use LithiumDev\Impersonate\Services\ImpersonateManager;

class Impersonate extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return ImpersonateManager::class;
    }
}
