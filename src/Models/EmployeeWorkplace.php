<?php

namespace Blitheness\Deputy\Models;

use Blitheness\Deputy\BaseModel;

class EmployeeWorkplace extends BaseModel {
    protected $objectName = "EmployeeWorkplace";
    protected $readOnly = true;

    protected $attributes = [
        'Id',
        'EmployeeId',
        'Company',
        'SortOrder',
        'Agreement1',
        'Agreement2',
        'Agreement3',
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
        'EmployeeId',
        'Company',
        'SortOrder'
    ];

    /**
     * Fields that must have an integer value
     *
     * @var array
     */
    protected $integers = [
        'Id',
        'EmployeeId',
        'Company',
        'SortOrder',
        'Agreement1',
        'Agreement2',
        'Agreement3',
        'Creator'
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
}
