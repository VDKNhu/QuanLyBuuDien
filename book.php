<!-- fsdffnrengiergnrui -->
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
    <title>Thông tin sách</title>
</head>
<body>
    <?php
        $conn = mysqli_connect('localhost', 'root', '', 'quanlythuvien') or die ('fail');
        error_reporting(E_ERROR);
        if(mysqli_connect_errno()){
            echo "failed to connect to Mysql: ".mysqli_connect_error();
            exit();
        }
        $ma=0;
        $ma_=0;
        $ma__=0;
        $ma___=0;
        $madausach=-1;
        $daxoa=0;
        if($_SERVER["REQUEST_METHOD"] == "POST"){
                $check=0; //kiem tra viec nhap, neu check = 1 nghia la nhap thanh cong

                $tendausach = $_POST["tensach"];
                
                // the loai
                $tl = 0; // tl = 0 the loai cu
                         // tl = 1 the loai moi
                $theloai = $_POST["theloai"];
                $theloaimoi = $_POST["TL"];
                
                if($theloaimoi != ''){
                    $tl=1;
                    $tlsach="SELECT * FROM theloai WHERE DaXoa='0'";
                    $res_tlsach = mysqli_query($conn, $tlsach);
                    if(mysqli_num_rows($res_tlsach) > 0){
                        while ($row = mysqli_fetch_assoc($res_tlsach)){
                            if($row['TenTheLoai'] == $theloaimoi){
                                $tl = 0;
                                break;
                            }
                        }
                    }

                    // them the loai moi vao bang theloai
                    if($tl == 1){
                        $sqli_tlm = "INSERT INTO theloai (MaTheLoai, TenTheLoai, DaXoa) VALUES ('$ma', '$theloaimoi', '$daxoa')";
                        if(mysqli_query($conn, $sqli_tlm)){
                        }
                    }

                    // gan $theloai bang ma the loai moi 
                    $matl="SELECT MaTheLoai FROM theloai WHERE TenTheLoai='$theloaimoi' AND DaXoa='0'";
                    $res_matl = mysqli_query($conn, $matl);
                    $row_matl = mysqli_fetch_assoc($res_matl);
                    $theloai = $row_matl['MaTheLoai'];    
                }
                
                // tac gia
                $tgmoi = array ($_POST["TGM1"], $_POST["TGM2"], $_POST["TGM3"], $_POST["TGM4"], $_POST["TGM5"]);

                $tacgiamoi = array();
                $temp_=array('-1','-1','-1','-1','-1');
                $tgm_max=0;
                $tgt_max=0;
                $k=0;
                for($i=0; $i<5; $i++){
                    $kt_tg="SELECT * FROM tacgia WHERE TenTacGia='$tgmoi[$i]' AND DaXoa='0'";
                    $res_kt_tg = mysqli_query($conn, $kt_tg);
                    $row_kt_tg = mysqli_fetch_assoc($res_kt_tg);
                    $kt_tg = $row_kt_tg['MaTacGia'];    

                    if($kt_tg!=''){
                        $temp_[$i]=$kt_tg;
                        $tgt_max++;
                    }

                    if($tgmoi[$i] != '' && $kt_tg == ''){
                        $tacgiamoi[$k]=$tgmoi[$i];
                        $tgm_max++;
                        $k++;
                    }
                }

                // insert cac tac gia moi vao bang tacgia
                if($tgm_max != 0){
                    for($i=0; $i<$tgm_max; $i++){                           
                        $sqli_tgm = "INSERT INTO tacgia (MaTacGia, TenTacGia, DaXoa) VALUES ('$ma', '$tacgiamoi[$i]', '$daxoa')";
                        if(mysqli_query($conn, $sqli_tgm)){
                        }
                        $matg_ = "SELECT MaTacGia FROM tacgia WHERE TenTacGia='$tacgiamoi[$i]' AND DaXoa='0'";
                        $res_matg_ = mysqli_query($conn, $matg_);
                        $row_matg_ = mysqli_fetch_assoc($res_matg_);
                        $tacgiamoi[$i] = $row_matg_['MaTacGia'];                              
                    }
                }

                if($tgt_max!=0){
                    $tgm_max_=$tgm_max+5;
                    $k=$tgm_max;
                    for($i=$tgm_max;$i<$tgm_max_;$i++){
                        if($temp_[$i]!='-1'){
                            $tacgiamoi[$k]=$temp_[$i];
                            $k++;
                            $tgm_max++;
                        }
                    }
                }

                $tacgia =  array ($_POST["tacgia1"], $_POST["tacgia2"], $_POST["tacgia3"], $_POST["tacgia4"], $_POST["tacgia5"]);
                $tg_max = 0;
                for($i=0 ; $i<5 ; $i++){
                    if($tacgia[$i] != 'selected' && $tacgia[$i+1] == 'selected'){
                        $tg_max=$i+1;
                        break;
                    }
                }  

                $sl_tg=0;
                if($tg_max != 0 && $tgm_max != 0){
                    $sl_tg = $tg_max+$tgm_max;
                    for($k=$tg_max; $k < $sl_tg; $k++){
                        $tacgia[$k] = $tacgiamoi[$k-$tg_max];
                    }    
                }

                if($tg_max != 0 && $tgm_max == 0) $sl_tg = $tg_max;
                if($tg_max == 0 && $tgm_max != 0) {
                    $sl_tg = $tgm_max;
                    for($k=0; $k < $sl_tg; $k++){
                        $tacgia[$k] = $tacgiamoi[$k];
                    }    
                }

                $nhaxuatban = $_POST["nhaxuatban"];
                $namxuatban = $_POST["namxuatban"];
                $ngaynhap = $_POST["ngaynhap"];
                $trigia = $_POST["trigia"];
                $tongsosach = $_POST["tongsosach"];

                $thoihan=date("Y")-$namxuatban;
                $khoangcachxb="SELECT GiaTri FROM thamso WHERE TenThamSo='KhoangCachNamXB'";
                $res_kcxb = mysqli_query($conn, $khoangcachxb);
                $row_kcxb = mysqli_fetch_assoc($res_kcxb);
                $khoangcachxb = $row_kcxb['GiaTri'];

                $nhaxb="SELECT NhaXuatBan FROM sach, dausach WHERE TenDauSach='$tendausach' AND sach.MaDauSach=dausach.MaDauSach AND dausach.DaXoa='0'";
                $res_nhaxb = mysqli_query($conn, $nhaxb);
                $row_nhaxb = mysqli_fetch_assoc($res_nhaxb);
                $nhaxb = $row_nhaxb['NhaXuatBan'];

                $namxb="SELECT NamXuatBan FROM sach, dausach WHERE TenDauSach='$tendausach' AND sach.MaDauSach=dausach.MaDauSach AND dausach.DaXoa='0'";
                $res_namxb = mysqli_query($conn, $namxb);
                $row_namxb = mysqli_fetch_assoc($res_namxb);
                $namxb = $row_namxb['NamXuatBan'];

                $kt_matheloai="SELECT MaTheLoai FROM dausach WHERE TenDauSach='$tendausach' AND DaXoa='0'";
                $res_ktmtl = mysqli_query($conn, $kt_matheloai);
                $row_ktmtl = mysqli_fetch_assoc($res_ktmtl);
                $kt_matheloai = $row_ktmtl['MaTheLoai'];

                $kt_trigia="SELECT GiaTien FROM sach, dausach WHERE sach.MaDauSach=dausach.MaDauSach AND TenDauSach='$tendausach' AND dausach.DaXoa='0'";
                $res_kttg = mysqli_query($conn, $kt_trigia);
                $row_kttg = mysqli_fetch_assoc($res_kttg);
                $kt_trigia = $row_kttg['GiaTien'];

                $kt_mtg=array();
                $index_tg=0;
                $kt_matacgia="SELECT MaTacGia FROM dausach, ct_tacgia WHERE dausach.MaDauSach=ct_tacgia.MaDauSach AND TenDauSach='$tendausach' AND DaXoa='0'";
                $res_ktmtg = mysqli_query($conn, $kt_matacgia);
                if(mysqli_num_rows($res_ktmtg)>0){
                    while($row_ktmtg=mysqli_fetch_assoc($res_ktmtg)){
                        $kt_mtg[$index_tg]=$row_ktmtg["MaTacGia"];
                        $index_tg++;
                    }
                }

                $tends="SELECT TenDauSach FROM dausach WHERE TenDauSach='$tendausach' AND DaXoa='0'";
                $res_tends = mysqli_query($conn, $tends);
                if(mysqli_num_rows($res_tends)==0)
                    $tends=NULL;
                else{
                $row_tends = mysqli_fetch_assoc($res_tends);
                $tends = $row_tends['TenDauSach'];
                }


                
                $i=-1;
                // dau sach moi
                if($tends == NULL) $i=1; 
                // da ton tai dau sach, them vao bang sach va cuonsach
                $b=1;
                if($tends != NULL){
                    $sql_kt1="SELECT * FROM dausach INNER JOIN sach ON dausach.MaDauSach=sach.MaDauSach 
                                WHERE TenDauSach='$tendausach' AND MaTheLoai='$theloai' AND dausach.DaXoa='0'";
                    $res_kt1=mysqli_query($conn,$sql_kt1);
                    if(mysqli_num_rows($res_kt1)>0){
                        while($row_kt1=mysqli_fetch_assoc($res_kt1)){
                            if($index_tg!=$sl_tg) $b=0;
                            else{
                                $temp=array();
                                for($k=0;$k<$index_tg;$k++) $temp[$k]=-1;
                                for($k=0; $k<$index_tg; $k++){
                                    for($l=0;$l<$sl_tg;$l++){
                                        if($tacgia[$k]==$kt_mtg[$l]){
                                            $temp[$k]=1;
                                        }
                                    }
                                } 
                                for($k=0;$k<$sl_tg;$k++){
                                    if($temp[$k]==-1){
                                        $b=0;
                                        break;
                                    } 
                                }  
                            }
                            if($b==1){
                                if($row_kt1["NhaXuatBan"] == $nhaxuatban && $row_kt1["NamXuatBan"] == $namxuatban) {
                                    if($row_kt1["GiaTien"]==$trigia){
                                        $i=3;$b=1;break;
                                    }
                                    else $b=0;
                                }
                                else if($row_kt1["NhaXuatBan"] != $nhaxuatban || $row_kt1["NamXuatBan"] != $namxuatban) {$i=2;$b=1;}
                            }
                        }
                    }
                }
                                $kt=-1;
                if($thoihan>$khoangcachxb) $kt=0;
                if($thoihan<=$khoangcachxb){
                    switch($i){
                        case 1:
                            if($b==1){
                            //inset vao dau sach                            
                            $sqli_dausach = "INSERT INTO dausach (MaDauSach, TenDauSach, MaTheLoai, DaXoa) VALUES ('$ma', '$tendausach', '$theloai', '$daxoa')";
                            if(mysqli_query($conn, $sqli_dausach)){
                            }

                            $mads="SELECT MaDauSach FROM dausach WHERE TenDauSach='$tendausach' AND MaTheLoai='$theloai' AND DaXoa='0'";
                            $res_mads = mysqli_query($conn, $mads);
                            $row_mads = mysqli_fetch_assoc($res_mads);
                            $mads = $row_mads['MaDauSach'];

                            if($sl_tg != 0){
                                for($i=0; $i < $sl_tg; $i++){                           
                                    $sqli_cttg = "INSERT INTO ct_tacgia (MaDauSach, MaTacGia) VALUES ('$mads', '$tacgia[$i]')";
                                    if(mysqli_query($conn, $sqli_cttg)){
                                    }
                                }
                            }
                        }
                        case 2:
                            if($b==1){
                            //insert vao sach
                            $mads="SELECT MaDauSach FROM dausach WHERE TenDauSach='$tendausach' AND MaTheLoai='$theloai' AND DaXoa='0'";
                            $res_mads = mysqli_query($conn, $mads);
                            $row_mads = mysqli_fetch_assoc($res_mads);
                            $mads = $row_mads['MaDauSach'];

                            $sqli_sach = "INSERT INTO sach (MaSach, MaDauSach, NamXuatBan, NhaXuatBan, GiaTien, SoLuong, DaXoa) VALUES ('$ma_', '$mads', '$namxuatban', '$nhaxuatban', '$trigia', '$tongsosach', '$daxoa')";
                            if(mysqli_query($conn, $sqli_sach)){
                            }
                        }
                        case 3:
                            if($b==1){
                            //insert vao cuonsach
                            $mads="SELECT MaDauSach FROM dausach WHERE TenDauSach='$tendausach' AND MaTheLoai='$theloai' AND DaXoa='0'";
                            $res_mads = mysqli_query($conn, $mads);
                            $row_mads = mysqli_fetch_assoc($res_mads);
                            $mads = $row_mads['MaDauSach'];

                            $masach = "SELECT MaSach FROM sach WHERE MaDauSach='$mads' AND NamXuatBan='$namxuatban' AND NhaXuatBan='$nhaxuatban' AND DaXoa='0'";
                            $res_ms = mysqli_query($conn, $masach);
                            $row_ms = mysqli_fetch_assoc($res_ms);
                            $masach = $row_ms['MaSach']; 
                            
                            for($i=0; $i<$tongsosach; $i++){
                                // tinh trang 0: chua duoc muon
                                // tinh trang 1: da duoc muon
                                $tinhtrang=0;
                                $sqli_cuonsach = "INSERT INTO cuonsach (MaCuonSach, MaSach, TinhTrang, DaXoa) VALUES ('$ma__', '$masach', '$tinhtrang', '$daxoa')";
                                if(mysqli_query($conn, $sqli_cuonsach)){
                                }
                            }

                            $tongtien = $trigia * $tongsosach;
                            $sql_pns = "INSERT INTO phieunhapsach (SoPNS, NgayLap, TongTien) VALUES ('$ma___', '$ngaynhap', '$tongtien')";
                            if(mysqli_query($conn, $sql_pns)){
                            }

                            $mapns = "SELECT SoPNS FROM phieunhapsach WHERE NgayLap='$ngaynhap' AND TongTien=$tongtien";
                            $res_mapns = mysqli_query($conn, $mapns);
                            $row_mapns = mysqli_fetch_assoc($res_mapns);
                            $mapns = $row_mapns['SoPNS']; 

                            $sql_ctpns = "INSERT INTO ct_phieunhapsach (SoPNS, MaSach, SoLuongNhap, DonGia, ThanhTien) VALUES ('$mapns', '$masach', '$tongsosach', '$trigia', '$tongtien')";
                            if(mysqli_query($conn, $sql_ctpns)){
                            }
                            $check=1;
                        }

                        default:

                    }
                }
                if($check==1){
                    ?>
                    <div class="thongbaosachmoi">
                        <div class="TBthemmoi">
                            <div class="TBcontent theDGcontent">
                                <h1><?php echo 'Nhập sách thành công!'; ?></h1>
                                <div class="btn">
                                    <button><a href="index-home.php">Trở về trang chủ</a></button>
                                    <button><a href="tiepnhansachmoi.php">Nhập sách mới</a></button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                } 
                else if($kt==0){
                    ?>
                    <div class="thongbaosachmoi">
                        <div class="TBthemmoi">
                            <div class="TBcontent theDGcontent">
                                <h1><?php echo "Khoang cach xuat ban phai trong vong " . $khoangcachxb . " nam tro lai!";?></h1>
                                <div class="btn">
                                    <button><a href="index-home.php">Trở về trang chủ</a></button>
                                    <button><a href="tiepnhansachmoi.php">Nhập sách mới</a></button>
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
                                <h1><?php echo "Các thông tin nhập chưa đúng theo lưu ý. Vui lòng nhập lại!";?></h1>
                                <div class="btn">
                                    <button><a href="index-home.php">Trở về trang chủ</a></button>
                                    <button><a href="tiepnhansachmoi.php">Nhập sách mới</a></button>
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

