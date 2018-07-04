<?php

namespace Blitheness\Deputy\Models;

use Blitheness\Deputy\BaseModel;

class User extends BaseModel {
    protected $objectName = "userinfo";
    protected $isResource = false;
    protected $readOnly   = true;

    /**
     * Array of attribute names that exist for this resource
     */
    protected $attributes = [
        'Id',
        'DisplayName',
        'Photo',
        'Employee'
    ];

    /**
     * Fields that must have an integer value
     *
     * @var array
     */
    protected $integers = [
        'Id',
        'Employee'
    ];

    /**
     * Fields that must be strings
     *
     * @var array
     */
    protected $strings = [
        'DisplayName',
        'Photo'
    ];
}
