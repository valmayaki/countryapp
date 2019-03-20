<?php
namespace App\Core\Database;

class MysqlConnector
{
    protected $link;
    private $username;
    private $dsn;
    private $password;
    private $options= [];
    static protected $_instance;

    protected function  __construct($username, $password, $database, $host= '127.0.0.1', $port = '3306', $options=[])
    {
        $this->dsn = "mysql:host=${host};dbname=${database};port=${port}";
        $this->username = $username;
        $this->password = $password;
        $this->options = $options;
        $this->connect();
    }

    public function connect()
    {
        try{
            $this->link = new \PDO($this->dsn, $this->username, $this->password, $this->options);
        } catch(\PDOException $e){
            print "Error!: " . $e. "<br/>";
            die();
        }
    }

    public function __sleep()
    {
        return array('dsn', 'username', 'password');
    }
    public function getConnection()
    {
        return $this->link;
    }

    static public function getInstance($username, $password, $database, $host, $port, $options){
        if(!isset(static::$_instance)){
            static::$_instance = new static($username, $password, $database, $host, $port, $options);
        }
        return static::$_instance;
    }
}