<?php 
    include("../include/connect.inc.php");

    $logId = $_POST['logId'];

    $delProblem = "DELETE FROM log WHERE id = '$logId'";
    $qDelProblem = $conn->query($delProblem);

    if($qDelProblem){
        echo json_encode(1);
    }else{
        echo json_encode(0);
    }
?>