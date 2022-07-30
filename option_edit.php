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
    <link rel="stylesheet" href="style-option.css">
    <link rel="stylesheet" href="style_thongbao.css">
    <script src="jsbaocao.js" defer></script>
    <script src="js_ktTen.js" defer></script>
    <title>Sửa thông tin độc giả</title>
</head>
<body>
    <div class="option">    
        <div class="header">
            <ul class="container-main">
                    <li class="select">
                        <a href="index-home.php">
                            <i class="fas fa-home"></i>
                            Trang chủ
                        </a>
                    </li>
                    <li class="select"><a href="lapthedocgia.php" class="register">Quản lí độc giả</a></li>
                    <li class="select"><a href="tiepnhansachmoi.php" class="newbooks">Quản lí sách</a></li>
                    <li class="select"><a href="tracuusach.php" class="tracuusach">Tra cứu sách</a></li>
                    <li class="select"><a href="sachmuon.php">Mượn sách</a></li>
                    <li class="select"><a href="trasach.php">Trả sách</a></li>
                    <li class="select"><a href="phieuthutienphat.php">Phiếu thu tiền phạt</a></li>
                    <li class="select">
                        <a class="jsdownBC">Lập báo cáo <i class="fas fa-caret-down"></i></a> 
                        <ul class="downBC action">
                            <li><a href="BCMStheloai.php">Mượn sách theo thể loại</a></li>
                            <li><a href="BCsachtratre.php">Sách trả trễ</a></li>
                        </ul>
                    </li>
                    <li class="select">
                        <a href="option.php">
                            Cài đặt
                        </a>
                    </li>
            </ul>
        </div>
    </div>
    <div class="lapthedocgia divContent main">
    <?php
    require('dbconnect.php');
    $madg = $_GET['GetID'];

    $sql="SELECT TenDangNhap,MatKhau,docgia.MaNguoiDung from docgia inner join nguoidung on docgia.MaNguoiDung=nguoidung.MaNguoiDung where MaDocGia='$madg'";
    if(!$result=$mysqli->query($sql)) echo 'Loi1: '.$mysqli->error;
    $row=$result->fetch_assoc();
    $tendangnhap=$row["TenDangNhap"];
    $matkhau=$row["MatKhau"];
    $manguoidung=$row["MaNguoiDung"];

    

    ?>
                <div class="thongtintaikhoan">
                    <h2>Thông tin tài khoản</h2>
                    <div class="container">
                        <form class="suathongtin" enctype="multipart/form-data" method="POST">
                            <div>
                                Tên đăng nhập:   <br>
                                Mật khẩu: 
                            
                            </div>
                            <div>
                                <input type="hidden" name="mangdung" value="<?php echo $manguoidung?>">
                                <input type="hidden" name="madocgia" value="<?php echo $madg ;?>">
                                <input readonly class="kdcsua" type="text" name="tendn" value="<?php echo $tendangnhap;?>"> <br>
                                <input type="text" name="matkhau" value="<?php echo $matkhau;?>">
                            </div>
                            <div>
                                <br>
                                <button type="submit" name="suaTTTK">Lưu thay đổi</button>
                            </div>
                        </form>
                    </div>
                </div>
        <?php
            if(isset($_POST['suaTTTK'])){
                $manguoidung = $_POST['mangdung'];
                $matkhaumoi = $_POST['matkhau'];
                $madocgia = $_POST['madocgia'];
                $sql="UPDATE nguoidung SET MatKhau='$matkhaumoi' where MaNguoiDung='$manguoidung'"; 
                if(!$mysqli->query($sql)) echo 'Loi2: '.$mysqli->error;
                ?>
                <div style="z-index: 100;" class="divTBTKadmin  thongbaoDoiTTTKTC">
                    <div class="thongbaosachmoi">
                        <div class="TBthemmoi divktimthay">
                            <div class="TBcontent theDGcontent">
                                <a href="option_edit.php?GetID=<?php echo $madocgia; ?>"><i class="fas fa-times"></i></a>
                                <h2>Đã thay đổi thông tin tài khoản!</h2>
                                    <div class="btn">
                                        <button><a href="option_edit.php?GetID=<?php echo $madocgia; ?>">OK</a></button>
                                    </div>
                            </div>
                        </div>
                    </div>
                </div> 
                <?php
            }
        $mysqli->close();
        ?>

        <div class="navbar">

            <h2>Sửa thông tin thẻ độc giả</h2>

            <form class="formMain" enctype="multipart/form-data" method="POST">
    
                <div class="container">
                        <div id="themdocgia">
                            <?php
                            $conn = mysqli_connect('localhost', 'root', '', 'quanlythuvien') or die ('fail');
                            if(mysqli_connect_errno()){
                                echo "failed to connect to Mysql: ".mysqli_connect_error();
                                exit();
                            }
                            $madg = $_GET['GetID'];

                            if(isset($_POST['suaTTDGTC'])){
                                $madg=$_POST['madocgia'];
                            }
                            $sql = "SELECT * FROM `docgia` WHERE MaDocGia='$madg'";
                            $res = mysqli_query($conn, $sql);
                            $row = mysqli_fetch_assoc($res);
                            $hoten = $row['HoTen'];

                            $maloaidg = $row['MaLoaiDocGia'];

                            $sql_ = "SELECT TenLoaiDocGia FROM loaidocgia WHERE MaLoaiDocGia='$maloaidg'";
                            $res_ = mysqli_query($conn, $sql_);
                            $row_ = mysqli_fetch_assoc($res_);
                            $loaidg = $row_["TenLoaiDocGia"];

                            $ngaysinh = $row['NgaySinh'];
                            $diachi = $row['DiaChi'];
                            $email = $row['Email'];
                                
                            ?>
                            <div>
                                <div class="csssach suaTTDG">
                                    Mã độc giả:
                                    <input class="kdcsua"  readonly type="text" value="<?php echo $madg ?>" name="madg">
                                </div>
                                <div class="csssach suaTTDG">
                                    <div style="line-height: 1;">
                                        Họ Tên:
                                        <p style="font-size: 13px; color:red;" id="thongbao"></p>
                                    </div>
                                    <input id="message" onkeyup="show_result()"  type="text" value="<?php echo $hoten ?>" name="username">
                                </div>
                                <div class="csssach suaTTDG">
                                    Loại độc giả:
                                    <select class="selectKindReader" name="kindReader" id="kindReader" value = "selected" required>
                                        <option value="<?php echo $maloaidg;?>"><?php echo $loaidg;?></option>
                                    <?php
                                        $conn = mysqli_connect('localhost', 'root','', 'quanlythuvien')   or die ('fail');
            
                                        $sql = "SELECT * FROM `loaidocgia` WHERE DaXoa=0";
                                        $result = mysqli_query($conn, $sql);
                                        if (mysqli_num_rows($result) > 0){
                                            while ($row = mysqli_fetch_assoc($result)){
                                                ?>
                                                    <option value="<?php echo $row['MaLoaiDocGia'] ?>">
                                                        <?php echo $row['TenLoaiDocGia'] ?>
                                                
                                                </option>
                                                <?php
                                            }
                                        }
                                        mysqli_close($conn);
                                    ?>
                                    </select>
                                </div>
                            </div>
                            <div>
                                <div class="csssach suaTTDG" style="height: 50px;">
                                    Ngày sinh:
                                    <?php
                                        $conn = mysqli_connect('localhost', 'root','', 'quanlythuvien')   or die ('fail');
                                        $today = date("d/m/Y");
                                        
                                        $tuoitoithieu="SELECT GiaTri FROM thamso WHERE TenThamSo='TuoiToiThieu'";
                                        $result1 = mysqli_query($conn, $tuoitoithieu);
                                        $row1 = mysqli_fetch_assoc($result1);
                                        $tuoitoithieu = $row1['GiaTri'];
                                        
                                        $tuoitoida="SELECT GiaTri FROM thamso WHERE TenThamSo='TuoiToiDa'";
                                        $result2 = mysqli_query($conn, $tuoitoida);
                                        $row2 = mysqli_fetch_assoc($result2);
                                        $tuoitoida = $row2['GiaTri'];
                                        
                                        $y = date("Y");
                                        $min = $y - $tuoitoida;
                                        $max = $y - $tuoitoithieu;
                                        
                                        ?>
                                    <input type="date" value ="<?php echo $ngaysinh ?>" name="birthday" style="height: 40px; margin:6px 0 6px 10px;" max="<?php echo $max;?>-12-31" min="<?php echo $min?>-01-01"  >

                                </div>
                            </div>
                        </div>
                </div>
                   
    
                    Địa chỉ: <br>
                    <input class="diachi" type="text" value ="<?php echo $diachi ?>" name="address"> <br>
                    Email: <br>
                    <input type="email" value ="<?php echo $email ?>" name="email"> <br>
                    <div class="btn btnsuaTTDG">
                        <button><a href="lapthedocgia.php">Quay lại</a></button>
                        <button name="adminsuaTTDG" type="submit">Lưu thay đổi</button>
                    </div>
                <?php
                    mysqli_close($conn);
                ?>
            </form>
        </div>
    </div>
    <?php
    $conn = mysqli_connect('localhost', 'root', '', 'quanlythuvien') or die ('fail');
    if(mysqli_connect_errno()){
        echo "failed to connect to Mysql: ".mysqli_connect_error();
        exit();
    }
    if ( isset($_POST['adminsuaTTDG']) ){
        $hoten = $_POST["username"];
        $maloaidocgia = $_POST["kindReader"];
        $ngaysinh = $_POST["birthday"];
        $diachi = $_POST["address"];
        $email = $_POST["email"];

        $madocgia = $_POST["madg"];

        $sql_ = "UPDATE docgia SET 
                    MaLoaiDocGia='$maloaidocgia', HoTen='$hoten', NgaySinh='$ngaysinh', DiaChi='$diachi', Email='$email'
                WHERE MaDocGia='$madocgia'";
        if(mysqli_query($conn, $sql_)){
            ?>
            <div class="divTBTKadmin   thongbaoDoiTTTKTC">
                    <div class="thongbaosachmoi">
                        <div class="TBthemmoi divktimthay">
                            <div class="TBcontent theDGcontent">
                                <a href="option_edit.php?GetID=<?php echo $madocgia; ?>"><i class="bitrung fas fa-times"></i></a>
                                <h2>Đã thay đổi thông tin độc giả!</h2>
                                <form enctype="multipart/form-data" method="POST" >
                                <input type="hidden" name="madocgia" value="<?php echo $madocgia;?>">
                                    <div class="btn">
                                        <button type="submit" name="suaTTDGTC">OK</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php
        }
    }
    mysqli_close($conn);
?>
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

