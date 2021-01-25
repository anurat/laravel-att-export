<?php

namespace Anurat\AttExport\Facades;

use Illuminate\Support\Facades\Facade;

class AttExport extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'attExport';
    }
}
