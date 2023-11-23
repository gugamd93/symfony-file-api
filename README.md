# symfony-file-api
This is a Symfony API responsible for providing data contained in an .xlsx document.
SOLID principles were implemented, as well as some layers and Dependency Injection.
Unit tests and integration tests (API Tests) were implemented using PHPUnit.

## Overview

This project aims to provide customers with a comprehensive list of 
server information, facilitating quick search and filtering of server 
specifications. The data for this application has been 
sourced from multiple departments within an Excel sheet 
(`Leaseweb_servers_filters_assignment.xlsx`). 
The backend API is developed using PHP with the Symfony framework.

## Functional Requirements

- Display a comprehensive list of server information.
- Implement multiple filters for efficient searching and finding of server details.
- Available filters:

| Filters      | Type   | Values                                                          |
|--------------|--------|-----------------------------------------------------------------|
| Storage      | string | 0, 250GB, 500GB, 1TB, 2TB, 3TB, 4TB, 8TB, 12TB, 24TB, 48TB, 72TB |
| Ram          | array  | 2GB, 4GB, 8GB, 12GB, 16GB, 24GB, 32GB, 48GB, 64GB, 96GB         |
| Harddisk type| string | SAS, SATA, SSD                                                  |
| Location     | string | Refer to Location list (`Leaseweb_servers_filters_assignment.xlsx`)                                         |


## Technical Requirements
- Develop using PHP with Symfony
- Use caching for performance improvements
- Implement unit and integration tests

## Usage

### Prerequisites

- PHP >= 8.1
- Composer

### Installation

1. Clone the repository
2. Install the dependencies
   `composer install`
3. Run the server `symfony server:start` or `php -S 127.0.0.1:8000 -t public/`

### Tests

Unit and integration tests are available and should be run with:
```
php .\bin\phpunit 
```

### Requests
Here is a list of ways of performing requests:
- Import the Postman collection from the file `SF File Server API.postman_collection.json`.
- Run a PowerShell command:
    ```
       $response = Invoke-RestMethod 'http://127.0.0.1:8000/api/server?filter[Location]=Washington D.C.WDC-01&filter[Harddisk type]=SATA&filter[Storage]=1TB&filter[Ram][]=8GB&filter[Ram][]=4GB' -Method 'GET' -Headers $headers
       $response | ConvertTo-Json
    ```
- Run a cURL command:
    ```
      curl --location --globoff 'http://127.0.0.1:8000/api/server?filter[Location]=Washington%20D.C.WDC-01&filter[Harddisk%20type]=SATA&filter[Storage]=1TB&filter[Ram][]=8GB&filter[Ram][]=4GB'
    ```

### TO DO
- Add authentication feature
- Improve ServerRow class and review its responsibilities
