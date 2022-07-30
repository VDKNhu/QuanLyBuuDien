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
    <title>Lập thẻ độc giả</title>
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
                    <li class="select backgd"><a href="lapthedocgia.php" class="register">Quản lí độc giả</a></li>
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
    <h1 style="margin-top: 80px; text-align:center; font-size:50px;">Quản lí độc giả</h1>
    <div class="lapthedocgia divContent main">
        <div class="navbar">
            <h2>Lập thẻ độc giả</h2>

            <form class="formMain" action="action.php" method="POST">
    
                <div class="container">
                    <div id="themdocgia">
                        <div>
                            <div class="csssach">
                                <div style="line-height: 1;">
                                    Họ tên:<span>*</span>
                                    <p style="font-size: 13px; color:red;" id="thongbao"></p>
                                </div>
                                <input id="message" onkeyup="show_result()"  type="text" placeholder="Nhập họ tên" name="username" required>
                            </div>
                            <div class="csssach">
                                <div>Loại độc giả <span>*</span>:</div>
                                <select class="selectKindReader" name="kindReader" id="kindReader" required>
                                    <option value="">-Chọn-</option>
                                <?php
                                    $conn = mysqli_connect('localhost', 'root','', 'quanlythuvien')   or die ('fail');
        
                                    $sql = "SELECT * FROM `loaidocgia` WHERE DaXoa=0";
                                    $result = mysqli_query($conn, $sql);
                                    if (mysqli_num_rows($result) > 0){
                                        while ($row = mysqli_fetch_assoc($result)){
                                            ?>
                                                <option value="<?php echo $row['TenLoaiDocGia'] ?>">
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
                        <div class="csssach">
                            <div>Ngày sinh <span>*</span>:</div>
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
                                 <input style="margin-bottom: 0 ;" type="date" placeholder="Nhập ngày sinh" name="birthday" max="<?php echo $max;?>-12-31" min="<?php echo $min?>-01-01" required>
                            <?php
                                mysqli_close($conn);
                            ?>
                        </div>
                    </div>
                   
    
                    Địa chỉ: <br>
                    <input class="diachi" type="text" placeholder="Nhập địa chỉ" name="address"> <br>
                    Email: <br>
                    <input type="email" placeholder="Nhập Email" name="email"> <br>
                    <div class="btn">
                        <button type="submit">Lưu</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="main theloaidocgia">
        <div class="danhsachtheloaidocgia divContent">
            <div class="navbar">
                <h2>Danh sách loại độc giả</h2>
                <div class="formMain">
                    <table id="resultSearchBook">
                        <thead>
                            <th>STT</th>
                            <th>Mã loại độc giả</th>
                            <th>Tên loại độc giả</th>
                        </thead>
                        <tbody id="tableloaidocgia">
                            
                            <?php
                                require('dbconnect.php');
                                
                                $sql="SELECT MaLoaiDocGia,TenLoaiDocGia from loaidocgia WHERE DaXoa=0";
                                if(!$resulttl=$mysqli->query($sql)) echo 'Loixuattl: '.$mysqli->error;
                                $index = 0;
                                ?>
                                <?php
                                if($resulttl->num_rows>0){
                                    while ($kqtl=$resulttl->fetch_assoc()){
                                        $matheloai=$kqtl["MaLoaiDocGia"];
                                        $tentheloai=$kqtl["TenLoaiDocGia"];
                                        $index++;
                                        ?>
                                        <tr>
                                            <td><?php echo $index;?></td>
                                            <td><?php echo $matheloai;?></td>
                                            <td><?php echo $tentheloai;?></td>
                                        </tr>
                                        <?php
                                    }
                                }
                                ?>
                            <h4>Danh sách gồm <?php echo $index;?> loại độc giả.</h4>
                        </tbody>
                                <?php
                            ?>
                    </table>
                </div>
            </div>
        </div>
        <div class="thaydoitheloaidocgia thaydoi divContent">
            <div class="navbar">
                <h2>Chỉnh sửa loại độc giả</h2>
                <div class="formMain">
                        <form class="formthaydoi" enctype="multipart/form-data" method="POST">
                            <div>
                            <input required type="text" name="theloaisachmoi" placeholder="Nhập loại độc giả mới">
                            <br>
                            </div>
                            <div>
                                <button name="themtheloaisach" type="submit" class="them">Thêm</button>
                            </div>
                        </form>
                        <div>
                            <button id="xoaTL" class="xoa btnxoatheloai">Xóa</button>
                            <button class="sua btnsuatheloai">Sửa</button>
                        </div>
                </div>
            </div>
        </div>
        <?php
            $conn=mysqli_connect('localhost','root','','quanlythuvien') or die('fail');

            if(isset($_POST["themtheloaisach"])){
                $tenldg=$_POST["theloaisachmoi"];

                $sql_ktldg="SELECT * FROM loaidocgia WHERE TenLoaiDocGia='$tenldg' AND DaXoa=0";
                $res_ktldg=mysqli_query($conn,$sql_ktldg);
                if(mysqli_num_rows($res_ktldg)>0){
                    ?>
                    <div>
                        <div class="thongbaosachmoi TBTDTTDN divphieuthu">
                            <div class="TBthemmoi divktimthay">
                                <div class="TBcontent theDGcontent">
                                    <h2>Thông tin loại độc giả bị trùng. Vui lòng kiểm tra lại!</h2>
                                    
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
                }else{
                $maldg=0;
                $daxoa=0;
                $sql_tl="INSERT INTO loaidocgia (MaLoaiDocGia, TenLoaiDocGia, DaXoa) VALUES ('$maldg','$tenldg','$daxoa')";
                if(mysqli_query($conn,$sql_tl)){
                    ?>
                    <div>
                        <div class="thongbaosachmoi TBTDTTDN divphieuthu">
                            <div class="TBthemmoi divktimthay">
                                <div class="TBcontent theDGcontent">
                                    <h2>Thêm loại độc giả thành công!</h2>
                                    <form enctype="multipart/form-data" method="POST" >
                                        <div class="btn closephieumuonsach">
                                            <button type="submit" name="themdocgiathanhcon">OK</button>
                                        </div> 
                                    </form>
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
        }
        mysqli_close($conn);
        ?>

        <div class="divxoatheloai action ">
            <div class="thongbaosachmoi  thongbaothaydoi">
                <div class="TBthemmoi divktimthay">
                    <form enctype="multipart/form-data" method="POST">
                        <div class="TBcontent theDGcontent">
                            <i class="close fas fa-times"></i>
                            <h2>Xóa loại độc giả</h2>
                            <div class="csssach">
                                Loại độc giả:
                                <select style="width:240px" class="selectKindReader" name="kindReader" id="kindReader" value = "selected" required>
                                <?php
                                    $conn = mysqli_connect('localhost', 'root','', 'quanlythuvien')   or die ('fail');
        
                                    $sql = "SELECT * FROM `loaidocgia` WHERE DaXoa=0";
                                    $result = mysqli_query($conn, $sql);
                                    if (mysqli_num_rows($result) > 0){
                                        while ($row = mysqli_fetch_assoc($result)){
                                            ?>
                                                <option value="<?php echo $row['TenLoaiDocGia'] ?>">
                                                    <?php echo $row['TenLoaiDocGia'] ?>
                                            
                                            </option>
                                            <?php
                                        }
                                    }
                                    mysqli_close($conn);
                                ?>
                                </select>
                            </div>
                            <div class="btn closephieumuonsach">
                                <button name = "xoa" type="submit" class="xoa">Xóa</button>
                            </div> 
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <?php
            $conn = mysqli_connect('localhost', 'root','', 'quanlythuvien');
            if(isset($_POST["xoa"])){
                $tenldg = $_POST["kindReader"];

                $sql_maldg="SELECT * FROM loaidocgia WHERE TenLoaiDocGia='$tenldg'";
                $res_maldg=mysqli_query($conn,$sql_maldg);
                $row_maldg=mysqli_fetch_assoc($res_maldg);
                $maldg=$row_maldg["MaLoaiDocGia"];

                $sql_check="SELECT * FROM docgia WHERE DaXoa=0 AND MaLoaiDocGia='$maldg'";
                if($res_check=mysqli_query($conn,$sql_check)){
                    if($row_check=mysqli_num_rows($res_check)>0){
                        ?>
                        <div class="divTBTKadmin  thongbaocosachmuonquahan">
                            <div class="thongbaosachmoi">
                                <div class="TBthemmoi divktimthay">
                                    <div class="TBcontent theDGcontent">
                                        <i class="cosachmuonquahan fas fa-times"></i>
                                        <h2>Không thể xóa loại độc giả vì tồn tại độc giả thuộc loại độc giả này!</h2>
                                        <div class="btn" style="display: flex; justify-content: center;">
                                            <button class="cosachmuonquahan">OK</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                         <script>
                            const cosachmuonquahan = document.querySelectorAll(".cosachmuonquahan");
                            for(let i = 0; i < cosachmuonquahan.length; i++){
                                cosachmuonquahan[i].addEventListener("click", function(){
                                    document.querySelector(".thongbaocosachmuonquahan").classList.add("action");
                                });
                            }
                        </script>
                    <?php    
                    }                           
                    else{
                        $sql_xldg="UPDATE loaidocgia SET DaXoa=1 WHERE TenLoaiDocGia='$tenldg'";
                        if(mysqli_query($conn,$sql_xldg)){
                            ?>
                            <div>
                                <div class="thongbaosachmoi TBTDTTDN divphieuthu">
                                    <div class="TBthemmoi divktimthay">
                                        <div class="TBcontent theDGcontent">
                                            <h2>Xóa loại độc giả thành công!</h2>
                                            
                                            <form enctype="multipart/form-data" method="POST" >
                                                <div class="btn closephieumuonsach">
                                                    <button name="tattb" type="submit" >OK</button>
                                                </div> 
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                        <?php
                        }
                    }
                }

                }
            mysqli_close($conn);
        ?>

        <div class="divsuatheloai action">
            <div class="thongbaosachmoi  thongbaothaydoi">
                <div class="TBthemmoi divktimthay">
                    <form enctype="multipart/form-data" method="POST">
                        <div class="TBcontent theDGcontent">
                            <i class="close fas fa-times"></i>
                            <h2>Sửa loại độc giả</h2>
                            <div class="csssach">
                                <p>Chọn loại độc giả:</p>
                                <select style="width:240px" class="selectKindReader" name="kindReader" id="kindReader" value = "selected" required>
                                <?php
                                    $conn = mysqli_connect('localhost', 'root','', 'quanlythuvien')   or die ('fail');
        
                                    $sql = "SELECT * FROM `loaidocgia` WHERE DaXoa=0";
                                    $result = mysqli_query($conn, $sql);
                                    if (mysqli_num_rows($result) > 0){
                                        while ($row = mysqli_fetch_assoc($result)){
                                            ?>
                                                <option value="<?php echo $row['TenLoaiDocGia'] ?>">
                                                    <?php echo $row['TenLoaiDocGia'] ?>
                                            
                                            </option>
                                            <?php
                                        }
                                    }
                                    mysqli_close($conn);
                                ?>
                                </select>              
                                <p>Loại độc giả mới:</p>
                                <input type="text" placeholder="Nhập loại độc giả mới" name='tenldgmoi' required>
                            </div>
                            <div class="btn closephieumuonsach">
                                <button name = "sua" type="submit" class="xoa">Cập nhật</button>
                            </div> 
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <script>
            document.querySelector(".btnxoatheloai").addEventListener("click", function(){
                document.querySelector(".divxoatheloai").classList.remove("action");
            })
            document.querySelector(".btnsuatheloai").addEventListener("click", function(){
                document.querySelector(".divsuatheloai").classList.remove("action");
            })
            const dong = document.querySelectorAll(".close");
            for(let i = 0; i < dong.length; i++){
                dong[i].addEventListener("click", function(){
                    document.querySelector(".divsuatheloai").classList.add("action");
                    document.querySelector(".divxoatheloai").classList.add("action");

                });
            }
        </script>
    </div>
    <?php
            $conn = mysqli_connect('localhost', 'root','', 'quanlythuvien') or die('fail');
            if(isset($_POST["sua"])){
                $tenldg = $_POST["kindReader"];
                $tenldgmoi=$_POST["tenldgmoi"];

                $sql_ktldg="SELECT * FROM loaidocgia WHERE TenLoaiDocGia='$tenldgmoi' AND DaXoa=0";
                $res_ktldg=mysqli_query($conn,$sql_ktldg);
                if(mysqli_num_rows($res_ktldg)>0){
                    ?>
                    <div class="divTBTKadmin  thongbaotenloaidocgiabitrung">
                            <div class="thongbaosachmoi">
                                <div class="TBthemmoi divktimthay">
                                    <div class="TBcontent theDGcontent">
                                        <i class="tenloaidocgiabitrung fas fa-times"></i>
                                        <h2>Tên loại độc giả bị trùng!</h2>
                                        <div class="btn" style="display: flex; justify-content: center;">
                                            <button class="tenloaidocgiabitrung">OK</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                         <script>
                            const tenloaidocgiabitrung = document.querySelectorAll(".tenloaidocgiabitrung");
                            for(let i = 0; i < tenloaidocgiabitrung.length; i++){
                                tenloaidocgiabitrung[i].addEventListener("click", function(){
                                    document.querySelector(".thongbaotenloaidocgiabitrung").classList.add("action");
                                });
                            }
                        </script>
                <?php

                }
                else{
                $sql_sldg="UPDATE loaidocgia SET TenLoaiDocGia='$tenldgmoi' WHERE TenLoaiDocGia='$tenldg'";
                if(mysqli_query($conn,$sql_sldg)){
                    ?>
                    <div>
                        <div class="thongbaosachmoi TBTDTTDN divphieuthu">
                            <div class="TBthemmoi divktimthay">
                                <div class="TBcontent theDGcontent">
                                    <h2>Đã đổi tên loại độc giả!</h2>
                                            
                                    <form enctype="multipart/form-data" method="POST" >
                                        <div class="btn closephieumuonsach">
                                            <button name="tattb" type="submit" >OK</button>
                                        </div> 
                                    </form>
                                </div>
                            </div>
                        </div>
                                
                    </div>
                <?php
                }
                }
            }
            mysqli_close($conn);
        ?>



    <div class="divContent main DSthedocgia">
                <h2>Danh sách thẻ độc giả</h2>
                <div class="container_caidatchung">
                    <form action="option_change_main.php" method="POST">
                        <table id="resultSearchBook">
                            <thead>
                                <th>STT</th>
                                <th>Mã độc giả</th>
                                <th>Loại độc giả</th>
                                <th>Họ tên</th>
                                <th>Ngày sinh</th>
                                <th>Địa chỉ</th>
                                <th>Email</th>
                                <th>Ngày lập thẻ</th>
                                <th>Ngày hết hạn</th>
                                <th>Tổng nợ</th>
                                <th>Chỉnh sửa</th>
                                <th>Xóa</th>
                                <th>Gia hạn</th>
                            </thead>
                            <tbody>
                                <?php
                                    $conn = mysqli_connect('localhost', 'root', '', 'quanlythuvien') or die ('fail');
                                    if(mysqli_connect_errno()){
                                        echo "failed to connect to Mysql: ".mysqli_connect_error();
                                        exit();
                                    }
                                    if(isset($_POST['xacnhan'])){
                    
                                        $sql19="SELECT GiaTri from thamso where TenThamSo='ThoiHanthe'";
                                        if(!$result19=$mysqli->query($sql19)) echo 'Loi19: '.$mysqli->error;
                                        $kq19=$result19->fetch_assoc();
                                        $thoihanqd=$kq19["GiaTri"];
                    
                                        $taongay=mktime(0,0,0,date("m")+$thoihanqd,date("d"),date("Y"));
                                        $ngayhethanmoi=date("Y-m-d",$taongay);
                    
                                        $sql17="UPDATE docgia set DaHetHan='0', NgayHetHan='$ngayhethanmoi' where MaDocGia ='$madocgia'";
                                        if(!$mysqli->query($sql17)) echo 'Loi16: '.$mysqli->error;
                                    }
                                    $sql_ = "SELECT * FROM `docgia` WHERE DaXoa=0";
                                    $res_ = mysqli_query($conn, $sql_);
                                    $index=1;
                                    if(mysqli_num_rows($res_)>0){
                                        while($row = mysqli_fetch_assoc($res_)){
                                            $maloaidg = $row["MaLoaiDocGia"];

                                            $sql_1 = "SELECT TenLoaiDocGia FROM loaidocgia WHERE MaLoaiDocGia='$maloaidg'";
                                            $res_1 = mysqli_query($conn, $sql_1);
                                            $row_1 = mysqli_fetch_assoc($res_1);
                                            $loaidg = $row_1["TenLoaiDocGia"];
                                            
                                            if($row["DaXoa"]==0){
                                                $ngaysinh = $row["NgaySinh"];
                                                $ngaysinhhtml = date("d/m/Y",strtotime($ngaysinh));
                                                $ngaylapthe = $row["NgayLapThe"];
                                                $ngaylapthehtml = date("d/m/Y",strtotime($ngaylapthe));
                                                $ngayhHan = $row["NgayHetHan"];
                                                $ngayhHanhtml = date("d/m/Y",strtotime($ngayhHan));
                                            ?>
                                            <tr>
                                                <td class="stt"><?php echo $index ?></td>
                                                <td class="madg"><?php echo $row["MaDocGia"] ?></td>
                                                <td class="loaidg"><?php echo $loaidg ?></td>
                                                <td class="hoten"><?php echo $row["HoTen"] ?></td>
                                                <td class="ngaysinh"><?php echo $ngaysinhhtml; ?></td>
                                                <td class="diachi"><?php echo $row["DiaChi"] ?></td>
                                                <td class="email"><?php echo $row["Email"] ?></td>
                                                <td class="ngaylapthe"><?php echo $ngaylapthehtml; ?></td>
                                                <td class="ngayhethan"><?php echo $ngayhHanhtml ?></td>
                                                <td class="tongno"><?php echo $row["TongNo"] ?></td>
                                                <td><a href="option_edit.php?GetID=<?php echo $row["MaDocGia"] ?>">Chỉnh sửa</a></td>
                                                <td>
                                                    <?php
                                                        $madg=$row["MaDocGia"];
                                                        $check=0;
                                                        $sql___="SELECT * FROM docgia WHERE MaDocGia='$madg' AND DaXoa=0 AND TongNo!=0";
                                                        $res___=mysqli_query($conn,$sql___);
                                                        if(mysqli_num_rows($res___)>0) $check=1;
                                                        $sql__="SELECT * FROM phieumuontra WHERE MaDocGia='$madg'";
                                                        if($res__=mysqli_query($conn,$sql__)){
                                                        if(mysqli_num_rows($res__)>0){
                                                            while($row__=mysqli_fetch_assoc($res__)){
                                                                if($row__["NgayTra"]==''){
                                                                $check=1;
                                                                }
                                                            }
                                                        }
                                                    }
                                                        if($check==1){
                                                            ?>
                                                            <a href="option_delete.php?GetID=<?php echo $row["MaDocGia"] ?>"></a>
                                                            <?php
                                                        }
                                                        else{
                                                            ?>
                                                            <a href="option_delete.php?GetID=<?php echo $row["MaDocGia"] ?>">Xóa</a>
                                                            <?php
                                                        }
                                                    ?>
                                                </td>
                                                <?php
                                                    $ngayhientai=date("Y-m-d");
                                                    $ngayhethan = $row["NgayHetHan"];
                                                    $madocgia = $row["MaDocGia"];
                                                    if(strtotime($ngayhientai)>strtotime($ngayhethan)){
                                                        $sql16="UPDATE docgia set DaHetHan=1 where MaDocGia='$madocgia'";
                                                        ?>  
                                                            <td>
                                                                <a href="giahan.php?GetID=<?php echo $madocgia;?>">Gia hạn</a>
                                                            </td>
                                                        <?php
                                                    }
                                                    else{
                                                        ?>
                                                        <td></td>
                                                        <?php
                                                    }
                                                ?>
                                            </tr>
                                            <?php 
                                            $index=$index+1;
                                        }
                                    }
                                }  
                            ?>
                            <h3> <?php echo "Danh sách gồm " . ($index-1) . " thẻ độc giả.";  ?> </h3>        
                            </tbody>
                        </table>
                            <br>                                                              
                            <?php
                            mysqli_close($conn);
                        ?>
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