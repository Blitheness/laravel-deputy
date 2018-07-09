<?php
return [
    // URL to your Deputy instance, WITHOUT a http:// or https:// prefix, and WITHOUT a '/' suffix.
    // e.g. mycompany.eu.deputy.com
    'url'   => env('DEPUTY_URL'),

    // Your permanent token for API access
    // Must be created with a System Administrator account
    'token' => env('DEPUTY_TOKEN'),

    // Mapping between Deputy Company IDs and Location names
    'companies' => [
        0 => 'Example Company',
    ],

    // Company that will be default for all new employees, unless it is overridden
    // A zero or null value means that this option will be ignored
    'default_company' => 0,

    // Should all employees be a part of the company defined in 'default_company' ?
    // This will add all newly created or activated employees to company 'default_company'
    // Do not set this to true if default_company is set to null or 0
    'all_in_default_company' = false,

    // Should an employee be terminated if its last remaining company is 'default_company' ?
    // Do not set this to true if default_company is set to null or 0
    'terminate_if_only_in_default' = false
];
