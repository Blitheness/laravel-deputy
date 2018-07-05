# laravel-deputy
Laravel package for interacting with the Deputy API. Deputy is a powerful business management system, available from https://www.deputy.com.

This package is provided AS-IS, with no guarantee of functionality or support. This package is not meant to work for every use case. More information may be found in this repository's LICENSE file.

Some basic instructions are provided below.

## Installation
`composer install blitheness/laravel-deputy`

`php artisan vendor:publish` _(then enter number for Blitheness\Deputy\DeputyServiceProvider)_

## Configuration
Either update **config/deputy.php** to change the 'url' and 'token' values, or set 'DEPUTY_URL' and 'DEPUTY_TOKEN' values in your .env file.

The URL is the Deputy subdomain that your company is using, such as "mycompany.eu.deputy.com", without any "http://", "http://", or any trailing slashes.

The token is your Deputy API 'Permanent Token', which may be created by a System Administrator in your organisation. An authorised user may generate a token by following the instructions in the Deputy API documentation: https://www.deputy.com/api-doc/API/Authentication

## Usage
### Resources
- Company
- Employee
- EmployeeAgreement
- EmployeeContract
- EmployeeWorkplace
- OperationalUnit
- User (read-only)

### Facades
To make use of a Deputy 'resource', use a real-time Facade.

Add this to the top of your controller `use Facades\Blitheness\Deputy\Models\RESOURCE_NAME;` where RESOURCE_NAME is a resource from the list above.

### Retrieving Data
#### Known ID
`$result = Resource::find(ID)`

Where **Resource** is a resource from the list above, and **ID** is the ID of the resource in Deputy that you are attempting to find.

#### Searching
To search, use the 'search' method on that resource's real-time facade:

`$results = Resource::search('FieldName', 'eq', 'Value')->get();`

More than one condition may be used per query by chaining the search calls together, such as:

`$results = Resource::search('FieldName', 'eq', 'Value')->search('Active', 'eq', '1')->get();`

### Updating Resources
To update a resource, it must not be a read-only resource.

First, retrieve the resource you wish to modify, for example:

`$resource = Employee::find(123);`

Secondly, change the desired attribute(s) on the model:

`$resource->FirstName = "New First Name";`

Finally, call the save method on the model:

`$resource->save()`
