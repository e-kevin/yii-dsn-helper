<?php
/**
 * @link https://github.com/e-kevin/dsn
 * @copyright Copyright (c) 2020 E-Kevin
 * @license MIT
 */

namespace ekevin\dsn\type;

use ekevin\dsn\Dsn;

/**
 * Sqlite
 *
 * @see https://www.php.net/manual/en/ref.pdo-sqlite.connection.php
 * @example
 * sqlite:/opt/databases/mydb.sq3
 * sqlite::memory:
 *
 * @author E-Kevin <e-kevin@qq.com>
 */
class Sqlite extends Dsn
{
    
    protected function buildDsn()
    {
        $dsn = '';
        foreach ($this->parseDsn as $k => $v) {
            if ($k == $this->defaultDatabaseKey) {
                $dsn = $v;
            }
        }
    
        return $this->dsn = $this->getScheme() . ':' . $dsn;
    }
    
    protected function parseDsn($array)
    {
        foreach ($array as $element) {
            $this->parseDsn[$this->defaultDatabaseKey] = $element[0];
        }
    }
    
}