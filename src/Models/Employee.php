<?php

namespace Blitheness\Deputy\Models;

use Blitheness\Deputy\BaseModel;

class Employee extends BaseModel {
    protected $objectName = "Employee";
    protected $readOnly = false;

    protected $attributes = [
        'Id',
        'Company',
        'FirstName',
        'LastName',
        'DisplayName',
        'Contact',
        'Employee',
        'Active',
        'Role',
        'AllowAppraisal',
        'DateOfBirth',
        'StartDate',
        'Created',
        'Modified',
        'TerminationDate'
    ];

    /**
     * Array of fields that are required to have values for this object
     *
     * @var array
     */
    protected $required = [
        'Company',
        'FirstName',
        'LastName',
        'DisplayName',
        'Contact',
        'Active',
        'Role',
        'AllowAppraisal'
    ];

    /**
     * Fields that must have an integer value
     *
     * @var array
     */
    protected $integers = [
        'Id',
        'Company',
        'MainAddress',
        'PostalAddress',
        'Contact',
        'EmergencyAddress',
        'Gender',
        'Photo',
        'UserId',
        'JobAppId',
        'StressProfile',
        'Role',
        'HistoryId',
        'CustomFieldData',
        'Creator'
    ];

    /**
     * Fields that must be dates
     * YYYY-MM-DD
     *
     * @var array
     */
    protected $dates = [
        'DateOfBirth',
        'StartDate',
        'TerminationDate'
    ];

    /**
     * Fields that must be datetime (timestamp)
     *
     * @var array
     */
    protected $timestamps = [
        'created',
        'modified'
    ];

    /**
     * Fields that must be strings
     *
     * @var array
     */
    protected $strings = [
        'FirstName',
        'LastName',
        'DisplayName',
        'OtherName',
        'Salutation',
        'Position'
    ];

    /**
     * Fields that must have a boolean value
     *
     * @var array
     */
    protected $booleans = [
        'Active',
        'HigherDuty', // nullable
        'AllowAppraisal'
    ];

    public function addToLocation(int $location) {
        $this->invalidateCache();
        $this->payload = [];
        $this->method = 'POST';
        $this->isResource = false;
        $this->path = 'supervise/employee/' . $this->Id . '/assoc/' . $location;
        $output = $this->get();
        $this->isResource = true;
        return $output;
    }

    public function removeFromLocation(int $location) {
        $this->invalidateCache();
        $this->payload = [];
        $this->method = 'POST';
        $this->isResource = false;
        $this->path = 'supervise/employee/' . $this->Id . '/unassoc/' . $location;
        $output = $this->get();
        $this->isResource = true;
        return $output;
    }

    public function terminate() {
        $this->invalidateCache();
        $this->payload = [];
        $this->method = 'POST';
        $this->isResource = false;
        $this->path = 'supervise/employee/' . $this->Id . '/terminate';
        $output = $this->get();
        $this->isResource = true;
        return $output;
    }

    public function mapCompanyName($id = null) {
        if(null == $id) {
            $id = $this->Company;
        }
        return config('deputy.companies.' . $id, $id);
    }
}
