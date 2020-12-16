<?php
/**
 * @link https://github.com/e-kevin/yii-dsn-helper
 * @copyright Copyright (c) 2020 E-Kevin
 * @license MIT
 */

namespace ekevin\dsn\type;

use ekevin\dsn\Dsn;

/**
 * Oci
 *
 * @see https://www.php.net/manual/en/ref.pdo-oci.connection.php
 * @example oci:dbname=<db>
 * @example oci:dbname=//<hostname>:<port>/<db>
 *
 * @author E-Kevin <e-kevin@qq.com>
 */
class Oci extends Dsn
{
    
    protected function buildDsn()
    {
        $dsn = '';
        foreach ($this->parseDsn as $k => $v) {
            if ($k == $this->defaultDatabaseKey) {
                $host = '';
                if ($this->getHost()) {
                    $host = '//' . $this->getHost();
                    if ($this->getPort()) {
                        $host .= ':' . $this->getPort();
                    }
                    $host .= '/';
                } else {
                    unset($this->parseDsn['port'], $this->port);
                }
                
                $dsn = $k . '=' . $host . $v;
            }
        }
        
        return $this->dsn = $this->getScheme() . ':' . $dsn;
    }
    
    protected function parseDsn($array)
    {
        foreach ($array as $element) {
            if ($element[0] == $this->defaultDatabaseKey) {
                if (($pos = strrpos($element[1], '/')) !== false) {
                    $db = substr($element[1], $pos + 1);
                    $arr = substr($element[1], 0, $pos);
                    if (strpos($arr, ':') !== false) {
                        list($host, $port) = explode(':', $arr);
                        $this->parseDsn['port'] = $port;
                    } else {
                        $host = $arr;
                    }
                    $this->parseDsn[$this->defaultHostKey] = $host;
                    $this->parseDsn[$this->defaultDatabaseKey] = $db;
                } else {
                    $this->parseDsn[$element[0]] = $element[1];
                }
            } else {
                $this->parseDsn[$element[0]] = $element[1];
            }
        }
    }
    
}