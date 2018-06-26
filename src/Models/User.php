<?php

namespace Blitheness\Deputy\Models;

use Blitheness\Deputy\BaseModel;

class User extends BaseModel {
    protected $objectName = "userinfo";
    protected $isResource = false;

    /**
     * ID of the user
     *
     * @var integer
     */
    protected $id;

    /**
     * Display name for this Employee object
     *
     * @var string
     */
    protected $displayName;

    /**
     * URL to this user's photo
     *
     * @var string
     */
    protected $photo;

    /**
     * User's employee ID
     *
     * @var integer
     */
    protected $employeeId;

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
