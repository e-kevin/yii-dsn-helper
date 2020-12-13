<?php
/**
 * @link https://github.com/e-kevin/dsn
 * @copyright Copyright (c) 2020 E-Kevin
 * @license MIT
 */

namespace ekevin\dsn\type;

use ekevin\dsn\Dsn;

/**
 * Mysql
 *
 * @see https://www.php.net/manual/en/ref.pdo-mysql.connection.php
 * @example mysql:host=<hostname>;dbname=<db>;port=<port>
 *
 * @author E-Kevin <e-kevin@qq.com>
 */
class Mysql extends Dsn
{

    protected $defaultPort = '3306';
    
}