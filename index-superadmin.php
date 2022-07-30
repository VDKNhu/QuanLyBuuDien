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
    <link rel="stylesheet" href="style-superadmin.css">
    <link rel="stylesheet" href="style-ltdg.css">
    <link rel="stylesheet" href="style-table.css">
    <link rel="stylesheet" href="style-option.css">
    <link rel="stylesheet" href="style_thongbao.css">
    <script src="js-home.js" defer></script>
    <script src="js_ktTen.js" defer></script>
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
                        <a href="thongtinsuperadmin.php"><?php echo $hoten;?></a>
                    </li>
                    <li class="line">
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
    </div>
    <div class="main divposition" style="width:80vw">
        <div class="themadmin divContent">
            <h2>Thêm tài khoản Admin</h2>
            <form class="formMain" enctype="multipart/form-data" method="POST">
                <div class="divthongtin">
                    <div style="line-height: 1;">
                        Tên tài khoản:<span>*</span>
                        <p style="font-size: 13px; color:red;" id="thongbao"></p>
                    </div>
                    <input id="message" type="text" name="tentk" placeholder="Nhập tên tài khoản" onkeyup="show_result()" required>

                    Tên đăng nhập:
                    <input type="text" name="tendn" placeholder="Nhập tên đăng nhập">
                    Mật khẩu:
                    <input type="password" name="mk" placeholder="Nhập mật khẩu">
                </div>
                <div class="btn">
                    <button type="submit" name="luuTKadmin"> Lưu</button>
                </div>
            </form>

        </div>
        <div class="danhsachadmin divContent">
            <h2>Danh sách tài khoản Admin</h2>
            <table id="resultSearchBook">
                <thead>
                    <th>STT</th>
                    <th>Tên tài khoản</th>
                    <th>Tên đăng nhập</th>
                    <th>Mật khẩu</th>
                    <th>Sửa</th>
                    <th>Xóa</th>
                </thead>
                    <?php

                        $sql_8="SELECT * FROM nguoidung WHERE MaNhom=2";
                        $res_8=mysqli_query($conn,$sql_8);
                        $index=1;
                        if(mysqli_num_rows($res_8)>0){
                            while($row_8=mysqli_fetch_assoc($res_8)){
                                if($row_8["DaXoa"]==0){
                                    ?>
                                    <form id="divMain" enctype="multipart/form-data" method="POST">
                                    <tbody>
                                        <input type="hidden" name="manguoidung" value="<?php echo $row_8["MaNguoiDung"] ?>">
                                        <td><?php echo $index;?></td>
                                        <td><?php echo $row_8["TenTaiKhoan"];?></td>
                                        <td><?php echo $row_8["TenDangNhap"];?></td>
                                        <td><?php echo $row_8["MatKhau"];?></td>
                                        <td><button style="background-color: inherit; color:black;" type="submit" name="suatkAdmin">Sửa</button></td>
                                        <td><button style="background-color: inherit; color:black;"  type="submit" name="xoatkAdmin">Xóa</button></td>
                                    </tbody>    
                                    </form>
                                    <?php   
                                    $index++; 
                                }
                            }   
                        }
                    ?>
            <br><h3>Danh sách gồm <?php echo $index-1; ?> tài khoản</h3> 
            </table>
        </div>
    </div>
    <?php
    require('createMS.php');
    $conn = mysqli_connect('localhost', 'root','', 'quanlythuvien')   or die ('fail');
    if(isset($_POST['suatkAdmin'])){
        $manguoidung = $_POST['manguoidung'];
        $sql_9="SELECT * FROM nguoidung WHERE MaNguoiDung=$manguoidung";
        $res_9=mysqli_query($conn, $sql_9);
        $row_9=mysqli_fetch_assoc($res_9);
        ?>

            <div class="divTBTKadmin">
                <div class="thongbaosachmoi  thongbaothaydoi">
                    <div class="TBthemmoi divktimthay">
                        <div class="TBcontent theDGcontent">
                            <a href="index-superadmin.php"><i class="tkadminTC fas fa-times"></i></a>
                            <h2>Sửa tài khoản admin</h2>
                            <form enctype="multipart/form-data" method="POST">
                                <h4>Mã tài khoản: <?php echo $row_9["MaNguoiDung"];?></h4>
                                    <input hidden type="text" name="manguoidung" value="<?php echo $row_9["MaNguoiDung"];?>"><br>
                                <div class="superadminsuaTKadmin">
                                        Tên tài khoản:
                                    <div>
                                        <input type="text" id="message1" onkeyup="show_result1()" name="tentk" value="<?php echo $row_9["TenTaiKhoan"];?>">
                                        <p style="font: 10px; color:red;" id="thongbao1"></p>
                                    </div>
                                    Tên đăng nhập:
                                    <input type="text" name="tendn" value="<?php echo $row_9["TenDangNhap"];?>"><br>
                                     Mật khẩu:
                                    <input type="text" name="mk" value="<?php echo $row_9["MatKhau"];?>"><br>
                                </div>
                                <button type="submit" name="luutkadminvuasua">Lưu thay đổi</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        <?php

    }
    if(isset($_POST['luutkadminvuasua'])){
        $manguoidung=$_POST["manguoidung"];
        $tentk=$_POST["tentk"];
        $tendn=$_POST["tendn"];
        $mk=$_POST["mk"];

        $sql_10="SELECT * FROM nguoidung WHERE MaNguoiDung='$manguoidung'";
        $res_10=mysqli_query($conn,$sql_10);
        $row_10=mysqli_fetch_assoc($res_10);
        $kt_tentk=$row_10["TenTaiKhoan"];
        $kt_tendn=$row_10["TenDangNhap"];
        $kt_mk=$row_10["MatKhau"];
        if($kt_tentk==$tentk && $kt_tendn==$tendn && $kt_mk==$mk){
            ?>
            <div class="divTBTKadmin  thongbaobitrung">
                <div class="thongbaosachmoi">
                    <div class="TBthemmoi divktimthay">
                        <div class="TBcontent theDGcontent">
                            <i class="bitrung fas fa-times"></i>
                            <h2>Thông tin bị trùng</h2>
                            
                            <div class="btn">
                                <button class="bitrung">OK</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <script>
                const bitrung = document.querySelectorAll(".bitrung");
                for(let i = 0; i < bitrung.length; i++){
                    bitrung[i].addEventListener("click", function(){
                        document.querySelector(".thongbaobitrung").classList.add("action");
                    })
                }
            </script>
            <?php
        }else{
            $sql_11="UPDATE nguoidung 
                    SET TenTaiKhoan='$tentk', TenDangNhap='$tendn', MatKhau='$mk' 
                    WHERE MaNguoiDung='$manguoidung'";
            if(mysqli_query($conn,$sql_11)){
                ?>
                <div class="divTBTKadmin   thongbaoDoiTTTKTC">
                    <div class="thongbaosachmoi">
                        <div class="TBthemmoi divktimthay">
                            <div class="TBcontent theDGcontent">
                                <a href="index-superadmin.php"><i class="bitrung fas fa-times"></i></a>
                                <h2>Thay đổi thông tin thành công</h2>
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

    }
    if(isset($_POST['xoatkAdmin'])){
        ?>
                <div class="divTBTKadmin   thongbaoDoiTTTKTC">
                    <div class="thongbaosachmoi">
                        <div class="TBthemmoi divktimthay">
                            <div class="TBcontent theDGcontent">
                                <a href="index-superadmin.php"><i class="bitrung fas fa-times"></i></a>
                                <h2>Bạn chắc chắn muốn xóa tài khoản này?</h2>
                                <form enctype="multipart/form-data" method="POST" >
                                    <input type="hidden" name="manguoidung" value="<?php echo $_POST['manguoidung'];?>">
                                    <div class="btn">
                                        <button type="submit" name="xacnhanxoaadmin">OK</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php
    }
    if(isset($_POST['xacnhanxoaadmin'])){
        $manguoidung = $_POST['manguoidung'];
        $sql_9="UPDATE nguoidung SET DaXoa=1 WHERE MaNguoiDung=$manguoidung";
        if(mysqli_query($conn,$sql_9)){
            ?>
                <div class="divTBTKadmin   thongbaoDoiTTTKTC">
                    <div class="thongbaosachmoi">
                        <div class="TBthemmoi divktimthay">
                            <div class="TBcontent theDGcontent">
                                <a href="index-superadmin.php"><i class="bitrung fas fa-times"></i></a>
                                <h2>Đã xóa tài khoản Admin!</h2>
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
    if (isset($_POST['luuTKadmin'])){
        $tentk=$_POST["tentk"];
        $tendn=$_POST["tendn"];
        $mk=$_POST["mk"];
        $ma_nguoidung=0;
        $manhom=2;

        if($tendn != '' && $mk != ''){
            $sql_5="SELECT * FROM nguoidung WHERE TenTaiKhoan='$tentk' AND TenDangNhap='$tendn' AND MatKhau='$mk'";
            $res_5=mysqli_query($conn,$sql_5);
            if(mysqli_num_rows($res_5)>0){
                ?>

                    <div class="divTBTKadmin action  thongbaodkitk">
                            <div class="thongbaosachmoi">
                                <div class="TBthemmoi divktimthay" style="height: 40vh;">
                                    <div class="TBcontent theDGcontent" style="height:90%; padding-top:20px">
                                        <i class="dkitaikhoan fas fa-times"></i>
                                        <h2>Tài khoản đã tồi tại!</h2>
                                        <div class="btn" style="display: flex; justify-content: center; padding:0;">
                                            <button class="dkitaikhoan" style="width:70px; font: size 18px;" class="tenloaidocgiabitrung">OK</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                <?php
            }        
    
        }

        if($mk==''){
            $mk=12345;
        }
        if($tendn==''){
            $sql_6="SELECT MAX(MaNguoiDung) AS num FROM nguoidung";
            $res_6=mysqli_query($conn,$sql_6);
            $row_6=mysqli_fetch_assoc($res_6);
            $num=$row_6['num'];

            $tendn=vn_to_str($tentk);
            $tendn=strtolower($tendn);
            $tendn=str_replace('_','',$tendn);
            $num=$num+1;
            $tendn=$tendn.$num;
        }

        $sql_7="INSERT INTO nguoidung (MaNguoiDung, TenTaiKhoan, TenDangNhap, MatKhau, MaNhom) VALUES ('$ma_nguoidung', '$tentk', '$tendn', '$mk', '$manhom')";
        if(mysqli_query($conn, $sql_7)){
            ?>
            <div class="divTBTKadmin">
                <div class="thongbaosachmoi  thongbaothaydoi">
                    <div class="TBthemmoi divktimthay">
                            <div class="TBcontent theDGcontent">
                                <a href="index-superadmin.php"><i class="tkadminTC fas fa-times"></i></a>
                                <h2>Thêm tài khoản thành công!</h2>
                                <div class="Noidung">
                                    <p>Tên tài khoản: <?php echo $tentk;?></p>
                                    <p>Tên đăng nhập: <?php echo $tendn;?></p>
                                    <p>Mật khẩu: <?php echo $mk;?></p>
                                </div>
                                <div class="btn closephieumuonsach">
                                    <button class="tkadminTC"><a href="index-superadmin.php">OK</a></button>
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
    
    <footer>
        <h4>
            Một sản phẩm của nhóm sinh viên trường Đại học Công nghệ thông tin
            <span>
                 ©
            </span>
        </h4>
    </footer>
<script>
    const dkitk = document.querySelectorAll(".dkitaikhoan");
    for(let i = 0; i < dkitk.length; i++){
        dkitk[i].addEventListener("click", function(){
        document.querySelector(".thongbaodkitk").classList.add("action");
        });
    }
</script>
</body>
</html>

