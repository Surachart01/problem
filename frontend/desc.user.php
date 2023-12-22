<?php  
    include("../include/connect.inc.php");

    $userId = $_POST['userId'];

    $sql = "SELECT * FROM member WHERE id = '$userId'";
    $qSql = $conn->query($sql);
    $dataUser = $qSql->fetch_object();
    if($dataUser->status == "9"){
        $status = "ผู้ดูแลระบบ";
    }else if($dataUser->status == "5"){
        $status = "ช่าง";
    }else{
        $status = "ผู้ใช้งาน";
    }
?>
<label for="">ชื่อ</label>
<input type="text" class="form-control my-3" id="name" value="<?php echo $dataUser->name ?>">
<label for="">อีเมล์</label>
<input type="text" class="form-control my-3" id="email" value="<?php echo $dataUser->email ?>">
<label for="">รหัสผ่าน</label>
<input type="text" class="form-control my-3" id="password" value="<?php echo $dataUser->password ?>">
<label for="">เบอร์โทร</label>
<input type="text" class="form-control my-3" id="tel" value="<?php echo $dataUser->tel ?>">
<label for="">สถานะ : <?php echo $status; ?></label>
<div class="d-flex justify-content-between mt-2">
    <button class="btn btn-primary chgsta" data-status='1' data-id="<?php echo $dataUser->id ?>">ผู้ใช้งาน</button>
    <button class="btn btn-warning chgsta" data-status='5' data-id="<?php echo $dataUser->id ?>">ช่าง</button>
    <button class="btn btn-success chgsta" data-status='9' data-id="<?php echo $dataUser->id ?>">ผู้ดูแลระบบ</button>
</div>
<hr>
<button class="btn btn-primary mt-3 form-control " id="btnUpdateUser" data-id="<?php echo $dataUser->id; ?>">ยืนยัน</button>
