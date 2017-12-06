<?php

class Db
{
    public $connection = '';

    public function __construct($conf = [])
    {
        if (empty($this->connection)) {
//            list($host, $user, $password, $database, $port) = $conf;
            $this->host = $conf['host'];
            $this->user = $conf['user'];
            $this->password = $conf['password'];
            $this->database = $conf['database'];
            $this->port = $conf['port'];

            if (!$connection = mysqli_connect($this->host, $this->user, $this->password, $this->database, $this->port)) {
                die("Connection failed: " . mysqli_connect_error());
            }

            $this->connection = $connection;
        }

        return $this;
    }

    public function __destruct()
    {
        mysqli_close($this->connection);
    }

    public function getConnection()
    {
        if (empty($this->connection)) {
            $this->connection = mysqli_connect($this->host, $this->user, $this->password, $this->database, $this->port);
        }

        return $this->connection;
    }

    public function query($sql)
    {
        $result = mysqli_query($this->connection, $sql);

        return $result;
    }

    public function getTables()
    {
        $sql = "SHOW TABLES";

        $tables = [];

        $rescolumns = mysqli_query($this->connection, $sql);
        while ($row = mysqli_fetch_assoc($rescolumns)) {
            $tables[] = $row['Tables_in_' . $this->database];
        }

        return $tables;
    }

    public function getTableColumns($tableName = '')
    {
        $sql = "SHOW FULL COLUMNS FROM ".$tableName.';';

        $fields = [];

        if ($rescolumns = mysqli_query($this->connection, $sql)) {
            while($row = mysqli_fetch_assoc($rescolumns)){
                $fields[$row['Field']] = $row;
            }
        } else {
            return [];
        }

        return $fields;
    }
}