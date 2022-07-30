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
    if ( $_SERVER [ "REQUEST_METHOD" ] == "POST" ){
        $bool=0; //khong thuc hien lenh update nao
                // bool=1 khi thuc hien it nhat 1 update
        $masach = $_POST["masach"];
        $tends = $_POST["tendausach"];
        $nhaxb=$_POST["nhaxuatban"];
        $namxb=$_POST["namxuatban"];
        $sl=$_POST["tongsosach"];
        $ngaylap=$_POST["ngaynhap"];

        $matg = array ("-1", "-1", "-1", "-1", "-1");
        $tg = array ("-1", "-1", "-1", "-1", "-1");
        for($i=0; $i<5; $i++){
            $tg[$i] = $_POST["$i"];
            $temp=$i+5;
            $matg[$i] = $_POST["$temp"];
        }

        $sl_tg=0;
        for($sl_tg; $sl_tg<5; $sl_tg++){
            if($tg[$sl_tg] == "-1") break;
        }

        $tl = $_POST["theloai"];
        $trigia = $_POST["trigia"];

        $sql1 = "SELECT TenDauSach, NamXuatBan, NhaXuatBan FROM dausach INNER JOIN sach ON dausach.MaDauSach=sach.MaDauSach
                WHERE MaSach='$masach'";
        $res1 = mysqli_query($conn,$sql1);
        $row1 = mysqli_fetch_assoc($res1);
        $tendausach = $row1["TenDauSach"];
        $namxuatban=$row1["NamXuatBan"];
        $nhaxuatban=$row1["NhaXuatBan"];

        $sql2 = "SELECT TenTheLoai FROM dausach INNER JOIN theloai ON dausach.MaTheLoai=theloai.MaTheLoai
                    INNER JOIN sach ON dausach.MaDauSach=sach.MaDauSach
                    WHERE MaSach='$masach'";
        $res2 = mysqli_query($conn,$sql2);
        $row2 = mysqli_fetch_assoc($res2);
        $tentl = $row2["TenTheLoai"];

        $sql3 = "SELECT GiaTien FROM sach 
                    WHERE MaSach='$masach'";
        $res3 = mysqli_query($conn,$sql3);
        $row3 = mysqli_fetch_assoc($res3);
        $giatien = $row3["GiaTien"];

        $check = array ();
        //check = 0 khong trung
        //check = 1 trung
        for($i=0; $i<$sl_tg; $i++) $check[$i]=1; 
        for($i=0; $i<$sl_tg; $i++){
            $temp_=$matg[$i];
            $sql4 = "SELECT TenTacGia FROM tacgia
                        WHERE MaTacGia='$temp_'";
            $res4 = mysqli_query($conn,$sql4);
            $row4 = mysqli_fetch_assoc($res4);
            $tentg = $row4["TenTacGia"];

            if($tentg != $tg[$i]) $check[$i]=0;
        }

        if($tends != $tendausach && $tends != ''){
            $sql_tds = "UPDATE dausach INNER JOIN sach ON dausach.MaDauSach=sach.MaDauSach 
                        SET TenDauSach='$tends'
                        WHERE MaSach='$masach'";
            $bool=1;
            if(mysqli_query($conn, $sql_tds)){}
        }
        if($tl != $tentl && $tl != ''){
            $sql_ttl = "UPDATE theloai INNER JOIN dausach ON theloai.MaTheLoai=dausach.MaTheLoai
                        INNER JOIN sach ON dausach.MaDauSach=sach.MaDauSach
                        SET TenTheLoai='$tl'
                        WHERE MaSach='$masach'";
            $bool=1;
            if(mysqli_query($conn, $sql_ttl)){}
        }

        if($namxb != $namxuatban && $namxb != ''){
            $sql_namxb = "UPDATE sach
                        SET NamXuatBan='$namxb'
                        WHERE MaSach='$masach'";
            $bool=1;
            if(mysqli_query($conn, $sql_namxb)){}
        }
        if($nhaxb != $nhaxuatban && $nhaxb != ''){
            $sql_nhaxb = "UPDATE sach
                        SET NhaXuatBan='$nhaxb'
                        WHERE MaSach='$masach'";
            $bool=1;
            if(mysqli_query($conn, $sql_nhaxb)){}
        }

        for($i=0; $i<$sl_tg; $i++){
            if($check[$i] == 0 && $tg[$i] != ''){
                $ten_tg=$tg[$i];
                $ma_tg=$matg[$i];
                $sql_tacgia = "UPDATE tacgia 
                            SET TenTacGia='$ten_tg'
                            WHERE MaTacGia='$ma_tg'";
                $bool=1;
                if(mysqli_query($conn, $sql_tacgia)){}
            }
        }
        if($bool==1){
            ?>
            <div class="thongbaosachmoi">
                <div class="TBthemmoi">
                    <div class="TBcontent theDGcontent">
                    <h1>Thay đổi thông tin sách thành công!</h1>
                        <div class="btn">
                            <button><a href="option.php">Quay lại Khác</a></button>
                            <button><a href="index-home.php">Trở về trang chủ</a></button>
                        </div>
                     </div>
                </div>
            </div>
            <?php
        }
        else{
            ?>
            <div class="thongbaosachmoi">
                <div class="TBthemmoi">
                    <div class="TBcontent theDGcontent">
                    <h1>Giá trị thay đổi bị trùng hoặc rỗng!</h1>
                        <div class="btn">
                            <button><a href="option.php">Quay lại Khác</a></button>
                            <button><a href="index-home.php">Trở về trang chủ</a></button>
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

