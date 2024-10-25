<?php
    class conexion{

        public $conn;

        function __construct(){
            //local
            $this->conn = new mysqli("localhost", "root", "", "gps", 3306);

            // produccion
            //$this->conn = new mysqli("193.203.166.100","u798288314_admin","xbb2-A2+C27A2","u798288314_gpsingenieria",3306);
        }

        public function checar(){   
            if ($this->conn->connect_errno) {
                echo "Fallo al conectar a MySQL: (" . $this->conn->connect_errno . ") " . $this->conn->connect_error;
                
            }else{
                echo $this->conn->host_info . "\nsoy yo";
            }
        }
    }
?>