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
    <link rel="stylesheet" href="style-table.css">
    <link rel="stylesheet" href="style-option.css">
    <link rel="stylesheet" href="style_thongbao.css">
    <link rel="stylesheet" href="style-ltdg.css">
    <title>Thành Công</title>
</head>
<body>
<?php
    $conn = mysqli_connect('localhost', 'root', '', 'quanlythuvien') or die ('fail');
    if(mysqli_connect_errno()){
        echo "failed to connect to Mysql: ".mysqli_connect_error();
        exit();
    }
    if ( isset($_POST['adminsuaTTDG']) ){
        $hoten = $_POST["username"];
        $loaidocgia = $_POST["kindReader"];
        $ngaysinh = $_POST["birthday"];
        $diachi = $_POST["address"];
        $email = $_POST["email"];
        $madocgia = $_POST["madg"];

        $maloaiDG= "SELECT * FROM `loaidocgia` WHERE TenLoaiDocGia = '$loaidocgia'";
        $result = mysqli_query($conn, $maloaiDG);
        $row = mysqli_fetch_assoc($result);
        $maloaidocgia = $row['MaLoaiDocGia'];


        $sql_ = "UPDATE docgia SET 
                    MaLoaiDocGia='$maloaidocgia', HoTen='$hoten', NgaySinh='$ngaysinh', DiaChi='$diachi', Email='$email'
                WHERE MaDocGia='$madocgia'";
        if(mysqli_query($conn, $sql_)){
            ?>
            <div class="divTBTKadmin   thongbaoDoiTTTKTC">
                    <div class="thongbaosachmoi">
                        <div class="TBthemmoi divktimthay">
                            <div class="TBcontent theDGcontent">
                                <a href="index-superadmin.php"><i class="bitrung fas fa-times"></i></a>
                                <h2>Đã thay đổi thông tin độc giả!</h2>
                                <div class="btn">
                                    <a href="index-superadmin.php"><button>OK</button></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php
        }
    }
    mysqli_close($conn);
?>
</body>
</html>

