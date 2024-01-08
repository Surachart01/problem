<?php  
    include("../include/connect.inc.php");

    $staffId = $_POST['staffId'];

    $sql = "SELECT * FROM member WHERE id = '$staffId'";
    $qSql = $conn->query($sql);

    $data = $qSql->fetch_object();
?>

<p>ชื่อ : <?php echo $data->name; ?></p>
<p>เบอร์โทร : <?php echo $data->tel; ?></p>