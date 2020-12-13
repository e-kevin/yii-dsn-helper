<?php
/**
 * @link https://github.com/e-kevin/dsn
 * @copyright Copyright (c) 2020 E-Kevin
 * @license MIT
 */

namespace ekevin\dsn\type;

use ekevin\dsn\Dsn;

/**
 * Sqlsrv
 *
 * @see https://www.php.net/manual/en/ref.pdo-sqlsrv.connection.php
 * @example sqlsrv:Server=<hostname>,<port>;Database=<db>
 *
 * @author E-Kevin <e-kevin@qq.com>
 */
class Sqlsrv extends Dsn
{
    
    protected $defaultHostKey = 'Server';
    protected $defaultDatabaseKey = 'Database';
    
    protected function buildDsn()
    {
        $array = array_map(
            function ($k, $v) {
                if ($k == $this->defaultHostKey) {
                    return $k . '=' . $v . (isset($this->parseDsn['port']) ? ',' . $this->parseDsn['port'] : '');
                } else {
                    return $k == 'port' ? '' : $k . '=' . $v;
                }
            },
            array_keys($this->parseDsn),
            $this->parseDsn
        );
    
        return $this->dsn = $this->getScheme() . ':' . implode(';', $array);
    }
    
    protected function parseDsn($array)
    {
        foreach ($array as $element) {
            if ($element[0] == $this->defaultHostKey) {
                if (strpos($element[1], ',') !== false) {
                    list($host, $port) = explode(',', $element[1]);
                    $this->parseDsn[$this->defaultHostKey] = $host;
                    $this->parseDsn['port'] = $port;
                } else {
                    $this->parseDsn[$this->defaultHostKey] = $element[1];
                }
            } else {
                $this->parseDsn[$element[0]] = $element[1];
            }
        }
    }
    
}