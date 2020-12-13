<?php
/**
 * @link https://github.com/e-kevin/dsn
 * @copyright Copyright (c) 2020 E-Kevin
 * @license MIT
 */

namespace ekevin\dsn;

use yii\base\BaseObject;
use yii\base\InvalidConfigException;

/**
 * Class Dsn
 *
 * @property string $scheme
 *
 * @author E-Kevin <e-kevin@qq.com>
 */
class Dsn extends BaseObject
{
    
    public
        $dsn,
        $hostname,
        $dbname,
        $port;
    
    protected
        $defaultHostKey = 'host',
        $defaultDatabaseKey = 'dbname',
        $defaultPort,
        $parseDsn;
    
    private $_scheme;
    
    private static $_type = ['cubrid', 'dblib', 'mssql', 'mysql', 'mysqli', 'oci', 'pgsql', 'sqlite', 'sqlite2', 'sqlsrv'];
    
    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
        if ($this->dsn) {
            if ($this->_scheme === null) {
                $this->setScheme(substr($this->dsn, 0, strpos($this->dsn, ':')));
            }
            $this->_parseDsnInternal();
        } else {
            $this->_buildDsnInternal();
        }
    }
    
    /**
     * @param string $dsn
     *
     * @return Dsn
     */
    public static function parse($dsn)
    {
        $scheme = substr($dsn, 0, strpos($dsn, ':'));
        $class = __NAMESPACE__ . '\\type\\' . ucfirst($scheme);
        
        return new $class([
            'scheme' => $scheme,
            'dsn'    => $dsn,
        ]);
    }
    
    /**
     * @param array $config
     *
     * @return Dsn
     * @throws InvalidConfigException
     */
    public static function build($config)
    {
        if (!isset($config['scheme'])) {
            throw new InvalidConfigException('Scheme type must be set.');
        }
        unset($config['dsn']);
        $class = __NAMESPACE__ . '\\type\\' . ucfirst($config['scheme']);
        
        return new $class($config);
    }
    
    /**
     * @return string
     */
    private function _buildDsnInternal()
    {
        $this->parseDsn[$this->defaultDatabaseKey] = $this->dbname;
        if ($this->hostname) {
            $this->parseDsn[$this->defaultHostKey] = $this->hostname;
        }
        if ($this->port || $this->defaultPort) {
            $this->parseDsn['port'] = $this->port ?: $this->defaultPort;
        }
        
        return $this->buildDsn();
    }
    
    /**
     * cubrid:host=<hostname>;dbname=<db>;port=<port>
     * mysql:host=<hostname>;dbname=<db>;port=<port>
     * mysqli:host=<hostname>;dbname=<db>;port=<port>
     * pgsql:host=<hostname>;dbname=<db>;port=<port>;user=<username>;password=<password>
     *
     * @return string
     */
    protected function buildDsn()
    {
        $array = array_map(
            function ($k, $v) {
                return $k . '=' . $v;
            },
            array_keys($this->parseDsn),
            $this->parseDsn
        );
        
        return $this->dsn = $this->_scheme . ':' . implode(';', $array);
    }
    
    private function _parseDsnInternal()
    {
        $parseDsn = parse_url($this->dsn);
        $data = $parseDsn['path'];
        $array = array_map(
            function ($_) {
                return explode('=', $_);
            },
            explode(';', $data)
        );
        $this->parseDsn($array);
    }
    
    /**
     * cubrid:host=<hostname>;dbname=<db>;port=<port>
     * mysql:host=<hostname>;dbname=<db>;port=<port>
     * mysqli:host=<hostname>;dbname=<db>;port=<port>
     * pgsql:host=<hostname>;dbname=<db>;port=<port>;user=<username>;password=<password>
     *
     * @param $array
     */
    protected function parseDsn($array)
    {
        foreach ($array as $element) {
            $this->parseDsn[$element[0]] = $element[1];
        }
    }
    
    public function getParseDsn()
    {
        return $this->parseDsn;
    }
    
    public function getDatabase()
    {
        return $this->parseDsn[$this->defaultDatabaseKey];
    }
    
    public function getHost()
    {
        return $this->parseDsn[$this->defaultHostKey] ?? null;
    }
    
    public function getPort()
    {
        return $this->parseDsn['port'] ?? $this->defaultPort;
    }
    
    public function setScheme($scheme)
    {
        if (!in_array($scheme, self::$_type)) {
            throw new InvalidConfigException('Invalid scheme type.');
        }
        $this->_scheme = $scheme;
    }
    
    public function getScheme()
    {
        return $this->_scheme;
    }
    
    static public function getTypeList()
    {
        return array_combine(self::$_type, self::$_type);
    }
    
}