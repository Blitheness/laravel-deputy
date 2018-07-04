<?php

namespace Blitheness\Deputy\Facades;

use Illuminate\Support\Facades\Facade;

class Deputy extends Facade {
    protected static function getFacadeAccessor() {
        return 'deputy';
    }
}
