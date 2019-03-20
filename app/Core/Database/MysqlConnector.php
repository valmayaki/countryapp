<?php
namespace App\Core\Http;

class MysqlConnector
{
    protected $link;
    private $username;
    private $dsn;
    private $password;
    function  __construct($dsn, $username, $password)
    {
        $this->dsn = $dsn;
        $this->username = $username;
        $this->password = $password;
        $this->connect();
    }

    public function connect()
    {
        $this->link = new \PDO($this->dsn, $this->username, $this->password, null);
    }

    public function __sleep()
    {
        return array('dsn', 'username', 'password');
    }
    public function getConnection()
    {
        return $this->link;
    }
}