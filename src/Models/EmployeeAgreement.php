<?php

namespace Blitheness\Deputy\Models;

use Blitheness\Deputy\BaseModel;

class EmployeeAgreement extends BaseModel {
    protected $objectName = "EmployeeAgreement";
    protected $readOnly = true;

    protected $attributes = [
        'Id',
        'EmployeeId',
        'PayPoint',
        'EmpType',
        'CompanyName',
        'Active',
        'StartDate',
        'Contract',
        'SalaryPayRule',
        'ContactFile',
        'PayrollId',
        'PayPeriod',
        'HistoryId',
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
        'PayPoint',
        'EmpType',
        'Active',
        'StartDate',
        'PayPeriod'
    ];

    /**
     * Fields that must have an integer value
     *
     * @var array
     */
    protected $integers = [
        'Id',
        'EmployeeId',
        'PayPoint',
        'EmpType',
        'Contract',
        'SalaryPayRule',
        'ContractFile',
        'PayPeriod',
        'HistoryId',
        'Creator'
    ];

    protected $dates = [
        'StartDate'
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
        'CompanyName',
        'PayrollId'
    ];

    /**
     * Fields that must have a boolean value
     *
     * @var array
     */
    protected $booleans = [
        'Active'
    ];
}
