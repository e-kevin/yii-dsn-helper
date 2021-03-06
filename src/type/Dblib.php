<?php
/**
 * @link https://github.com/e-kevin/yii-dsn-helper
 * @copyright Copyright (c) 2020 E-Kevin
 * @license MIT
 */

namespace ekevin\dsn\type;

use ekevin\dsn\Dsn;

/**
 * Dblib
 *
 * @see https://www.php.net/manual/en/ref.pdo-dblib.php
 * @example dblib:dbname=<db>;host=<hostname>:<port>
 *
 * @author E-Kevin <e-kevin@qq.com>
 */
class Dblib extends Dsn
{
    
    protected function buildDsn()
    {
        $array = array_map(
            function ($k, $v) {
                if ($k == $this->defaultHostKey) {
                    return $k . '=' . $v . (isset($this->parseDsn['port']) ? ':' . $this->parseDsn['port'] : '');
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
                if (strpos($element[1], ':') !== false) {
                    list($host, $port) = explode(':', $element[1]);
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