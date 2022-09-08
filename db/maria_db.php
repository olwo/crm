<?php

class maria_db
{
    protected $config;
    protected $connection;
    protected $credentials;

    function __construct(){
        $this->config = parse_ini_file('db_config.ini');
        $this->InitDB();
    }

    protected function InitDB(){
        $this->connection = mysqli_connect($this->config['MARIA_DATABASESERVER'],$this->config['MARIA_DATABASEID'], $this->config['MARIA_DATABASEPW'],$this->config['MARIA_DATABASE']);

        if( !$this->connection ) {
            echo "Connection to MariaDB could not be established.<br /><pre>";
            die( print_r( sqlsrv_errors(), true));
        }
    }
}