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
    <title>Thẻ độc giả</title>
</head>
<body>
          <?php
                $ma = 0;
                $conn = mysqli_connect('localhost', 'root','', 'quanlythuvien')   or die ('fail');
                if ( $_SERVER [ "REQUEST_METHOD" ] == "POST" ){
                    $username = $_POST["username"];
                    $loaidocgia = $_POST["kindReader"];
                    $birthday = $_POST["birthday"];
                    $address = $_POST["address"];
                    $email = $_POST["email"];
                    $today = date("Y/m/d");
                    $tongno = 0;

                    $maloaiDG= "SELECT * FROM `loaidocgia` WHERE TenLoaiDocGia = '$loaidocgia'";
                    $result = mysqli_query($conn, $maloaiDG);
                    $row = mysqli_fetch_assoc($result);
                    $maloaidocgia = $row['MaLoaiDocGia'];

                    $tuoi=date("Y")-date('Y',strtotime($birthday));
                    $tuoitoithieu="SELECT GiaTri FROM thamso WHERE TenThamSo='TuoiToiThieu'";
                    $result1 = mysqli_query($conn, $tuoitoithieu);
                    $row1 = mysqli_fetch_assoc($result1);
                    $tuoitoithieu = $row1['GiaTri'];

                    $tuoitoida="SELECT GiaTri FROM thamso WHERE TenThamSo='TuoiToiDa'";
                    $result2 = mysqli_query($conn, $tuoitoida);
                    $row2 = mysqli_fetch_assoc($result2);
                    $tuoitoida = $row2['GiaTri'];

                    $sql_2 = "SELECT GiaTri FROM `thamso` WHERE TenThamSo='ThoiHanThe'";
                    $res_2 = mysqli_query($conn, $sql_2);
                    $row_2 = mysqli_fetch_assoc($res_2);
                    $thoihan = $row_2['GiaTri'];

                    $ngayhethan=$today;
                    for($i=0;$i<$thoihan;$i++){
                        $row["NgayHetHan"] = strtotime(date("Y-m-d", strtotime($ngayhethan)) . "+ 1 month");
                        $ngayhethan= date('Y-m-d', $row["NgayHetHan"]);
                    }                    

                    // $dahethan co gia tri la 0 khi the con han
                    // co gia tri la 1 khi the het han
                    $dahethan=0;

                    // $daxoa co gia tri la 0 khi the chua bi xoa
                    // co gia tri la 1 khi the da bi xoa
                    $daxoa=0;


                    if($tuoi>=$tuoitoithieu && $tuoi<=$tuoitoida){
                        ?>
                        <div class="thongbaosachmoi">
                            <div class="TBthemmoi">
                                <div class="TBcontent theDGcontent">
                                    <?php
                                    require('createMS.php');
                                    $ma_=0;
                                    $sql_1="SELECT MAX(MaDocGia) AS num FROM docgia";
                                    $res_1=mysqli_query($conn,$sql_1);
                                    $row_1=mysqli_fetch_assoc($res_1);
                                    $num=$row_1['num'];

                                    $uname= CREATEMS($username);
                                    // $num=$num+1;
                                    // $uname=$uname.$num;

                                    $password=12345;
                                    $type=3;


                                    $sql_3="INSERT INTO nguoidung (MaNguoiDung, TenTaiKhoan, TenDangNhap, MatKhau, MaNhom) VALUES ('$ma_', '$username', '$uname', '$password', '$type')";
                                    if(mysqli_query($conn,$sql_3)){}

                                    $sql_4="SELECT MaNguoiDung from nguoidung WHERE TenDangNhap='$uname'";
                                    $res_4=mysqli_query($conn,$sql_4);
                                    $row_4=mysqli_fetch_assoc($res_4);
                                    $manguoidung=$row_4['MaNguoiDung'];

                                    $sql_ = "INSERT INTO docgia (MaDocGia, HoTen, NgaySinh, DiaChi, Email, NgayLapThe, MaLoaiDocGia, TongNo, NgayHetHan, DaHetHan, DaXoa, MaNguoiDung)
                                    VALUES ('$ma', '$username', '$birthday', '$address', '$email', '$today', '$maloaidocgia', '$tongno', '$ngayhethan', '$dahethan', '$daxoa', '$manguoidung')";     
                               
                                    if(mysqli_query($conn, $sql_)){
                                        // echo 'Thẻ độc giả được lập thành công!';   
                                    ?>
                                    <h1><?php echo 'Thẻ độc giả được lập thành công!'; ?></h1>
                                    <p>Tên đăng nhập: <?php echo $uname;?></p>
                                    <p>Mật khẩu: <?php echo $password;?></p>
                                    <div class="btn">
                                        <button><a href="index-home.php">Trở về trang chủ</a></button>
                                        <button><a href="lapthedocgia.php">Lập thẻ độc giả mới</a></button>
                                    </div>
                                    <?php 
                                    }
                                ?>
                                </div>
                            </div>
                        </div>
                                <?php
                    }
                    else{
                        echo 'Lập thẻ độc giả thất bại!<br>';
                        echo "Tuổi độc giả phải từ ". $tuoitoithieu . " đến " . $tuoitoida . ". <br>";
                        ?>

                           <br><a href="lapthedocgia.php">Lập thẻ độc giả mới</a><br>
                           <a href="index-home.php">Trở về trang chủ</a><br>

                        <?php
                    }
                }
                mysqli_close($conn);
            ?>
</body>
</html>

