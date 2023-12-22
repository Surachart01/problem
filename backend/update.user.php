<?php
include("../include/connect.inc.php");
$userId = $_POST['userId'];
$name = $_POST['name'];
$email = $_POST['email'];
$password = $_POST['password'];
$tel = $_POST['tel'];

$sqlUpdate = "UPDATE member SET name = '$name',email = '$email',password = '$password', tel ='$tel' WHERE id = '$userId'";
$qUpdate = $conn->query($sqlUpdate);

if ($qUpdate) {
    echo json_encode(1);
} else {
    echo json_encode(0);
}
?>