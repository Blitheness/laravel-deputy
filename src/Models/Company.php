<?php

namespace Blitheness\Deputy\Models;

use Blitheness\Deputy\BaseModel;

class Company extends BaseModel {
    protected $objectName = "Company";
    protected $readOnly = true;

    protected $attributes = [
        'Id',
        'Portfolio',
        'Code',
        'Active',
        'ParentCompany',
        'CompanyName',
        'TradingName',
        'BusinessNumber',
        'CompanyNumber',
        'IsWorkplace',
        'IsPayrollEntity',
        'PayrollExportCode',
        'Address',
        'Contact',
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
        'Code',
        'CompanyName',
        'IsWorkplace',
        'IsPayrollEntity'
    ];

    /**
     * Fields that must have an integer value
     *
     * @var array
     */
    protected $integers = [
        'Id',
        'Portfolio',
        'ParentCompany',
        'Address',
        'Contact',
        'Creator'
    ];

    /**
     * Fields that must be dates
     * YYYY-MM-DD
     *
     * @var array
     */
    protected $dates = [];

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
        'CompanyName',
        'TradingName',
        'BusinessNumber',
        'CompanyNumber',
        'PayrollExportCode'
    ];

    /**
     * Fields that must have a boolean value
     *
     * @var array
     */
    protected $booleans = [
        'Active',
        'IsWorkplace',
        'IsPayrollEntity'
    ];
}
