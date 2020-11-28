<?php
class config {
    public $conn;
    function __construct() {
        $this->conn = mysqli_connect('localhost', 'root', '', 'Cab');
        if(!$this->conn) {
            die("Connection failed ".$conn->connect_error);
        }
    }
}
?>