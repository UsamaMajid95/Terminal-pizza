<?php
namespace app;
abstract class pizzes{
    public $host = 'localhost';
    public $username = 'root';
    public $password = '';
    public $db = 'terminal_pizza2';
    public $conn;
    
    public function __construct(){
        
        $this->conn = mysqli_connect($this->host,$this->username,$this->password,$this->db);

    }
    
    abstract function check($typeofpizze,$size,$coyc);

}


?>