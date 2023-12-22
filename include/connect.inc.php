<?php 
    $host = "localhost";
    $usrename = "root";
    $password = "";
    $dbname = "problem";

    $conn = new mysqli($host,$usrename,$password,$dbname);

    if(!$conn){
        echo mysqli_connect_errno();
    }

?>