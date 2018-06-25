<?php

namespace Blitheness\Deputy\Models;

use Blitheness\Deputy\BaseModel;

class Employee extends BaseModel {
    protected $objectName = "Employee";

    /**
     * ID of the Employee object
     *
     * @var integer
     */
    protected $id;

    /**
     * Company that this Employee object is a member of
     *
     * @var integer
     */
    protected $company;

    /**
     * Employee's first name
     *
     * @var string
     */
    protected $firstName;

    /**
     * Employee's surname
     *
     * @var string
     */
    protected $lastName;

    /**
     * Display name for this Employee object
     *
     * @var string
     */
    protected $displayName;

    /**
     * Another name that this Employee may be known by
     *
     * @var string
     */
    protected $otherName;

    /**
     * Employee salutation
     *
     * @var string
     */
    protected $salutation;

    /**
     * ID of Address object for this Employee
     *
     * @var integer
     */
    protected $mainAddress;

    /**
     * ID of Address object for this Employee's postal address;
     * typically same as mainAddress
     *
     * @var integer
     */
    protected $postalAddress;

    /**
     * ID of Contact object for this Employee object
     *
     * @var integer
     */
    protected $contact;

    /**
     * Emergency contact's address
     *
     * @var integer
     */
    protected $emergencyAddress;

    /**
     * Employee's date of birth in YYYY-MM-DD
     *
     * @var date
     */
    protected $dateOfBirth;

    /**
     * Employee gender
     *
     * @var integer
     */
    protected $gender;

    /**
     * Reference to file upload for Employee photograph
     *
     * @var integer
     */
    protected $photo;

    /**
     * User ID of this Employee
     *
     * @var integer
     */
    protected $userId;

    /**
     * Job Application ID for this Employee object
     *
     * @var integer
     */
    protected $jobAppId;

    /**
     * Whether or not this Employee is 'active' and can be rostered on
     *
     * @var boolean
     */
    protected $active;

    /**
     * Start date for this Employee
     *
     * @var date
     */
    protected $startDate;

    /**
     * Date when (if) this Employee was terminated
     *
     * @var date
     */
    protected $terminationDate;

    /**
     * Stress profile for this employee
     *
     * @var integer
     */
    protected $stressProfile;

    /**
     * Employee's main position
     *
     * @var string
     */
    protected $position;

    /**
     * Higher duty flag
     *
     * @var boolean
     */
    protected $higherDuty;

    /**
     * Role of this employee; typically 1=System Administrator, 3=Employee
     *
     * @var integer
     */
    protected $role;

    /**
     * Can an Appraisal be completed for this Employee?
     *
     * @var boolean
     */
    protected $allowAppraisal;

    /**
     * ID of this object's history
     *
     * @var integer
     */
    protected $historyId;

    /**
     * Reference to custom data/meta data for this Employee;
     * references CustomFieldData object
     *
     * @var integer
     */
    protected $customFieldData;

    /**
     * ID of user that created this employee
     *
     * @var integer
     */
    protected $creator;

    /**
     * Timestamp for when this object was created
     *
     * @var datetime
     */
    protected $created;

    /**
     * Timestamp of when this Employee was last modified
     *
     * @var datetime
     */
    protected $modified;

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
}
