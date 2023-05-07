<?php
// disable All Error!
//error_reporting(0);

// help us, use Headers
// ob_start();
// Start Sessions
if(!isset($_SESSION)) {
    session_start();
}

function genRandomKeys(INT $limit = 6)
{
    $Dtt    = time();
    $keys   = '987654321ABCDEFGHKMNPQRSTUWYZ'.$Dtt.rand(2346,9178);
    return  substr(str_shuffle($keys), 0, $limit);
}

function secronize_($string) {
    return htmlentities(strip_tags($string), ENT_QUOTES, 'UTF-8');
}

define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_DATABASE', 'restfullapi');

class DB 
{
    private $host       = DB_SERVER;
    private $username   = DB_USERNAME;
    private $password   = DB_PASSWORD;
    private $database   = DB_DATABASE;
    
    protected $Jigo;
    
    public function __construct(){

        if (!isset($this->Jigo)) {
            
            $this->Jigo = new mysqli($this->host, $this->username, $this->password, $this->database);
            
            if ($this->Jigo->connect_error) die('Database error -> ' . $this->Jigo->connect_error);           
        }
        return $this->Jigo;
    }
    public function DDB()
    {
        $k = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
        if ($k->connect_error) die('Database error -> ' . $k->connect_error);   
        return $k;
    }
}
?>