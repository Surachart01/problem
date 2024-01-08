<?php 
    include("../include/connect.inc.php");

    session_start();
    $user = $_SESSION['iUser'];
    $logId = $_POST['logId'];
    $startDate = $_POST['startDate'];
    $endDate = $_POST['endDate'];

    $sqlUpdate = "UPDATE log SET status = '1', staff='$user->id',startDate='$startDate',endDate='$endDate' WHERE id = '$logId'";
    $qUpdate = $conn->query($sqlUpdate);

    if($qUpdate){
        echo json_encode(1);
    }else{
        echo json_encode(0);
    }
?>