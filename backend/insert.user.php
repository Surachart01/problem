<?php 
    include("../include/connect.inc.php");

    $name = $_POST['name'];
    $password = $_POST['password'];
    $status = $_POST['status'];
    $tel = $_POST['tel'];
    $sql = "INSERT INTO member (name , password , status ,tel) VALUES ('$name','$password','$status','$tel')";
    $qSql = $conn->query($sql);

    if($qSql){
        echo json_encode(1);
    }else{
        echo json_encode(0);
    }
?>