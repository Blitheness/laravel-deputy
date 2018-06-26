<?php

namespace Blitheness\Deputy;

use Illuminate\Support\Facades\Facade;

class DeputyFacade extends Facade {
    protected static function getFacadeAccessor() {
        return 'deputy';
    }
}
