## Dsn connection string parsing

parsing dsn connection strings for most databases.

## Usage

```php
use ekevin\dsn\Dsn;

// parse dsn
$dsn = Dsn::parse("mysql:host='localhost';dbname='testDb';port=3306");

// build dsn
$dsn = Dsn::build([
    'scheme'   => 'mysql',
    'hostname' => 'localhost',
    'port'     => '3306',
    'dbname'   => 'testDb',
])->dsn;
```