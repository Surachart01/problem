<!doctype html>
<html lang="en">

<head>
    <title>Register</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <link rel="stylesheet" href="../include/style.css">
</head>

<body>
    <div class=" h-100">
        <div class="row h-100">
            <div class="col-md-4 d-none d-sm-block logo">
            
            </div>
            <div class="col-md-8 col-sm-12 px-5">
                <div class="d-flex justify-content-center mt-5">
                    <h2>Register</h2>
                </div>
                <div class="px-5">
                    <input type="text" class="input form-control my-3" placeholder="ชื่อ - นามสกุล" id="name">
                    <input type="text" class="input form-control my-3" placeholder="email" id="email">
                    <input type="text" class="input form-control my-3" placeholder="รหัสผ่าน" id="password" >
                    <input type="text" class="input form-control my-3" placeholder="เบอร์โทร" id="tel" >
                    <button class="btn bg-dark text-light my-3 form-control" id="btnRegister">Register</button>
                </div>
            </div>

        </div>
    </div>



    <script>
        $(document).on("click","#btnRegister",function(){
            var name = $('#name').val()
            var email = $('#email').val()
            var password = $('password').val()
            var tel = $('#tel').val()

            var formdata = new FormData()
            formdata.append("name",name)
            formdata.append("email",email)
            formdata.append("password",password)
            formdata.append("tel",tel)

            $.ajax({
                url:"../backend/check.register.php",
                type:"POST",
                data:formdata,
                dataType:"json",
                contentType:false,
                processData:false,
                success:function(data){
                    if(data == 1){
                        Swal.fire({
                            icon:"success",
                            showConfirmButton:false,
                            timer:1000,
                            title:"สมัครเสร็จสิ้น"
                        }).then( () => {
                            window.location.href = "login.php"
                        })
                    }else{
                        Swal.fire({
                            icon:"error",
                            showConfirmButton:false,
                            timer:1000,
                            title:"เกิดข้อผิดพลาด"
                        })
                    }
                }
            })
        })
    </script>


    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
        crossorigin="anonymous"></script>
</body>

</html>