<?php 
    session_start();
    date_default_timezone_set("Asia/Bangkok");
    $dateName = date("Y-m-d_H:i:s");
    include("../include/connect.inc.php");
    $user = $_SESSION['iUser'];
    $userId = $user->id;
    $name = $_POST['name'];
    $tel = $_POST['tel'];
    $password = $_POST['password'];
    $statusImg = $_POST['statusImg'];


    if($statusImg == 1){ 
        $pathDel_image = $user->image;
        if($pathDel_image != "profile.jpeg"){
            if (file_exists($pathDel_image)) {   
                unlink($pathDel_image);  
            }
        }
        $img = $_FILES['image'];
        $upload_dir = "../image/profile";
        $nameFile = $user->id . "_" . $dateName;
        if($img['error'] == 0){
            $file_exp=strtolower(pathinfo($img['name'],PATHINFO_EXTENSION));
            $upload_filename = "$upload_dir"."/"."$nameFile.$file_exp";
            move_uploaded_file($img['tmp_name'],$upload_filename);

            $sqlUpImg = "UPDATE member SET image='$nameFile.$file_exp' WHERE id='$user->id'";
            $qUpImg = $conn->query($sqlUpImg);
        } 
    }else{
        $image = $_POST['image'];
    }

    $sqlUpUser = "UPDATE member SET name='$name',tel='$tel',password='$password' WHERE id='$user->id'";
    $qUpUser = $conn->query($sqlUpUser);
    $sqlSelUser = "SELECT * FROM member WHERE id='$user->id'";
    $qUser = $conn->query($sqlSelUser);
    $dataUser = $qUser->fetch_object();
    $_SESSION['iUser'] = $dataUser;
    if($qUpUser){
        echo json_encode("1");
    }else{
        echo json_encode("0");
    }


?>