<?php 
    include("../include/connect.inc.php");

    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $status = $_POST['status'];
    $tel = $_POST['tel'];
    $sql = "INSERT INTO member (name ,email, password , status ,tel) VALUES ('$name','$email','$password','$status','$tel')";
    $qSql = $conn->query($sql);

    if($qSql){
        echo json_encode(1);
    }else{
        echo json_encode(0);
    }
?>