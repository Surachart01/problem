<?php  
    include("../include/connect.inc.php");
    session_start();

    $tel = $_POST['tel'];
    $password = $_POST['password'];

    $checkLogin = "SELECT * FROM member WHERE tel = '$tel' AND password = '$password'";
    $qLogin = $conn->query($checkLogin);
    $rLogin = $qLogin->num_rows;
    if($rLogin == 1){
        $dataUser = $qLogin->fetch_object();
        $_SESSION['iUser'] = $dataUser;
        echo json_encode($dataUser->status);
    }else{
        echo json_encode(0);
    }
?>