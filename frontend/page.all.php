<?php
include("../include/connect.inc.php");
session_start();
$user = $_SESSION['iUser'];
$page = $_POST['page'];

if ($page == "problem") { ?>
    <div class="card shadow mt-5">
        <div class="card-body">
            <h2 class="text-center mt-5">แจ้งซ่อมครุภัณฑ์</h2>
            <div class="row content mx-5">
                <input type="text" class="form-control my-2 input" placeholder="เลขครุภัณฑ์" id="CodeFix" maxlength="12">
                <input type="text" class="form-control my-2 input" placeholder="ชื่อรายการ" id="desc">
                <input type="text" class="form-control my-2 input" placeholder="ปัญหา" id="problemP">
                <select class="my-3 input" id="room">
                    <option selected>โปรดเลือก กอง/หน่วยงาน</option>
                    <option value="สำนักงานปลัด">สำนักงานปลัด</option>
                    <option value="กองคลัง">กองคลัง</option>
                    <option value="กองช่าง">กองช่าง</option>
                    <option value="กองสาธรณะสุขและสิ่งแวดล้อม">กองสาธรณะสุขและสิ่งแวดล้อม</option>
                </select>

                <div class="d-flex justify-content-start">
                    <input type="checkbox" class="me-2 form-check-input" id="checkD">
                    <span class="me-5 text-danger">ด่วนที่สุด</span>
                </div>

                <button class="rounded nb text-light my-2 mb-5" id="submitProblem">แจ้งซ่อม</button>
            </div>
        </div>
    </div>



    <script>
        $(document).on("click", "#submitProblem", function () {
            var CodeFix = $('#CodeFix').val();
            var desc = $('#desc').val();
            var problemP = $('#problemP').val();
            var room = $('#room').val();
            var checkD = $('#checkD').prop('checked');
            var formdata = new FormData();
            formdata.append("codeFix", CodeFix);
            formdata.append("desc", desc);
            formdata.append("problemP", problemP);
            formdata.append("room", room);
            formdata.append("checkD", checkD);
            $.ajax({
                url: "../backend/insert.problem.php",
                type: "POST",
                data: formdata,
                dataType: "json",
                contentType: false,
                processData: false,
                success: function (data) {
                    if (data == 1) {
                        Swal.fire({
                            position: "top-end",
                            icon: "success",
                            title: "แจ้งเสร็จสิ้น",
                            showConfirmButton: false,
                            timer: 800
                        }).then(() => {
                            window.location.reload();
                        })
                    } else {
                        Swal.fire({
                            position: "top-end",
                            icon: "error",
                            showConfirmButton: false,
                            title: "เกิดข้อผิดพลาด",
                            timer: 800
                        })
                    }
                }
            })

        });
    </script>

<?php }
if ($page == "history") { ?>
    <div class="card mt-3 bg-light shadow">
        <div class="card-body">
            <table class="table-responsive w-100 " id="tableProblem">
                <thead>
                    <tr>

                        <th scope="col">รายการ</th>
                        <th scope="col">เลขครุภัณฑ์</th>
                        <th scope="col">ขั้นตอน</th>
                        <th scope="col">เวลา</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php

                    $sqlShowProblem = "SELECT * FROM log WHERE userId = '$user->id' Order BY status ASC";
                    $qShowProblem = $conn->query($sqlShowProblem);
                    $i = 1;
                    while ($data = $qShowProblem->fetch_object()) {

                        if ($data->status == 0) {
                            $status = "<span class='text-danger'>รอช่างรับปัญหา </span>";
                        } else if ($data->status == 1) {
                            $status = "<span class='text-warning'>อยู่ระหว่างการแก้ปัญหา</span>";
                        } else {
                            $status = "<span class='text-success'>แก้ปัญหาเสร็จสิ้น</span>";
                        }
                        ?>
                        <tr>
                            <td>
                                <?php echo $data->item ?>
                            </td>
                            <td>
                                <?php echo $data->codeFix ?>
                            </td>
                            <td>
                                <?php echo $status ?>
                            </td>
                            <td>
                                <?php echo $data->date ?>
                            </td>
                            <td>
                                <button class="btn btn-success " id="descript"
                                    data-log="<?php echo $data->id ?>">รายละเอียด</button>
                            </td>

                        </tr>
                        <?php $i++;
                    } ?>
                </tbody>
            </table>
        </div>
    </div>


    <script>
        let table = new DataTable('#tableProblem');

        $(document).on("click", "#btnDescStaff", function () {
            var staffId = $(this).data("staff");
            var formdata = new FormData()
            formdata.append("staffId", staffId);

            $.ajax({
                url: "desc.staff.php",
                type: "POST",
                data: formdata,
                dataType: "html",
                contentType: false,
                processData: false,
                success: function (data) {
                    Swal.fire({
                        html: data,
                        showConfirmButton: false,
                        title: "รายละเอียดช่าง",
                    })
                }

            })
        })
        $(document).on("click", "#descript", function () {
            var logId = $(this).data("log");
            var formdata = new FormData();
            formdata.append('logId', logId);
            console.log(logId)
            $.ajax({
                url: "description.problem.php",
                type: "POST",
                data: formdata,
                dataType: "html",
                contentType: false,
                processData: false,
                success: function (data) {
                    Swal.fire({
                        title: "ข้อมูลการแจ้ง",
                        showConfirmButton: false,
                        html: data
                    })
                }
            })
        })

        $(document).on("click", "#editProblem", function () {
            var logId = $(this).data("log");
            var codeFix = $('#codeFixE').val();
            var descE = $('#descE').val();
            var problem = $('#problemE').val();
            var formdata = new FormData();
            formdata.append("logId", logId);
            formdata.append("codeFix", codeFix);
            formdata.append("desc", descE);
            formdata.append("problem", problem);

            $.ajax({
                url: "../backend/edit.problem.php",
                type: "POST",
                data: formdata,
                dataType: "json",
                contentType: false,
                processData: false,
                success: function (data) {
                    console.log(data)
                    if (data == 1) {
                        Swal.fire({
                            title: "แก้ไขเสร็จสิ้น",
                            showConfirmButton: false,
                            icon: "success",
                            timer: 1000
                        }).then(() => {
                            window.location.reload();
                        })
                    } else {
                        Swal.fire({
                            title: "เกิดข้อผิกพลาด",
                            showConfirmButton: false,
                            icon: "error",
                            timer: 1000
                        })
                    }
                }
            })
        });

        $(document).on("click", "#delProblem", function () {
            var logId = $(this).data("log");
            var status = $(this).data("status");
            if (status == 0) {
                var formdata = new FormData();
                formdata.append("logId", logId);

                $.ajax({
                    url: "../backend/del.problem.php",
                    type: "POST",
                    data: formdata,
                    dataType: "json",
                    contentType: false,
                    processData: false,
                    success: function (data) {
                        if (data == 1) {
                            Swal.fire({
                                title: "แก้ไขเสร็จสิ้น",
                                showConfirmButton: false,
                                icon: "success",
                                timer: 1000
                            }).then(() => {
                                window.location.reload();
                            })
                        } else {
                            Swal.fire({
                                title: "เกิดข้อผิกพลาด",
                                showConfirmButton: false,
                                icon: "error",
                                timer: 1000
                            })
                        }
                    }
                })
            } else {
                Swal.fire({
                    title: "ไม่สามารถยกเลิกได้",
                    text: "ช่างได้ทำการรับงานไปแล้ว",
                    showConfirmButton: false,
                    icon: "error",
                    timer: 1000
                })
            }
        });



    </script>
<?php }
if ($page == "repair") {
    $sqlRepair = "SELECT * FROM log WHERE status='0'";
    $qRepair = $conn->query($sqlRepair);
    ?>
    <table class="table pt-2 w-100 " id="tableProblem">
        <thead>
            <tr>
                <th scope="col" style="width:98px">รายการ</th>
                <th scope="col" style="width:98px">ห้อง</th>
                <th scope="col" style="width:98px">สถานะ</th>
                <th scope="col" style="width:98px">เวลา</th>
                <th scope="col" style="width:98px"></th>
                <th scope="col" style="width:98px"></th>
            </tr>
        </thead>
        <tbody>

            <?php while ($data = $qRepair->fetch_object()) {
                if ($data->type == "true") {
                    $type = "<span class='text-danger'>ด่วน</span>";
                } else {
                    $type = "<span class='text-success'>ไม่ด่วน</span>";
                }
                ?>
                <tr>
                    <td style="width:98px">
                        <?php echo $data->item; ?>
                    </td>

                    <td style="width:98px">
                        <?php echo $data->room; ?>
                    </td>
                    <td style="width:98px">
                        <?php echo $type; ?>
                    </td>
                    <td style="width:98px">
                        <?php echo $data->date ?>
                    </td>
                    <td style="width:98px"><button class="btn btn-warning" id="descProblem"
                            data-log="<?php echo $data->id; ?>">รายละเอียด</button></td>
                    <td style="width:98px"><button class="btn btn-success" id="btnSubmitProblem"
                            data-log="<?php echo $data->id; ?>">รับงาน</button></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <script>
        let table = new DataTable('#tableProblem');

        $(document).on("click", "#descProblem", function () {
            var logId = $(this).data("log");
            var formdata = new FormData();
            formdata.append("logId", logId);

            $.ajax({
                url: "desc.problem.php",
                type: "POST",
                data: formdata,
                dataType: "html",
                contentType: false,
                processData: false,
                success: function (data) {
                    Swal.fire({
                        showConfirmButton: false,
                        html: data,
                        title: "รายละเอียด"
                    })
                }
            })
        })

        $(document).on("click", "#btnSubmitProblem", function () {
            Swal.fire({
                title: "ยืนยันรับงาน",
                text: "รับงานหรือไม่",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "ยืนยัน",
                cancelButtonText: "ยกเลิก",
                html: "<label>วันที่เข้าซ่อม</label><input type='datetime-local' id='startDate' class=' my-2 form-control'>"+
                "<label>วันที่ซ่อมเสร็จ</label><input type='datetime-local' id='endDate' class='form-control'>"
            }).then((result) => {
                if (result.isConfirmed) {
                    var startDate = $('#startDate').val()
                    var endDate = $('#endDate').val()
                    if (startDate === "" || endDate === "") {
                        Swal.fire({
                            title:'โปรดเลือกวันที่เริ่มซ่อมและวันทีสิ้นสุด',
                            showConfirmButton:false,
                            timer:900,
                            icon:"error"
                        })
                    } else {
                        var logId = $(this).data("log")
                        var formdata = new FormData();
                        formdata.append("logId", logId)
                        formdata.append("startDate", startDate)
                        formdata.append("endDate", endDate)
                        $.ajax({
                            url: "../backend/update.problem.php",
                            type: "POST",
                            data: formdata,
                            dataType: false,
                            contentType: false,
                            processData: false,
                            success: function (data) {
                                if (data == 1) {
                                    Swal.fire({
                                        title: "รับงานเสร็จสิ้น",
                                        icon: "success",
                                        showConfirmButton: false,
                                        timer: 900
                                    }).then(() => {
                                        window.location.reload();
                                    })
                                } else {
                                    Swal.fire({
                                        title: "เกิดข้อผิดพลาด",
                                        icon: "error",
                                        showConfirmButton: false,
                                        timer: 900
                                    })
                                }
                            }
                        })
                    }

                }
            });

        })
    </script>





<?php }
if ($page == "problemrepair") {
    $sqlRepair = "SELECT * FROM log WHERE status='1' AND staff = '$user->id'";
    $qRepair = $conn->query($sqlRepair);
    ?>
    <table class="table w-100 " id="tableProblem">
        <thead>
            <tr>
                <th scope="col" style="width:98px">รายการ</th>
                <th scope="col" style="width:98px">ห้อง</th>
                <th scope="col" style="width:98px">สถานะ</th>
                <th scope="col" style="width:98px">เวลา</th>
                <th scope="col" style="width:98px"></th>
                <th scope="col" style="width:98px"></th>
        </thead>
        <tbody>
            <?php while ($data = $qRepair->fetch_object()) {
                if ($data->type == "true") {
                    $type = "<span class='text-danger'>ด่วน</span>";
                } else {
                    $type = "<span class='text-success'>ไม่ด่วน</span>";
                }
                ?>
                <tr>
                    <td style="width:88px">
                        <?php echo $data->item; ?>
                    </td>
                    <td style="width:98px">
                        <?php echo $data->room; ?>
                    </td>
                    <td style="width:78px">
                        <?php echo $type; ?>
                    </td>
                    <td style="width:78px">
                        <?php echo $data->date ?>
                    </td>
                    <td style="width:98px"><button class="btn btn-warning" id="descProblem"
                            data-log="<?php echo $data->id; ?>">รายละเอียด</button></td>
                    <td style="width:98px"><button class="btn btn-success" id="successProblem"
                            data-log="<?php echo $data->id; ?>">ซ่อมเสร็จสิ้น</button></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <script>
        let table = new DataTable('#tableProblem');

        $(document).on("click", "#successProblem", function () {
            Swal.fire({
                title: "ทำการซ่อมเสร็จสิ้น",
                text: "ยืนยันการซ่อมเสร็จสิ้น",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "ยืนยัน",
                cancelButtonText: "ยกเลิก"
            }).then((result) => {
                if (result.isConfirmed) {
                    var logId = $(this).data("log");
                    console.log(logId);
                    var formdata = new FormData();
                    formdata.append("logId", logId);

                    $.ajax({
                        url: "../backend/success.problem.php",
                        type: "POST",
                        data: formdata,
                        dataType: "json",
                        contentType: false,
                        processData: false,
                        success: function (data) {
                            console.log(data)
                            if (data == 1) {
                                Swal.fire({
                                    title: "อัพเดตงานเสร็จสิ้น",
                                    icon: "success",
                                    showConfirmButton: false,
                                    timer: 1000
                                }).then(() => {
                                    window.location.reload();
                                })
                            } else {
                                Swal.fire({
                                    title: "เกิดข้อผิดพลาด",
                                    icon: "error",
                                    showConfirmButton: false,
                                    timer: 1000
                                })
                            }
                        }
                    })
                }
            });

        })

        $(document).on("click", "#descProblem", function () {
            var logId = $(this).data("log");
            var formdata = new FormData();
            formdata.append("logId", logId);

            $.ajax({
                url: "desc.problem.php",
                type: "POST",
                data: formdata,
                dataType: "html",
                contentType: false,
                processData: false,
                success: function (data) {
                    Swal.fire({
                        showConfirmButton: false,
                        html: data,
                        title: "รายละเอียด"
                    })
                }
            })
        })
    </script>

<?php }
if ($page == "historyrepair") {
    $sqlRepair = "SELECT * FROM log WHERE status='2' AND staff = '$user->id'";
    $qRepair = $conn->query($sqlRepair);
    ?>
    <table class="table w-100 " id="tableProblem">
        <thead>
            <tr>
                <th scope="col" style="width:98px">รายการ</th>
                <th scope="col" style="width:98px">ห้อง</th>
                <th scope="col" style="width:98px">สถานะ</th>
                <th scope="col" style="width:98px">เวลา</th>
                <th scope="col" style="width:98px"></th>
        </thead>
        <tbody>
            <?php while ($data = $qRepair->fetch_object()) {
                if ($data->type == "true") {
                    $type = "<span class='text-danger'>ด่วน</span>";
                } else {
                    $type = "<span class='text-success'>ไม่ด่วน</span>";
                }
                ?>
                <tr>
                    <td style="width:88px">
                        <?php echo $data->item; ?>
                    </td>
                    <td style="width:98px">
                        <?php echo $data->room; ?>
                    </td>
                    <td style="width:78px">
                        <?php echo $type; ?>
                    </td>
                    <td style="width:78px">
                        <?php echo $data->date; ?>
                    </td>
                    <td style="width:98px"><button class="btn btn-warning" id="descProblem"
                            data-log="<?php echo $data->id; ?>">รายละเอียด</button></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    <script>
        let table = new DataTable('#tableProblem');

        $(document).on("click", "#descProblem", function () {
            var logId = $(this).data("log");
            var formdata = new FormData();
            formdata.append("logId", logId);

            $.ajax({
                url: "desc.problem.php",
                type: "POST",
                data: formdata,
                dataType: "html",
                contentType: false,
                processData: false,
                success: function (data) {
                    Swal.fire({
                        showConfirmButton: false,
                        html: data,
                        title: "รายละเอียด"
                    })
                }
            })
        })
    </script>

<?php }
if ($page == "showAdmin") {
    $sqlRepair = "SELECT * FROM log WHERE status='0'";
    $qRepair = $conn->query($sqlRepair);
    ?>
    <table class="table w-100 " id="tableProblem">
        <thead>
            <tr>
                <th scope="col" style="width:98px">รายการ</th>
                <th scope="col" style="width:98px">ห้อง</th>
                <th scope="col" style="width:98px">สถานะ</th>
                <th scope="col">เวลา</th>
                <th scope="col" style="width:98px"></th>
        </thead>
        <tbody>
            <?php while ($data = $qRepair->fetch_object()) {
                if ($data->type == "true") {
                    $type = "<span class='text-danger'>ด่วน</span>";
                } else {
                    $type = "<span class='text-success'>ไม่ด่วน</span>";
                }
                ?>
                <tr>
                    <td style="width:88px">
                        <?php echo $data->item; ?>
                    </td>
                    <td style="width:98px">
                        <?php echo $data->room; ?>
                    </td>
                    <td style="width:78px">
                        <?php echo $type; ?>
                    </td>
                    <td style="width:98px">
                        <?php echo $data->date; ?>
                    </td>
                    <td style="width:98px"><button class="btn btn-warning" id="descProblem"
                            data-log="<?php echo $data->id; ?>">รายละเอียด</button></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <script>
        let table = new DataTable('#tableProblem');

        $(document).on("click", "#descProblem", function () {
            var logId = $(this).data("log");
            var formdata = new FormData();
            formdata.append("logId", logId);

            $.ajax({
                url: "desc.problem.php",
                type: "POST",
                data: formdata,
                dataType: "html",
                contentType: false,
                processData: false,
                success: function (data) {
                    Swal.fire({
                        showConfirmButton: false,
                        html: data,
                        title: "รายละเอียด"
                    })
                }
            })
        })
    </script>

<?php }
if ($page == "processAdmin") {
    $sqlRepair = "SELECT * FROM log WHERE status='1'";
    $qRepair = $conn->query($sqlRepair);
    ?>
    <table class="table w-100 " id="tableProblem">
        <thead>
            <tr>
                <th scope="col" style="width:98px">รายการ</th>
                <th scope="col" style="width:98px">ห้อง</th>
                <th scope="col" style="width:98px">สถานะ</th>
                <th scope="col">เวลา</th>
                <th scope="col" style="width:98px"></th>
        </thead>
        <tbody>
            <?php while ($data = $qRepair->fetch_object()) {
                if ($data->type == "true") {
                    $type = "<span class='text-danger'>ด่วน</span>";
                } else {
                    $type = "<span class='text-success'>ไม่ด่วน</span>";
                }
                ?>
                <tr>
                    <td style="width:88px">
                        <?php echo $data->item; ?>
                    </td>
                    <td style="width:98px">
                        <?php echo $data->room; ?>
                    </td>
                    <td style="width:78px">
                        <?php echo $type; ?>
                    </td>
                    <td style="width:98px">
                        <?php echo $data->date; ?>
                    </td>
                    <td style="width:98px"><button class="btn btn-warning" id="descProblem"
                            data-log="<?php echo $data->id; ?>">รายละเอียด</button></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <script>
        let table = new DataTable('#tableProblem');

        $(document).on("click", "#descProblem", function () {
            var logId = $(this).data("log");
            var formdata = new FormData();
            formdata.append("logId", logId);

            $.ajax({
                url: "desc.problem.php",
                type: "POST",
                data: formdata,
                dataType: "html",
                contentType: false,
                processData: false,
                success: function (data) {
                    Swal.fire({
                        showConfirmButton: false,
                        html: data,
                        title: "รายละเอียด"
                    })
                }
            })
        })
    </script>


<?php }
if ($page == "successAdmin") {
    $sqlRepair = "SELECT * FROM log WHERE status='2'";
    $qRepair = $conn->query($sqlRepair);
    ?>
    <table class="table w-100 " id="tableProblem">
        <thead>
            <tr>
                <th scope="col" style="width:98px">รายการ</th>
                <th scope="col" style="width:98px">ห้อง</th>
                <th scope="col" style="width:98px">สถานะ</th>
                <th scope="col">เวลา</th>
                <th scope="col" style="width:98px"></th>
        </thead>
        <tbody>
            <?php while ($data = $qRepair->fetch_object()) {
                if ($data->type == "true") {
                    $type = "<span class='text-danger'>ด่วน</span>";
                } else {
                    $type = "<span class='text-success'>ไม่ด่วน</span>";
                }
                ?>
                <tr>
                    <td style="width:88px">
                        <?php echo $data->item; ?>
                    </td>
                    <td style="width:98px">
                        <?php echo $data->room; ?>
                    </td>
                    <td style="width:78px">
                        <?php echo $type; ?>
                    </td>
                    <td style="width:98px">
                        <?php echo $data->date; ?>
                    </td>
                    <td style="width:98px"><button class="btn btn-warning" id="descProblem"
                            data-log="<?php echo $data->id; ?>">รายละเอียด</button></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <script>
        let table = new DataTable('#tableProblem');

        $(document).on("click", "#descProblem", function () {
            var logId = $(this).data("log");
            var formdata = new FormData();
            formdata.append("logId", logId);

            $.ajax({
                url: "desc.problem.php",
                type: "POST",
                data: formdata,
                dataType: "html",
                contentType: false,
                processData: false,
                success: function (data) {
                    Swal.fire({
                        showConfirmButton: false,
                        html: data,
                        title: "รายละเอียด"
                    })
                }
            })
        })
    </script>

<?php }
if ($page == "user") { ?>
    <div class="card shadow">
        <div class="card-body">
            <button class="btn btn-warning mt-2 form-control" id="insertUser">เพิ่มผู้ใข้งาน</button>
            <hr>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">ชื่อ</th>
                        <th scope="col">tel</th>
                        <th scope="col">status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sqlUser = "SELECT * FROM member ";
                    $qUser = $conn->query($sqlUser);
                    $dataUser = $qUser->fetch_object();
                    $i = 1;
                    while ($dataUser = $qUser->fetch_object()) {
                        if ($dataUser->status == "9") {
                            $status = "ผู้ดูแลระบบ";
                        } else if ($dataUser->status == "5") {
                            $status = "ช่าง";
                        } else {
                            $status = "ผู้ใช้งาน";
                        }
                        ?>
                        <tr>
                            <td>
                                <?php echo $i; ?>
                            </td>
                            <td>
                                <?php echo $dataUser->name ?>
                            </td>
                            <td>
                                <?php echo $dataUser->tel ?>
                            </td>
                            <td>
                                <?php echo $status; ?>
                            </td>
                            <td><button class="btn btn-primary" id="btnDesc"
                                    data-id="<?php echo $dataUser->id; ?>">รายละเอียด</button></td>
                        </tr>
                        <?php $i++;
                    } ?>
                </tbody>
            </table>
        </div>
    </div>


    <script>

        $(document).on("click", "#btnUpdateUser", function () {
            var userId = $(this).data("id");
            var name = $('#name').val();
            var email = $('#email').val();
            var password = $('#password').val();
            var tel = $('#tel').val();
            var formdata = new FormData();
            formdata.append("name", name);
            formdata.append("email", email);
            formdata.append("password", password);
            formdata.append("tel", tel);
            formdata.append("userId", userId);

            $.ajax({
                url: "../backend/update.user.php",
                type: "POST",
                data: formdata,
                dataType: "json",
                contentType: false,
                processData: false,
                success: function (data) {
                    if (data == 1) {
                        Swal.fire({
                            title: "แก้ไขผู้ใข้เสร็ตสิ้น",
                            showConfirmButton: false,
                            timer: 1000,
                            icon: "success"
                        }).then(() => {
                            window.location.reload();
                        })
                    } else {
                        Swal.fire({
                            title: "เกิดข้อผิดพลาด",
                            showConfirmButton: false,
                            timer: 1000,
                            icon: "error"
                        })
                    }
                }
            })

        })

        $(document).on("click", "#btnInsertUser", function () {
            var name = $('#name').val();
            var password = $('#password').val();
            var tel = $('#tel').val();
            var status = $('#status').val();
            var formdata = new FormData();
            formdata.append("name", name);
            formdata.append("password", password);
            formdata.append("tel", tel);
            formdata.append("status", status);

            $.ajax({
                url: "../backend/insert.user.php",
                type: "POST",
                data: formdata,
                dataType: "json",
                contentType: false,
                processData: false,
                success: function (data) {
                    if (data == 1) {
                        Swal.fire({
                            title: "เพิ่มผู้ใข้เสร็ตสิ้น",
                            showConfirmButton: false,
                            timer: 1000,
                            icon: "success"
                        }).then(() => {
                            window.location.reload();
                        })
                    } else {
                        Swal.fire({
                            title: "เกิดข้อผิดพลาด",
                            showConfirmButton: false,
                            timer: 1000,
                            icon: "error"
                        })
                    }
                }
            })
        })

        $(document).on("click", ".chgsta", function () {
            var status = $(this).data("status");
            var userId = $(this).data("id");
            var formdata = new FormData();
            formdata.append("status", status);
            formdata.append("userId", userId);

            $.ajax({
                url: "../backend/update.status.php",
                type: "POST",
                data: formdata,
                dataType: "json",
                contentType: false,
                processData: false,
                success: function (data) {
                    if (data == 1) {
                        Swal.fire({
                            title: "แก้ไขเสร็จสิ้น",
                            showConfirmButton: false,
                            timer: 1000,
                            icon: "success"
                        }).then(() => {
                            window.location.reload();
                        })
                    } else {
                        Swal.fire({
                            title: "เกิดขเ้อผิดพลาด",
                            showConfirmButton: false,
                            timer: 1000,
                            icon: "error"
                        })
                    }
                }
            })
        })

        $(document).on("click", "#insertUser", function () {
            $.ajax({
                url: "insert.page.php",
                dataType: "html",
                contentType: false,
                processData: false,
                success: function (data) {
                    Swal.fire({
                        html: data,
                        showConfirmButton: false,
                        title: "เพิ่มผู้ใช้งาน",
                    })
                }
            })
        })

        $(document).on("click", "#btnDesc", function () {
            var userId = $(this).data("id");
            var formdata = new FormData();
            formdata.append("userId", userId);

            $.ajax({
                url: "desc.user.php",
                type: "POST",
                data: formdata,
                dataType: "html",
                contentType: false,
                processData: false,
                success: function (data) {
                    Swal.fire({
                        title: "รายละเอียด",
                        html: data,
                        showConfirmButton: false,
                    })
                }
            })
        })
    </script>
<? }
?>