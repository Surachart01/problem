<?php  
    include("../include/connect.inc.php");

    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $tel = $_POST['tel'];
    

    $sql = "INSERT INTO member (name,email,password,tel,status) VALUES ('','','','')"

?>