<?php
    session_start();
    $conn=mysqli_connect('localhost','root','','quanlythuvien') or die('fail');

    $manguoidung=$_SESSION["manguoidung"];
    $sql_16="SELECT * FROM nguoidung WHERE MaNguoiDung='$manguoidung'";
    $res_16=mysqli_query($conn,$sql_16);
    $row_16=mysqli_fetch_assoc($res_16);
    $hoten=$row_16["TenTaiKhoan"];
    $tentk=$row_16["TenTaiKhoan"];
    $tendn=$row_16["TenDangNhap"];
    $mk=$row_16["MatKhau"];

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" />
    <link rel="stylesheet" href="style-home.css">
    <link rel="stylesheet" href="style-ltdg.css">
    <link rel="stylesheet" href="style-table.css">
    <link rel="stylesheet" href="style-option.css">
    <link rel="stylesheet" href="style_thongbao.css">
    <link rel="stylesheet" href="style-login.css">
    <title>Thông tin tài khoản</title>
</head>
<body>

    <div class="divContent main" id="divMain">
        <div class="divMain">
            <div class="container">
                <?php 
                    if(isset($_POST['luu'])){
                        $tentk=$_POST["tentkc"];
                        $tendn=$_POST["tendnc"];
                        $mk=$_POST["mkc"];

                        $sql_18="SELECT * FROM nguoidung WHERE MaNguoiDung='$manguoidung' AND TenDangNhap='$tendn' AND TenTaiKhoan='$tentk' AND MatKhau='$mk'";
                        $res_18=mysqli_query($conn,$sql_18);
                        if(mysqli_num_rows($res_18)>0){
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
        
                        }
                    
                    else{
                        $sql_19="UPDATE nguoidung SET MatKhau='$mk' WHERE MaNguoiDung='$manguoidung' AND TenTaiKhoan='$tentk' AND TenDangNhap='$tendn'";
                        if(mysqli_query($conn,$sql_19)){
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
                }else{
                        $tentk=$row_16["TenTaiKhoan"];
                        $tendn=$row_16["TenDangNhap"];
                        $mk=$row_16["MatKhau"];                    
                    }
                ?>
                <div class="thongtinsuperadmin">
                    <h2>Thông tin tài khoản</h2>
                    <div>
                    Tên tài khoản: 
                    <input readonly type="text" name="tentk" value="<?php echo $tentk;?>"></input>
                    Tên đăng nhập:  
                    <input readonly type="text" name="tendn" value="<?php echo $tendn;?>"></input>
                    Mật khẩu: 
                    <input readonly type="text" name="mk" value="<?php echo $mk;?>"></input>
                    </div>
                </div>
                <div class="suathongtinsuperadmin action">
                <h2>Sửa thông tin tài khoản</h2>
                <form style="width:400px;" enctype="multipart/form-data" method="POST">
                    Tên tài khoản:
                    <input readonly class="kdcsua" type="text" name="tentkc" value="<?php echo $tentk;?>"></input>
                    Tên đăng nhập:
                    <input readonly class="kdcsua" type="text" name="tendnc" value="<?php echo $tendn;?>"></input>
                    Mật khẩu:
                    <input type="text" name="mkc" value="<?php echo $mk;?>"></input>
                </div>
                <div class="foodter" id="btnLuuTT">
                    <a href="index-superadmin.php" class="trangchu">Trang chủ</a>
                    <a href="#" class="register suaTT">Sửa thông tin</a>
                    <button style="width:150px" class="btntrangchu action"><a href="thongtinsuperadmin.php">Quay lại</a></button>
                    <button  style="width:200px" type="submit" class="btnluu action" name="luu">Lưu thông tin</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        document.querySelector(".suaTT").addEventListener("click", function(){
            document.querySelector(".suathongtinsuperadmin").classList.remove("action");
            document.querySelector(".thongtinsuperadmin").classList.add("action");
            document.querySelector(".trangchu").classList.add("action");
            document.querySelector(".btnluu").classList.remove("action");
            document.querySelector(".suaTT").classList.add("action");
            document.querySelector(".btntrangchu").classList.remove("action");
        })
    </script>
</body>
</html>