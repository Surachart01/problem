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
        <div class="d-flex justify-content-between nb pe-xs-3">
            <div class="ms-4">
                <img src="../image/logo.png" width="56px" height="56px" class="nb"  alt="">
            </div>
            <div class="navbar navbar-expand-md me-md-5 me-xs-2 py-md-3 py-xs-3 nb">
                <a class="nav-link dropdown-toggle text-light me-5" href="#" id="navbarDarkDropdownMenuLink"
                    role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <?php echo $user->name; ?>
                </a>
                <ul class="dropdown-menu dropdown-menu-light me-5">
                    <li><a class="dropdown-item" href="profile.php">โปรไฟล์</a></li>
                    <li><a class="dropdown-item" href="logout.php">ออกจากระบบ</a></li>
                </ul>
            </div>


        </div>
    </nav>

    <?php
    if ($user->status == 1) {
        ?>
        <nav class="fixed-bottom">
            <div class="row">
                <div class="col-6 py-1 border nb">
                    <a href="?page=problem" class="nav-link text-center nb" id="problem">
                        <div class="text-center nb"><i class="bi bi-gear-wide-connected nb text-light fs-4"></i></div>
                        <h5 class="text-light nb">แจ้งซ่อม</h5>
                    </a>
                </div>
                <div class="col-6 py-1 border nb">
                    <a href="?page=history" class="nav-link text-center nb" id="history">
                        <div class="text-center nb"><i class="bi bi-card-checklist nb text-light fs-4"></i></div>
                        <h5 class="text-light nb">รายการที่แจ้ง</h5>
                    </a>
                </div>
            </div>
        </nav>
    <?php } else if ($user->status == 5) { ?>
            <nav class="fixed-bottom w-100">
                <div class="row">
                    <div class="col-4 py-1 border nb">
                        <a href="?page=repair" class="nav-link text-center nb" id="problem">
                            <div class="text-center nb"><i class="bi bi-gear-wide-connected nb text-light fs-4"></i></div>
                            <h5 class="text-light nb">รายการแจ้งซ่อม</h5>
                        </a>
                    </div>
                    <div class="col-4 py-1 border nb">
                        <a href="?page=problemrepair" class="nav-link text-center nb" id="problem">
                            <div class="text-center nb"><i class="bi bi-gear-wide-connected nb text-light fs-4"></i></div>
                            <h5 class="text-light nb">รายการที่รับซ่อม</h5>
                        </a>
                    </div>
                    <div class="col-4 py-1 border nb">
                        <a href="?page=historyrepair" class="nav-link text-center nb" id="history">
                            <div class="text-center nb"><i class="bi bi-card-checklist nb text-light fs-4"></i></div>
                            <h5 class="text-light nb">รายการที่ซ่อมแล้ว</h5>
                        </a>
                    </div>
                </div>
            </nav>
    <? }
    ?>

    <div class="container-md container-sm-fluid">
        <div id="iCen">

        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script>

        $(document).ready(function () {
            showSpinner();
            var urlParams = new URLSearchParams(window.location.search);
            var page = urlParams.get('page');
            var formdata = new FormData();
            formdata.append("page", page);

            $.ajax({
                url: "page.all.php",
                type: "POST",
                data: formdata,
                dataType: "html",
                contentType: false,
                processData: false,
                success: function (data) {
                    $('#iCen').html(data);
                }
            }).then(() => {
                hideSpinner();
            })

        });

        function showSpinner() {
            $(".spinner-overlay").fadeIn();
        }

        // Function to hide the spinner
        function hideSpinner() {
            $(".spinner-overlay").fadeOut();
        }
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