<?php

namespace Blitheness\Deputy\Models;

use Blitheness\Deputy\BaseModel;

class EmploymentContract extends BaseModel {
    protected $objectName = "EmploymentContract";
    protected $readOnly = true;

    protected $attributes = [
        'Id',
        'Code',
        'Name',
        'Description',
        'EmploymentBasis',
        'EmploymentCategory',
        'EmploymentStatus',
        'EmploymentCondition',
        'BasePayRule',
        'StressProfile',
        'StartDate',
        'EndDate',
        'PeriodType',
        'File',
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
        'Name',
        'EmploymentBasis',
        'EmploymentCategory',
        'EmploymentStatus',
        'BasePayRule',
        'PeriodType'
    ];

    /**
     * Fields that must have an integer value
     *
     * @var array
     */
    protected $integers = [
        'Id',
        'EmploymentBasis',
        'EmploymentCategory',
        'EmploymentStatus',
        'EmploymentCondition',
        'BasePayRule',
        'StressProfile',
        'PeriodType',
        'File',
        'Creator'
    ];

    /**
     * Fields that must be dates
     * YYYY-MM-DD
     *
     * @var array
     */
    protected $dates = [
        'StartDate',
        'EndDate'
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
        'Code',
        'Name',
        'Description'
    ];

    /**
     * Fields that must have a boolean value
     *
     * @var array
     */
    protected $booleans = [];
}
