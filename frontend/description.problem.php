<?php
include("../include/connect.inc.php");
session_start();
$user = $_SESSION['iUser'];
$logId = $_POST['logId'];

$sqlSel = "SELECT * FROM log WHERE id = '$logId' ";
$qSel = $conn->query($sqlSel);
$data = $qSel->fetch_object();
if ($data->type == "true") {
    $type = "checked";
} else {
    $type = "";
}

if ($data->status == 0) {
    $status = "รอช่างรับปัญหา";
} else if ($data->status == 1) {
    $status = "อยู่ระหว่างการแก้ปัญหา";
} else {
    $status = "แก้ปัญหาเสร็จสิ้น";
}
?>

<div class="d-flex justify-content-center">
    <div class="text-start">
        <label for="">เลขครุภัณฑ์</label>
        <input type="text" class="form-control" value="<?php echo $data->codeFix ?>" id="codeFixE" maxlength="12">
        <label for="">รายการ</label>
        <input type="text" class="form-control" value="<?php echo $data->item ?>" id="descE">
        <label for="">ปัญหา</label>
        <textarea class="form-control" id="problemE"><?php echo $data->description ?></textarea>
        <label for="">ฝ่าย</label>
        <input type="text" class="form-control" value="<?php echo $data->room ?> " disabled>

        <?php if ($status == "รอช่างรับปัญหา") { ?>
            <label for="">สถานะ</label>
            <input type="text" class="form-control" value="<?php echo $status ?>" id="" disabled>
        <?php } else { ?>
            <label for="">วันที่เข้าซ่อม</label>
            <input type="datetime-local" value="<?php echo $data->startDate ?>" class="form-control my-2" disabled>
            <label for="">วันที่ซ่อมเสร็จ</label>
            <input type="datetime-local" value="<?php echo $data->endDate ?>" class="form-control my-2" disabled>
            <label for="">สถานะ</label>
            <div class="d-flex">
                <input type="text" class="form-control" value="<?php echo $status ?>" id="staffDesc" disabled
                    style="width: 200px;">
                <button class="btn btn-primary" id="btnDescStaff" data-staff="<?php echo $data->staff ?>">ช่าง</button>
            </div>
        <?php } ?>
        <div class=""><input type="checkbox" class="me-2 form-check-input" <?php echo $type ?> id="checkD">
            <span class="me-5 text-danger">ด่วนที่สุด</span>
        </div>
        <div class="d-flex justify-content-evenly">
            <button class="btn btn-warning" id="editProblem" data-log="<?php echo $data->id; ?>">แก้ไข</button>
            <button class="btn btn-danger" id="delProblem" data-status="<?php echo $data->status; ?>"
                data-log="<?php echo $data->id; ?>">ลบ</button>
        </div>
    </div>

</div>