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
    <link rel="stylesheet" href="style-ltdg.css">
    <link rel="stylesheet" href="style_thongbao.css">
    <script src="js_tiepnhansachmoi.js" defer></script>
    <script src="jsbaocao.js" defer></script>
    <title>Tiếp nhận sách mới</title>
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
    <div class="tiepnhansachmoi divContent main">
        <div class="navbar">
            <h2>Sửa thông tin sách</h2>
            
            <form class="formMain" enctype="multipart/form-data" method="POST">
                <?php
                    $conn = mysqli_connect('localhost', 'root', '', 'quanlythuvien') or die ('fail');
                    if(mysqli_connect_errno()){
                        echo "failed to connect to Mysql: ".mysqli_connect_error();
                        exit();
                    }
                
                    $masach = $_GET['GetID'];
                    if(isset($_POST['suaTTSTC'])){
                        $masach = $_POST['masach'];
                    }
                    $sql = "SELECT DISTINCT dausach.MaDauSach, sach.MaSach, TenDauSach, TenTacGia, TenTheLoai, NhaXuatBan, NamXuatBan, SoLuong, GiaTien, NgayLap
                    FROM dausach INNER JOIN sach ON dausach.MaDauSach = sach.MaDauSach
                    INNER JOIN ct_tacgia ON dausach.MaDauSach=ct_tacgia.MaDauSach
                    INNER JOIN tacgia ON ct_tacgia.MaTacGia=tacgia.MaTacGia
                    INNER JOIN theloai ON dausach.MaTheLoai=theloai.MaTheLoai
                    INNER JOIN ct_phieunhapsach ON ct_phieunhapsach.MaSach=sach.MaSach
                    INNER JOIN phieunhapsach ON ct_phieunhapsach.SoPNS=phieunhapsach.SoPNS
                    WHERE sach.masach=$masach";
                    $result = mysqli_query($conn, $sql);
                    $row = mysqli_fetch_assoc($result);               
                ?>
                <div class="csssach csswidth">
                    Mã sách:
                    <input class="kdcsua" readonly type="text" name="masach" value="<?php echo $masach; ?>" required>
                </div>
                <div class="csssach Tendausach">
                    Tên đầu sách:
                    <input type="text" name="tendausach" value="<?php echo $row['TenDauSach']; ?>" required>
                </div>
                <?php
                    $conn = mysqli_connect('localhost', 'root','', 'quanlythuvien');
                    $masach = $_GET['GetID'];
                    $matacgia = array ("-1", "-1", "-1", "-1", "-1");
                    $tacgia = array("-1", "-1", "-1", "-1", "-1");
                    $tg="SELECT TenTacGia, tacgia.MaTacGia, dausach.MaTheLoai, TenTheLoai
                        FROM ct_tacgia INNER JOIN sach ON ct_tacgia.MaDauSach=sach.MaDauSach
                                        INNER JOIN tacgia ON ct_tacgia.MaTacGia=tacgia.MaTacGia
                                        INNER JOIN dausach ON sach.MaDauSach=dausach.MaDauSach
                                        INNER JOIN theloai ON dausach.MaTheLoai=theloai.MaTheLoai
                        WHERE sach.DaXoa='0' AND MaSach='$masach'";
                    $k=0;
                    if($res = mysqli_query($conn, $tg)){
                    if(mysqli_num_rows($res) > 0){
                        while ($row_ = mysqli_fetch_assoc($res)){
                            $tacgia[$k]=$row_['TenTacGia'];
                            $matacgia[$k]=$row_['MaTacGia'];
                            $k++;
                        }
                    }    
                    for($i=0; $i<$k; $i++){
                        $l=$i+5;
                        ?>
                        <div>
                            <input hidden type="text" name="<?php echo $i;?>" value="<?php echo $tacgia[$i]; ?>" required>
                            <input hidden type="text" name="<?php echo $l;?>" value="<?php echo $matacgia[$i]; ?>" required>
                        </div> 
                        <?php     
                    }
                    for($i=$k; $i<5; $i++){
                        $l=$i+5;
                        ?>
                        <div>
                            <input hidden type="text" name="<?php echo $i;?>" value="<?php echo $tacgia[$i]; ?>" required>
                            <input hidden type="text" name="<?php echo $l;?>" value="<?php echo $matacgia[$i]; ?>" required>
                        </div> 
                        <?php     
                    }
                }
                ?>
                <div id="themTacGia">
                    <div>
                        Tác giả:
                    </div>
                        <div class="plusinput" id="NhieuTG">
                                <?php
                                    for($i=0; $i<$k; $i++){
                                ?>
                                    <select name="<?php echo $i; ?>" id="tacgia" value = "selected">
                                        <option value="<?php echo $matacgia[$i]; ?>"><?php echo $tacgia[$i]; ?></option>
                                        <?php
                                            $sql_timtg = "SELECT * FROM `tacgia` WHERE DaXoa=0";
                                            $result_timtg = mysqli_query($conn, $sql_timtg);
                                            if(mysqli_num_rows($result_timtg) > 0){
                                                while ($row_timtg = mysqli_fetch_assoc($result_timtg)){
                                                    ?>
                                                    <option value="<?php echo $row_timtg['MaTacGia']?>">
                                                        <?php echo $row_timtg['TenTacGia']?>
                                                    </option>
                                                    <?php
                                                }
                                            }
                                        ?>
                                    </select>
                                <?php
                                    }
                                ?>
                        </div>
                    
                </div>
                    <?php
                        $sql_timtheloai="SELECT * FROM theloai INNER JOIN dausach ON theloai.MaTheLoai=dausach.MaTheLoai
                                            INNER JOIN sach ON dausach.MaDauSach=sach.MaDauSach
                                            WHERE MaSach='$masach' AND sach.DaXoa=0";
                        $res_timtheloai=mysqli_query($conn,$sql_timtheloai);
                        $row_timtheloai=mysqli_fetch_assoc($res_timtheloai);
                    ?>
                <div class="csssach csswidth">
                    <div id="themtheloai" class="navcss">
                        <div class="csssach" style="width: 544px">
                            Thể loại:
                                <select style="width:327px" name="theloai" id="kindBook" value = "selected">
                                    <option value="<?php echo $row_timtheloai["MaTheLoai"];?>"><?php echo $row_timtheloai["TenTheLoai"];?></option>
                                    <?php
                                        $sql = "SELECT * FROM `theloai` WHERE DaXoa=0";
                                        $result = mysqli_query($conn, $sql);
                                        if(mysqli_num_rows($result) > 0){
                                            while ($row_ = mysqli_fetch_assoc($result)){
                                                ?>
                                                <option value="<?php echo $row_['MaTheLoai']?>">
                                                    <?php echo $row_['TenTheLoai']?>
                                                </option>
                                                <?php
                                            }
                                        }
                                        mysqli_close($conn);
                                    ?>
                                </select>
                        </div>
                    </div>
                </div>
                <div id="themxuatban" class="navcss">
                    <div class="csssach">
                        Nhà xuất bản:
                        <input class="cssinput" type="text" name="nhaxuatban" value="<?php echo $row['NhaXuatBan']; ?>" required>
                    </div>
                    <div class="csssach">
                        Năm xuất bản:
                        <?php
                            $conn = mysqli_connect('localhost', 'root','', 'quanlythuvien');

                            $khoangcachxb="SELECT GiaTri FROM thamso WHERE TenThamSo='KhoangCachNamXB'";
                            $res_kcxb = mysqli_query($conn, $khoangcachxb);
                            $row_kcxb = mysqli_fetch_assoc($res_kcxb);
                            $khoangcachxb = $row_kcxb['GiaTri'];

                            $max = date("Y");
                            $min = $max - $khoangcachxb;
                            $ngaynhap = $row['NgayLap'];
                            $ngaynhaphtml = date("d/m/Y",strtotime($ngaynhap));

                        
                        ?>
                        <input class="cssinput"  type="number" name="namxuatban" min="<?php echo $min ?>" max="<?php echo $max ?>" step="1" value="2021" placeholder="Nhập năm xuất bản" required>
                    </div>
                </div>
                <div class="navcss">
                    <div class="csssach">
                        Ngày nhập:
                        <input style="width:330px" readonly class=" kdcsua cssinput"  type="text" name="ngaynhap" value="<?php echo $ngaynhaphtml; ?>">
                    </div>

                    <div class="csssach">
                        Trị giá (đồng):
                        <input style="width:330px" readonly class=" kdcsua cssinput" type="number" name="trigia" value="<?php echo $row['GiaTien']; ?>" min="0" required>
                    </div>
                    <div class="csssach slsach">
                        Số lượng sách:
                         <input style="width:330px" readonly class="kdcsua cssinput" type="number" name="tongsosach" value="<?php echo $row['SoLuong']; ?>" placeholder="Nhập số lượng sách" min="0" required>
                    </div>
                </div>
                <div class="btn" style="display:flex; justify-content: space-between;">
                    <a id="btnQuaylai" href="tiepnhansachmoi.php">Quay lại</a>
                    <button name="luuTTSvuathaydoi" type="submit">Lưu thay đổi</button>
                </div>
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
    <?php
    $conn = mysqli_connect('localhost', 'root', '', 'quanlythuvien') or die ('fail');
    if(mysqli_connect_errno()){
        echo "failed to connect to Mysql: ".mysqli_connect_error();
        exit();
    }
    if ( isset($_POST['luuTTSvuathaydoi'])){
        $bool=0; //khong thuc hien lenh update nao
                // bool=1 khi thuc hien it nhat 1 update
        $masach = $_POST["masach"];
        $tends = $_POST["tendausach"];
        $nhaxb=$_POST["nhaxuatban"];
        $namxb=$_POST["namxuatban"];

        $matg = array ("-1", "-1", "-1", "-1", "-1");
        for($i=0; $i<5; $i++){
            $matg[$i] = $_POST["$i"];
        }

        $sl_tg=0;
        for($sl_tg; $sl_tg<5; $sl_tg++){
            if($matg[$sl_tg] == "-1") break;
        }

        $tl = $_POST["theloai"];

        $sql1 = "SELECT dausach.MaDauSach, TenDauSach, NamXuatBan, NhaXuatBan FROM dausach INNER JOIN sach ON dausach.MaDauSach=sach.MaDauSach
                WHERE MaSach='$masach'";
        $res1 = mysqli_query($conn,$sql1);
        $row1 = mysqli_fetch_assoc($res1);
        $tendausach = $row1["TenDauSach"];
        $namxuatban=$row1["NamXuatBan"];
        $nhaxuatban=$row1["NhaXuatBan"];
        $madausach=$row1["MaDauSach"];

        $sql2 = "SELECT MaTheLoai FROM dausach INNER JOIN sach ON dausach.MaDauSach=sach.MaDauSach
                    WHERE MaSach='$masach'";
        $res2 = mysqli_query($conn,$sql2);
        $row2 = mysqli_fetch_assoc($res2);
        $matl = $row2["MaTheLoai"];

        $k=0;
        $sql_stg="SELECT * FROM ct_tacgia WHERE MaDauSach='$madausach'";
        $res_stg=mysqli_query($conn,$sql_stg);
        if(mysqli_num_rows($res_stg)>0){
            while($row_stg=mysqli_fetch_assoc($res_stg)){
                $matacgiamoi=$matg[$k];
                $matacgia_s=$row_stg["MaTacGia"];
                
                $sql_u="UPDATE ct_tacgia SET MaTacGia='$matacgiamoi' WHERE MaDauSach='$madausach' AND MaTacGia='$matacgia_s'";
                $bool=1;
                if(mysqli_query($conn,$sql_u)){
                }
                $k++;
            }
        }

        if($tends != $tendausach && $tends != ''){
            $sql_tds = "UPDATE dausach INNER JOIN sach ON dausach.MaDauSach=sach.MaDauSach 
                        SET TenDauSach='$tends'
                        WHERE MaSach='$masach'";
            $bool=1;
            if(mysqli_query($conn, $sql_tds)){}
        }
        if($tl != $matl){
            $sql_ttl = "UPDATE dausach INNER JOIN sach ON dausach.MaDauSach=sach.MaDauSach
                        SET MaTheLoai='$tl'
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

        if($bool==1){
            ?>
            
            <div class="divTBTKadmin   thongbaoDoiTTTKTC">
                    <div class="thongbaosachmoi">
                        <div class="TBthemmoi divktimthay">
                            <div class="TBcontent theDGcontent">
                                <a href="option_edit_s.php?GetID=<?php echo $masach; ?>"><i class="bitrung fas fa-times"></i></a>
                                <h2>Đã thay đổi thông tin sách!</h2>
                                <form enctype="multipart/form-data" method="POST" >
                                <input type="hidden" name="masach" value="<?php echo $masach;?>">
                                    <div class="btn"  style="justify-content: center;">
                                        <button type="submit" name="suaTTSTC">OK</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php
        }
        else{
            ?>
            <div class="divTBTKadmin  thongbaothongtinbitrung">
                    <div class="thongbaosachmoi">
                        <div class="TBthemmoi divktimthay">
                            <div class="TBcontent theDGcontent">
                                <a id="closethongtinbitrung"><i class="bitrung fas fa-times"></i></a>
                                <h2>Thông tin thay đổi bị trùng hoặc rỗng!</h2>
                                <div class="btn" style="justify-content: center;">
                                    <button id="btnthongtintrung">OK</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <script>
                    document.getElementById("btnthongtintrung").addEventListener("click", function(){
                        document.querySelector(".thongbaothongtinbitrung").classList.add("action");
                    })
                    document.getElementById("closethongtinbitrung").addEventListener("click", function(){
                        document.querySelector(".thongbaothongtinbitrung").classList.add("action");
                    })
                </script>
            <?php
        }
    }

    mysqli_close($conn);
?>
</body>
</html>












