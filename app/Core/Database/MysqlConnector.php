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
    /**
     * Check if a table exists in the current database.
     *
     * @param PDO $pdo PDO instance connected to a database.
     * @param string $table Table to search for.
     * @return bool TRUE if table exists, FALSE if no table found.
     */
    function tableExists($table) {

        // Try a select statement against the table
        // Run it in try/catch in case PDO is in ERRMODE_EXCEPTION.
        try {
            $result = $this->link->query("SELECT 1 FROM $table LIMIT 1");
        } catch (\Exception $e) {
            // We got an exception == table not found
            return FALSE;
        }

        // Result is either boolean FALSE (no table found) or PDOStatement Object (table found)
        return $result !== FALSE;
    }
    function __call($name, $arguments)
    {
        if(method_exists($this->link, $name)){
            return \call_user_func_array([$this->link, $name], $arguments);
        }
        return $this->{$name}(...$arguments);
    }

}