<?php  
    include("../include/connect.inc.php");

    $logId = $_POST['logId'];
    
    $sqlUpdate = "UPDATE log SET status='2' WHERE id='$logId'";
    $qUpdate = $conn->query($sqlUpdate);
    
    if($qUpdate){
        echo json_encode(1);
    }else{
        echo json_encode(0);
    }
?>