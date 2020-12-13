<?php
/**
 * @link https://github.com/e-kevin/dsn
 * @copyright Copyright (c) 2020 E-Kevin
 * @license MIT
 */

namespace ekevin\dsn\type;

use ekevin\dsn\Dsn;

/**
 * Cubrid
 *
 * @see https://www.php.net/manual/en/ref.pdo-cubrid.php
 * @example cubrid:dbname=<dbname>;host=<hostname>;port=<port>
 *
 * @author E-Kevin <e-kevin@qq.com>
 */
class Cubrid extends Dsn
{

    protected $defaultPort = 3306;
    
}