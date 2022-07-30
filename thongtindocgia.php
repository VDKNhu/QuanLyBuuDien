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
    <title>Thông tin độc giả</title>
</head>
<body>
    <div class="option">    
        <div class="header">
            <ul class="container-main">
                <li class="select">
                    <a href="index-docgia.php">
                        <i class="fas fa-home"></i>
                        Trang chủ
                    </a>
                </li>
                <li class="select"><a href="tracuusach-docgia.php" class="tracuusach">Tra cứu sách</a></li>
                <li class="select backgd"><a href="thongtindocgia.php" class="thongtindocgia">Thông tin độc giả</a></li>
                <li class="select"><a href="thongtinmuontra-docgia.php" class="thongtindocgia">Thông tin mượn/trả sách</a></li>
            </ul>
        </div>
    </div>
    <h1 style="margin-top: 80px; text-align:center; font-size:50px;">Thông tin độc giả</h1>

    <?php
        $conn = mysqli_connect('localhost', 'root', '', 'quanlythuvien') or die ('fail');
        if(mysqli_connect_errno()){
            echo "failed to connect to Mysql: ".mysqli_connect_error();
            exit();
        }
        session_start();
        $madg =  $_SESSION["madocgia"];
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

        $manguoidung = $row['MaNguoiDung'];
        $sql_1="SELECT TenDangNhap, MatKhau FROM nguoidung WHERE MaNguoiDung = '$manguoidung'";
        $res_1 = mysqli_query($conn, $sql_1);
        $row_1 = mysqli_fetch_assoc($res_1);
        $tendangnhap = $row_1['TenDangNhap'];
        $matkhau=$row_1['MatKhau'];

        if(isset($_POST['suaTTTK'])){
            $matkhau = $_POST['matkhau'];
            $tendn=$_POST["tendn"];

            $sql_14="SELECT * FROM nguoidung WHERE MaNguoiDung='$manguoidung' AND TenDangNhap='$tendn' AND MatKhau='$matkhau'";
            $res_14=mysqli_query($conn,$sql_14);
            if(mysqli_num_rows($res_14)>0){
                ?>
                    <div class="thongbaosachmoi TBTDTTDN divphieuthu">
                    <div class="TBthemmoi divktimthay">
                        <div class="TBcontent theDGcontent">
                            <h2>Mật khẩu trùng với mật khẩu cũ. Vui lòng kiểm tra lại!</h2>
                            
                            <div class="btn closephieumuonsach">
                                <button id="tatTBTDTTDN">OK</button>
                            </div> 
                        </div>
                    </div>
                </div>
                <script>
                    document.getElementById("tatTBTDTTDN").addEventListener("click", function(){
                        document.querySelector(".thongbaosachmoi").classList.add("action");
                    })
                </script>
            <?php
            } else{       
            $sql_update = "UPDATE nguoidung set  MatKhau='$matkhau' where MaNguoiDung ='$manguoidung'";
            mysqli_query($conn, $sql_update);
            ?>
                <div>
                    <div class="thongbaosachmoi TBTDTTDN divphieuthu">
                        <div class="TBthemmoi divktimthay">
                            <div class="TBcontent theDGcontent">
                                <h2>Thay đổi thông tin đăng nhập thành công</h2>
                                
                                <div class="btn closephieumuonsach">
                                    <button id="tatTBTDTTDN">OK</button>
                                </div> 
                            </div>
                        </div>
                    </div>
                    <script>
                        document.getElementById("tatTBTDTTDN").addEventListener("click", function(){
                            document.querySelector(".thongbaosachmoi").classList.add("action");
                        })
                    </script>
                </div>
            <?php
        }
    }
        else{
            $matkhau = $row_1['MatKhau'];
        }
                            
        ?>
        <div class="main">
            <div class="divContent">
                <div class="thongtintaikhoan">
                    <h2>Thông tin tài khoản</h2>
                    <div class="container">
                        <div class=" thongtintk ">
                            <div>
                                Tên đang nhập:  <br>
                                Mật khẩu: 
                            </div>
                            <div>
                                <input readonly type="text" name="tendnc" value="<?php echo $tendangnhap;?>"> <br>
                                <input readonly type="text" name="matkhauc" value="<?php echo $matkhau;?>">
                            </div>
                        </div>
                        <div  class="suaTT "> 
                            <br>
                            <button id="suaTT">Sửa thông tin tài khoản</button>
                        </div>
                        <form class="suathongtin action" enctype="multipart/form-data" method="POST">
                            <div>
                                Tên đăng nhập:   <br>
                                Mật khẩu: 
                            
                            </div>
                            <div>
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
                <script>
                    document.getElementById("suaTT").addEventListener("click", function(){
                        document.querySelector(".suathongtin").classList.remove("action");
                        document.querySelector(".suaTT").classList.add("action");
                        document.querySelector(".thongtintk").classList.add("action");
                    })
                </script>
                <div class="thongtinthedocgia">  
                <?php
                    if(isset($_POST['luu'])){
                        $ngaysinh=$_POST["birthday"];
                        $diachi=$_POST["address"];
                        $email=$_POST["email"];

                        $sql_15="SELECT * FROM docgia WHERE MaDocGia='$madg' AND NgaySinh='$ngaysinh' AND DiaChi='$diachi' AND Email='$email'";
                        $res_15=mysqli_query($conn,$sql_15);
                        if(mysqli_num_rows($res_15)>0){
                            ?>
                                <div class="thongbaosachmoi TBTDTTDN divphieuthu">
                                <div class="TBthemmoi divktimthay">
                                    <div class="TBcontent theDGcontent">
                                        <h2>Thông tin thay đổi trùng với thông tin cũ. Vui lòng kiểm tra lại!</h2>
                                        
                                        <div class="btn closephieumuonsach">
                                            <button id="tatTBTDTTDN">OK</button>
                                        </div> 
                                    </div>
                                </div>
                            </div>
                            <script>
                                document.getElementById("tatTBTDTTDN").addEventListener("click", function(){
                                    document.querySelector(".thongbaosachmoi").classList.add("action");
                                })
                            </script>
                        <?php
                        }else{
                            $sql_16="UPDATE docgia SET NgaySinh='$ngaysinh', DiaChi='$diachi', Email='$email' WHERE MaDocGia='$madg'";
                            if(mysqli_query($conn,$sql_16)){
                                ?>
                                <div>
                                    <div class="thongbaosachmoi TBTDTTDN divphieuthu">
                                        <div class="TBthemmoi divktimthay">
                                            <div class="TBcontent theDGcontent">
                                                <h2>Thay đổi thông tin thành công</h2>
                                                
                                                <div class="btn closephieumuonsach">
                                                    <button id="tatTBTDTTDN">OK</button>
                                                </div> 
                                            </div>
                                        </div>
                                    </div>
                                    <script>
                                        document.getElementById("tatTBTDTTDN").addEventListener("click", function(){
                                            document.querySelector(".thongbaosachmoi").classList.add("action");
                                        })
                                    </script>
                                </div>
                            <?php

                            }
                        
                        }
                       
                    } else{
                        $sql_17="SELECT * FROM docgia WHERE MaDocGia='$madg'";
                        $res_17=mysqli_query($conn,$sql_17);
                        $row_17=mysqli_fetch_assoc($res_17);                                

                        $ngaysinh=$row_17["NgaySinh"];
                        $diachi=$row_17["DiaChi"];
                        $email=$row_17["Email"];
                    }
                ?> 
                    <h2>Thông tin thẻ độc giả</h2>
                    <?php
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
                        $ngaysinhhtml = date("d/m/Y",strtotime($ngaysinh));


                    ?>
                    <div class="container">
                    <div class=" thongtinthecu ">
                        <div class=" maDG suaTTDG">
                            Mã độc giả: <span><h3><?php echo $madg ?></h3></span>
                        </div>
                        <div class="bodyTT">
                            <div class="title">
                                Họ tên: <br>
                                Loại độc giả: <br>
                                Ngày sinh: <br>
                                Địa chỉ: <br>
                                Email: <br>
                            </div>
                            <div class="thongtin">
                                <?php echo $hoten ?> <br>
                                <?php echo $loaidg ?> <br>
                                <?php echo $ngaysinhhtml ?> <br>
                                <?php echo $diachi ?> <br>
                                <?php echo $email ?> <br>
                            </div>
                        </div>
                        <div class="btn">
                            <button id="suattdg"> Sửa thông tin độc giả</button>
                        </div>
                    </div>
                    <form class=" thongtinthemoi action" enctype="multipart/form-data" method="POST">
                        <div>
                            <div class=" maDG suaTTDG">
                                Mã độc giả: <span><h3><?php echo $madg ?></h3></span>
                            </div>
                            <div class="csssach suaTTDG">
                                Họ tên:
                                <input readonly class="kdcsua" type="text" value="<?php echo $hoten ?>" name="username">
                            </div>
                            <div class="csssach suaTTDG">
                                Loại độc giả:
                                <input  readonly class="kdcsua" type="text" name="kindReader" id="kindReader" value = "<?php echo $loaidg ?>">
                            </div>
                        </div>
                        <div class="csssach suaTTDG">
                            Ngày sinh:
                            
                            <input id="ngaysinh" type="date" value ="<?php echo $ngaysinh ?>" name="birthday" max="<?php echo $max;?>-12-31" min="<?php echo $min?>-01-01"  >

                        </div>
                    Địa chỉ: <br>
                    <input class="diachi" type="text" value ="<?php echo $diachi ?>" name="address"> <br>
                    Email: <br>
                    <input type="email" value ="<?php echo $email ?>" name="email"> <br>
                    <div class="btn">
                        <button type="submit" name="luu">Lưu thay đổi</button>
                    </div>
                    </form>
                    
                </div>
                </div>
                <script>
                        document.getElementById("suattdg").addEventListener("click", function(){
                            document.querySelector(".thongtinthecu").classList.add("action");
                            document.querySelector(".thongtinthemoi").classList.remove("action");
                        })
                </script>
            </div>
        </div>
    <?php
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