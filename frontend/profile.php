<?php
session_start();
if (isset($_SESSION['iUser'])) {
    $user = $_SESSION['iUser'];
} else {
    header("Location:login.php");
}
?>
<!doctype html>
<html lang="en">

<head>
    <title>Title</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <!-- Option 1: Include in HTML -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">

    <link rel="stylesheet" href="../include/style.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <!-- Jquery -->


    <style>
        body {
            background-color: #f3f0f0;
            font-family: 'Kanit', sans-serif;
            font-family: 'Lato', sans-serif;
            font-family: 'Tilt Neon', sans-serif;
        }

        .spinner-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.7);
            z-index: 9999;
        }

        .spinner {
            position: absolute;
            top: 50%;
            left: 50%;
            border: 4px solid rgba(0, 0, 0, 0.1);
            border-radius: 50%;
            border-top: 4px solid #3498db;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
            margin-top: -20px;
            margin-left: -20px;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>
</head>


<body>
    <div class="spinner-overlay">
        <div class="spinner"></div>
    </div>
    <div class="sticky-top h-xs-30 h-md-50 " style="height: 60px">

    </div>
    <nav class="fixed-top ">
        <div class="d-flex justify-content-end nb pe-xs-3">
            <div class="navbar navbar-expand-md me-md-5 me-xs-2 py-md-3 py-xs-3 nb">
                <a class="nav-link dropdown-toggle text-light me-5" href="#" id="navbarDarkDropdownMenuLink" role="button"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="../image/profile/<?php echo $user->image; ?>" width="16px" height="16px"> 
                    <?php echo $user->name; ?>
                </a>
                <ul class="dropdown-menu dropdown-menu-light me-5">
                    <li><a class="dropdown-item" href="profile.php">โปรไฟล์</a></li>
                    <li><a class="dropdown-item" href="logout.php">ออกจากระบบ</a></li>
                </ul>
            </div>


        </div>
    </nav>

    <div class="container-md container-sm-fluid">
        <div id="iCen">
        <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="card ">
              <div class="card-body my-3 mx-4">
                <h4 class="card-title text-center">แก้ไขโปรไฟล์</h4>
                <hr>
                    <div class="row">
                        <div class="col-5">
                            <div class="d-flex justify-content-center">
                                <img src="../image/profile/<?php echo $user->image ?>" class="rounded " alt="..." width="200px" height="200px">
                            </div>
                            <div class="mt-4">
                            <label for="" class="form-label">เปลีย่นรูปโปรไฟล์</label>
                            <input type="file" accept="*/image" id="image" class="form-control">
                            </div>
                        </div>
                        <div class="col-7 border-start">
                            <label for="" class="form-label">ชือ</label>
                            <input type="text" id="name" class="form-control" value="<?php echo $user->name ?>">
                            <label for="" class="form-label">เบอร์โทรศัพท์</label>
                            <input type="text" id="tel" class="form-control" value="<?php echo $user->tel ?>">
                            <label for="" class="form-label">รหัสผ่าน</label>
                            <input type="text" id="password" class="form-control" value="<?php echo $user->password ?>">

                            <button class="btn btn-success form-control mt-3" id="sub_profile"> ยืนยัน</button>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
        </div>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).on("click","#sub_profile",function(){
                var name = $('#name').val();
                var tel = $('#tel').val();
                var password = $('#password').val();

                var formdata = new FormData();
                
                formdata.append("name",name);
                formdata.append("tel",tel);
                formdata.append("password",password);

                if($('#image')[0].files.length != 0){
                    var image = $('#image')[0].files[0];
                    formdata.append("image",image);
                    formdata.append("statusImg","1");
                }else{
                    formdata.append("image","none");
                    formdata.append("statusImg","0");
                }
                $.ajax({
                    url:"../backend/change.profile.php",
                    type:"POST",
                    data:formdata,
                    dataType:"json",
                    contentType:false,
                    processData:false,
                    success:function(data){
                        console.log(data);
                        if(data == 1){
                            Swal.fire({
                                position:"top-end",
                                icon:"success",
                                title:"เสร็จสิ้น",
                                showConfirmButton:false,
                                timer:1000
                            }).then((result) => {
                                window.location.reload();
                            });
                        }else{
                            Swal.fire({
                                position:"top-end",
                                icon:"error",
                                title:"เกิดข้อผิดพลาด",
                                showConfirmButton:false,
                                timer:1000
                            });
                        }
                    }
                });
            });
    </script>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>


    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
        crossorigin="anonymous"></script>
</body>

</html>