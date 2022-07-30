<?php
    session_start();
    $conn=mysqli_connect('localhost','root','','quanlythuvien') or die('fail');

    $manguoidung=$_SESSION["manguoidung"];
    $sql_16="SELECT * FROM nguoidung WHERE MaNguoiDung='$manguoidung'";
    $res_16=mysqli_query($conn,$sql_16);
    $row_16=mysqli_fetch_assoc($res_16);
    $hoten=$row_16["TenTaiKhoan"];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" />
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style-home.css">
    <link rel="stylesheet" href="style-ltdg.css">
    <link rel="stylesheet" href="style-table.css">
    <script src="js-home.js" defer></script>
    <script src="jsbaocao.js" defer></script>
    <title>Trang chủ</title>
</head>
<body>
    <div class="pre-header">
        <div class="container">
            <h1 class="logo">lib</h1>
            
            <div class="notify">
                <marquee>
                    <div>
                        <img src="image/welcome.gif" alt="gif_chaomung" style="height: 50px;">
                        <p>Chào mừng bạn đến với thư viện của chúng tôi</p>
                    </div>
                </marquee>
            </div>
            <div class="login">
                <ul class="menu list-inline" id="idDocGia">
                    <li class="line lineO">
                        <a href="thongtinadmin.php"><?php echo $hoten;?></a>
                    </li>
                    <li class="line lineT">
                        <a href="index-main.php">Thoát</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <h1 style="margin-top: 50px; text-align:center; font-size:50px;">Trang chủ</h1>
    <div class="header">
        <div class="view-content">
            <img class="myImage" src="image/lib1.jpg" alt="viewLib">
        </div>

        <div class="main-nav">
            <ul class="container-main">
                <li class="select backgd">
                    <a href="#">
                        <i class="fas fa-home"></i>
                        Trang chủ
                    </a>
                </li>
                <li class="select"><a href="lapthedocgia.php" class="register">Quản lí độc giả</a></li>
                <li class="select"><a href="tiepnhansachmoi.php" class="newbooks">Quản lí sách</a></li>
                <li class="select"><a href="tracuusach.php" class="tracuusach">Tra cứu sách</a></li>
                <li class="select"><a href="sachmuon.php" class="chomuonsach">Mượn sách</a></li>
                <li class="select"><a href="trasach.php">Trả sách</a></li>
                <li class="select"><a href="phieuthutienphat.php">Phiếu thu tiền phạt</a></li>
                <li class="select">
                        <a class="jsdownBC">Lập báo cáo <i class="fas fa-caret-down"></i></a> 
                    <ul class="downBC action">
                        <li><a href="BCMStheloai.php">Mượn sách theo thể loại</a></li>
                        <li><a href="BCsachtratre.php">Sách trả trễ</a></li>
                    </ul>
                </li>
                <li class="select option">
                    <a href="option.php">
                        Cài đặt
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <footer>
        <h4>
            Một sản phẩm của nhóm sinh viên trường Đại học Công nghệ thông tin
            <span>
                 ©
            </span>
        </h4>
    </footer>
    
</body>
<script>
</script>
</html>
