<?php 
    session_start();
    $conn=mysqli_connect('localhost', 'root', '', 'quanlythuvien') or die('fail');
    $manguoidung = $_GET["GetID"];
    $sql_9="SELECT * FROM nguoidung WHERE MaNguoiDung=$manguoidung";
    $res_9=mysqli_query($conn, $sql_9);
    $row_9=mysqli_fetch_assoc($res_9);
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
    <link rel="stylesheet" href="style-superadmin.css">
    <link rel="stylesheet" href="style-ltdg.css">
    <link rel="stylesheet" href="style-table.css">
    <link rel="stylesheet" href="style-option.css">
    <script src="js-home.js" defer></script>
    <title>Trang chủ</title>
</head>
<body>
    <div class="pre-header">
        <div class="container" id="container">
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
                <ul class="menu list-inline">
                    <li class="line">
                        <!-- <a href="#">Thông tin</a> -->
                    </li>
                    <li class="line">
                        <a href="dangxuat.php?logout=true">Thoát</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="header">
        <div class="view-content">
            <img class="myImage" src="image/lib1.jpg" alt="viewLib">
        </div>
    </div>
    <div class="main divposition" style="width:80vw">
        <div class="danhsachadmin ">
            <form action="option_edit_tk_.php" method="POST">
                <h1>Mã tài khoản: <?php echo $row_9["MaNguoiDung"];?></h1>
                <input hidden type="text" name="manguoidung" value="<?php echo $row_9["MaNguoiDung"];?>"><br>
                Tên tài khoản:
                <input type="text" name="tentk" value="<?php echo $row_9["TenTaiKhoan"];?>"><br>
                Tên đăng nhập:
                <input type="text" name="tendn" value="<?php echo $row_9["TenDangNhap"];?>"><br>
                Mật khẩu:
                <input type="text" name="mk" value="<?php echo $row_9["MatKhau"];?>"><br>
                <button type="submit">Lưu thay đổi</button>
            </form>
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
</html>



