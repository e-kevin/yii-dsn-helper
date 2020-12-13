<?php
/**
 * @link https://github.com/e-kevin/dsn
 * @copyright Copyright (c) 2020 E-Kevin
 * @license MIT
 */

namespace ekevin\dsn\type;

use ekevin\dsn\Dsn;

/**
 * Pgsql
 *
 * @see https://www.php.net/manual/en/ref.pdo-pgsql.connection.php
 * @example pgsql:host=<hostname>;port=<port>;dbname=<db>;user=<username>;password=<password>
 *
 * @author E-Kevin <e-kevin@qq.com>
 */
class Pgsql extends Dsn
{

    protected $defaultPort = 5432;
    
}