<?php  
    include("../include/connect.inc.php");

    $logId = $_POST['logId'];
    $codeFix = $_POST['codeFix'];
    $desc = $_POST['desc'];
    $problem = $_POST['problem'];

    $updateProblem = "UPDATE log SET codeFix = '$codeFix',item = '$desc', description = '$problem' WHERE id = '$logId'";
    $qUpdateProblem = $conn->query($updateProblem);
    
    if($qUpdateProblem){
        echo json_encode(1);
    }else{
        echo json_encode(0);
    }

?>