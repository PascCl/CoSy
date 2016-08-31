<?php

class Database
{
    private $connection;
    private static $instance;
    private $config;

    public static function getInstance() {

        if(!self::$instance) {
                self::$instance = new self();
        }
        return self::$instance;

    }

    private function __construct() {

        $this->config = parse_ini_file('databaseconfig.ini'); //set the correct file path here
        $this->connection = new mysqli($this->config['host'], $this->config['username'], $this->config['password'], $this->config['database']);

        if (mysqli_connect_error()) {
                trigger_error("Failed to connect to MySQL: " . mysqli_connect_error(), E_USER_ERROR);
        }

    }

    public function getConnection() {

        return $this->connection;

    }
	
}

?>