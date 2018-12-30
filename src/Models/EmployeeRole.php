<?php

namespace Blitheness\Deputy\Models;

use Blitheness\Deputy\BaseModel;

class EmployeeRole extends BaseModel {
    protected $objectName = "EmployeeRole";
    protected $readOnly = false;

    protected $attributes = [
        'Id',
        'Role',
        'Ranking',
        'ReportTo', // EmployeeRole ID
        'Permissions',
        'Require2fa',
        'Creator',
        'Created',
        'Modified'
    ];

    /**
     * Array of fields that are required to have values for this object
     *
     * @var array
     */
    protected $required = [
        'Role',
        'Ranking'
    ];

    /**
     * Fields that must have an integer value
     *
     * @var array
     */
    protected $integers = [
        'Id',
        'Ranking',
        'ReportTo',
        'Creator'
    ];

    /**
     * Fields that must be dates
     * YYYY-MM-DD
     *
     * @var array
     */
    protected $dates = [
    ];

    /**
     * Fields that must be datetime (timestamp)
     *
     * @var array
     */
    protected $timestamps = [
        'Created',
        'Modified'
    ];

    /**
     * Fields that must be strings
     *
     * @var array
     */
    protected $strings = [
        'Role'
    ];

    /**
     * Fields that must have a boolean value
     *
     * @var array
     */
    protected $booleans = [
        'Require2fa'
    ];
}
