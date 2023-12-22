<?php
include("../include/connect.inc.php");
session_start();
$user = $_SESSION['iUser'];
$logId = $_POST['logId'];

$sqlSel = "SELECT * FROM log WHERE id = '$logId' ";
$qSel = $conn->query($sqlSel);
$data = $qSel->fetch_object();
if($data->type == "true"){
    $type = "checked";
}else{
    $type = "";
}

if($data->status == 0){ $status = "รอช่างรับปัญหา "; }else if($data->status == 1){ $status="อยู่ระหว่างการแก้ปัญหา";}else{
    $status="แก้ปัญหาเสร็จสิ้น";
}
?>

<div class="d-flex justify-content-center">
    <div class="text-start">
        <label for="">เลขครุภัณฑ์</label>
        <input type="text" class="form-control" value="<?php echo $data->codeFix ?>" id="codeFixE" maxlength="12" disabled>
        <label for="">รายการ</label>
        <input type="text" class="form-control" value="<?php echo $data->item ?>" id="descE" disabled>
        <label for="">ปัญหา</label>
        <textarea class="form-control" id="problemE" disabled><?php echo $data->description ?></textarea>
        <label for="">ฝ่าย</label>
        <input type="text" class="form-control" value="<?php echo $data->room ?> " disabled>
        <label for="">สถานะ</label>
        <input type="text" class="form-control" value="<?php echo $status ?>" id="" disabled>
        <div class=""><input type="checkbox" class="me-2 form-check-input" disabled <?php echo $type ?> id="checkD">
        <span class="me-5 text-danger">ด่วนที่สุด</span></div>
    </div>

</div>