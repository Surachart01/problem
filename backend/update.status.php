<?php 
    include("../include/connect.inc.php");

    $status = $_POST['status'];
    $userId = $_POST['userId'];

    $sql = "UPDATE member SET status = '$status' WHERE id = '$userId'";
    $qSql = $conn->query($sql);
    if($qSql){
        echo json_encode(1);
    }else{
        echo json_encode(0);
    }
?>