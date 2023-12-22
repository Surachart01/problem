<?php 
    session_start();
    include("../include/connect.inc.php");
    $codeFix = $_POST['codeFix'];
    $desc = $_POST['desc'];
    $problemP = $_POST['problemP'];
    $room = $_POST['room'];
    $checkD = $_POST['checkD'];
    $iUser = $_SESSION['iUser'];

    $sqlInsertProblem = "INSERT INTO log (userId,item,description,codeFix,room,status,type) VALUES ('$iUser->id','$desc','$problemP','$codeFix','$room','0','$checkD')";
    $qInsertProblem = $conn->query($sqlInsertProblem);

    if($qInsertProblem){
        echo json_encode(1);
    }else{
        echo json_encode(0);
    }

?>