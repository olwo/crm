<?php

class ms_db
{
    protected $config;
    protected $connection;
    protected $credentials;

    function __construct(){
        $this->config = parse_ini_file('db_config.ini');
        $this->InitDB();
    }

    protected function InitDB(){
        $this->credentials = array ("Database" => $this->config['MS_DATABASE'], "UID" => $this->config['MS_DATABASEID'], "PWD" => $this->config['MS_DATABASEPW'], "CharacterSet" => $this->config['MS_DATABASECHARSET']);
        $this->connection = sqlsrv_connect($this->config['MS_DATABASESERVER'], $this->credentials);

        if( !$this->connection ) {
            echo "Connection to MSSQL could not be established.<br /><pre>";
            die( print_r( sqlsrv_errors(), true));
        }
    }

    /**
     * @return array|false
     */
    public function readTable(string $table, string $where)
    {
        $sql = "SELECT * FROM " . $table;
        if ($where != ''){
            $sql .=" WHERE " . $where;
        }
        $options = array("Scrollable" => SQLSRV_CURSOR_FORWARD);
        $params = array();
        $stmt = sqlsrv_query( $this->connection, $sql, $params, $options);
        $result = array();
//        echo $sql . "</br>";
        while( $obj = sqlsrv_fetch_object( $stmt)) {
            $result[] = $obj;
        }
        return $result;
    }

    /**
     * @return array|false
     */
    public function updateTable(string $table, string $data, string $where)
    {
        $sql = "USE " . $this->config['MS_DATABASE'] . " UPDATE " . $table . " SET " . $data . " WHERE " . $where;

        $options = array("Scrollable" => SQLSRV_CURSOR_FORWARD);
        $params = array();
        $stmt = sqlsrv_query( $this->connection, $sql, $params, $options);
        $result = sqlsrv_errors();
//        echo $sql . "</br>";
        return $result;
    }
}