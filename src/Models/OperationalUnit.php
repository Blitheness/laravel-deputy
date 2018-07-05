<?php

namespace Blitheness\Deputy\Models;

use Blitheness\Deputy\BaseModel;

class OperationalUnit extends BaseModel {
    protected $objectName = "OperationalUnit";
    protected $readOnly = true;

    protected $attributes = [
        'Id',
        'Company',
        'ParentOperationalUnit',
        'OperationalUnitName',
        'Active',
        'PayrollExportName',
        'Address',
        'Contact',
        'RosterSortOrder',
        'ShowOnRoster'
    ];

    /**
     * Array of fields that are required to have values for this object
     *
     * @var array
     */
    protected $required = [
        'Company',
        'OperationalUnitName',
        'ShowOnRoster'
    ];

    /**
     * Fields that must have an integer value
     *
     * @var array
     */
    protected $integers = [
        'Id',
        'Company',
        'ParentOperationalUnit',
        'Address',
        'Contact',
        'RosterSortOrder'
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
        'OperationalUnitName',
        'PayrollExportName'
    ];

    /**
     * Fields that must have a boolean value
     *
     * @var array
     */
    protected $booleans = [
        'Active',
        'ShowOnRoster'
    ];
}
