<!doctype html>
<html lang="en">

<head>
    <title>Login</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <link rel="stylesheet" href="../include/style.css">
</head>

<body>

    <div class="row mt-5">
        <div class="col-12">
            <div class="d-flex justify-content-center mt-5">
                <img src="../image/logo.png" alt="">
            </div>
            <div class="mx-5">
                <div class="login">
                    <input type="email" id="email" class="form-control input my-3" placeholder="เบอรฺ์โทร">
                    <input type="password" id="password" class="form-control input my-3" placeholder="รหัสผ่าน">
                    <button class="btn bg-dark text-light my-3 form-control" id="btnLogin">Login</button>
                </div>
            </div>
        </div>

    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>

        $(document).on("click","#btnLogin",function(){
            var email = $('#email').val();
            var password = $('#password').val();
            var formdata = new FormData();
            formdata.append("tel",email);
            formdata.append("password",password);
            $.ajax({
                url:"../backend/check.login.php",
                type:"POST",
                data:formdata,
                dataType:"json",
                contentType:false,
                processData:false,
                success:function(data){
                    if(data == 1 || data == 5){
                        Swal.fire({
                            position:"center",
                            icon:"success",
                            showConfirmButton:false,
                            timer:1000,
                            title:"Login เสร็จสิ้น"
                        }).then( () => {
                            window.location.href = "problem.php";
                        })
                    }else if(data == 9){
                        Swal.fire({
                            position:"center",
                            icon:"success",
                            showConfirmButton:false,
                            timer:1000,
                            title:"Login เสร็จสิ้น (Admin)"
                        }).then( () => {
                            window.location.href = "admin.php";
                        })
                    }else{
                        Swal.fire({
                            position:"center",
                            icon:"error",
                            showConfirmButton:false,
                            timer:1000,
                            title:"เบอร์โทร  หรือ รหัสผ่าน ไม่ถูกต้อง"
                        })
                    }
                }
            })
        })
        
    </script>


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
        crossorigin="anonymous"></script>
</body>

</html>