<?php

    class Database {

        // DB Params
        private $host = "mysql:host=bhuw8e1t1dpd5pyq0xhe-mysql.services.clever-cloud.com;dbname=bhuw8e1t1dpd5pyq0xhe";
        private $username = "u658skrcoq6mshbk";
        private $password = "V8YhUBT9AJA6lNfmrbsf";
        private $conn = null;

        // DB Connect
        public function connect() {
            $this->conn = null;
            try {
                $this->conn = new PDO($this->host, $this->username, $this->password);
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (Exception $e) {
                echo "Connection failed: $e->getMessage()";
            }
            return $this->conn;
        }

    }

    $databases = new Database();
    $db = $databases->connect();

?>