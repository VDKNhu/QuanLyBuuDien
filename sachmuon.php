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
    <title>Danh sách sách mượn</title>
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
                    <li class="select backgd"><a href="sachmuon.php">Mượn sách</a></li>
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
    <h1 style="margin-top: 80px; text-align:center; font-size:50px;">Phiếu mượn sách</h1>

    <div class="main"  style="width:80vw">
        <div class="phieumuonsach">
            <div class="divContent thongtindocgia">
                <h2>Thông tin độc giả mượn sách</h2>
                <div class="thongtinDG">
                <form class=" container" enctype="multipart/form-data"  method="POST">
                    Mã Độc Giả: 
                    <input class="inputmaDG" type="number" name="madocgia" placeholder="Nhập mã độc giả"> <br>
                    Họ và Tên:
                    <input class="inputtenDG" type="text" name="tendocgia" placeholder="Nhập tên độc giả">
                    <div class="btn btnDGMS">
                        <button type="submit" class="save" name="btnTimDGMS">Tìm</button>
                    </div>
                </form>
                    
                </div>
            </div>
        </div>

        <?php
            //In ra thông tin độc giả 
            require('dbconnect.php');
            //error_reporting(E_ERROR);

            if(isset($_POST['btnTimDGMS']) ||isset($_POST['giahanthanhcong']) || isset($_POST['btnTimSachMuon']) || isset($_POST['lapphieuMS']) || isset($_POST['tatTBlapPM']) || isset($_POST['xacnhan'])){
                $madocgia= $_POST["madocgia"];
                $sosachmuonquahan=0;
                if(isset($_POST['btnTimDGMS'])){
                    $tendocgia = $_POST["tendocgia"];
                    $sql2="SELECT NgayHetHan FROM docgia WHERE MaDocGia='$madocgia' and HoTen = '$tendocgia' and DaXoa=0";
                }else{
                    $sql2="SELECT NgayHetHan, HoTen FROM docgia WHERE MaDocGia='$madocgia' and DaXoa=0 ";
                }
                ////Neu xác nhận gia han
                if(isset($_POST['xacnhan'])){
                    
                    $sql19="SELECT GiaTri from thamso where TenThamSo='ThoiHanthe'";
                    if(!$result19=$mysqli->query($sql19)) echo 'Loi19: '.$mysqli->error;
                    $kq19=$result19->fetch_assoc();
                    $thoihanqd=$kq19["GiaTri"];
                    $sql30="SELECT HoTen from docgia where MaDocGia='$madocgia'";
                    if(!$result30=$mysqli->query($sql30)) echo 'Loi78: '.$mysqli->error;
                    $htdg=$result30->fetch_assoc();
                    $tendocgia=$htdg["HoTen"];


                    $taongay=mktime(0,0,0,date("m")+$thoihanqd,date("d"),date("Y"));
                    $ngayhethanmoi=date("Y-m-d",$taongay);

                    $sql17="UPDATE docgia set DaHetHan='0', NgayHetHan='$ngayhethanmoi' where MaDocGia ='$madocgia'";
                    if(!$mysqli->query($sql17)) echo 'Loi16: '.$mysqli->error;
                    $ngayhethanmoihtml = date("d/m/Y",strtotime($ngayhethanmoi));

                    ?>
                    <div class="divTBTKadmin">
                        <div class="thongbaosachmoi  thongbaothaydoi">
                            <div class="TBthemmoi divktimthay">
                                    <form enctype="multipart/form-data" method="POST" class="TBcontent theDGcontent">
                                        <a href="sachmuon.php"><i class="tkadminTC fas fa-times"></i></a>
                                        <h2>Đã gia thành công!</h2>
                                        <div class="Noidung">
                                            <p>Mã độc gia: <?php echo $madocgia;?></p>
                                            <p>Họ tên: <?php echo $tendocgia;?></p>
                                            <p>Ngày hết hạn: <?php echo $ngayhethanmoihtml;?></p>
                                            <input type="hidden" name="madocgia" value=" <?php echo $madocgia;?>">
                                        </div>
                                        <div class="btn closephieumuonsach">
                                            <button name="giahanthanhcong" class="tkadminTC">OK</button>
                                        </div> 
                                    </form>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                $result2=$mysqli->query($sql2);
                if($result2->num_rows==0){
                    ?>
                    <div class="divTBTKadmin  thongbaobitrung">
                        <div class="thongbaosachmoi">
                            <div class="TBthemmoi divktimthay">
                                <div class="TBcontent theDGcontent">
                                    <a href="sachmuon.php"><i class="bitrung fas fa-times"></i></a>
                                    <h2>Không tìm thấy độc giả! <?php echo $madocgia;?></h2>
                                    
                                    <div class="btn" style="justify-content: center;">
                                        <button><a href="sachmuon.php">OK</a></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                } else {                   
                        $ngayhientai=date("Y-m-d");
                        $sql39="SELECT NgayHetHan from docgia where MaDocGia='$madocgia'";
                        if(!$result39=$mysqli->query($sql39)) echo 'Loi78: '.$mysqli->error;
                        $abc=$result39->fetch_assoc();
                        $ngayhethan=$abc["NgayHetHan"];
                        
                    if(strtotime($ngayhientai)>strtotime($ngayhethan)){
                        $sql16="UPDATE docgia set DaHetHan=1 where MaDocGia='$madocgia'";
                        if(!$mysqli->query($sql16)) echo 'Loi16: '.$mysqli->error;
                        ?>
                            <div class="thongbaosachmoi  divphieuthu">
                                <div class="TBthemmoi divktimthay">
                                    <div class="TBcontent theDGcontent">
                                        <h2>Thẻ độc giả đã hết hạn!</h2>
                                        
                                        <form enctype="multipart/form-data" method="POST">
                                            <input type="hidden" name="madocgia" value="<?php echo $madocgia;?>">
                                            <div class="btn closephieumuonsach" style="justify-content: space-between; display:flex;">
                                                <button type="submit" name="xacnhan">Gia hạn</button>
                                                <button><a href="sachmuon.php">OK</a></button>
                                            </div> 
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <?php
                        
                    }
                    $row=$result2->fetch_assoc();
                    if(isset($_POST['btnTimDGMS'])){
                        $hanthe=$row["NgayHetHan"];
                    }else{
                        $hanthe=$row["NgayHetHan"];
                        $tendocgia = $row["HoTen"];
                    }
                    $hanthehtml = date("d/m/Y",strtotime($hanthe));
                    $sql="SELECT TenDauSach,NgayMuon, NgayPhaiTra,sach.MaSach,cuonsach.MaCuonSach, NgayTra
                        FROM docgia inner join phieumuontra on docgia.MaDocGia=phieumuontra.MaDocGia
                                    inner join cuonsach on cuonsach.MaCuonSach=phieumuontra.MaCuonSach
                                    inner join sach on sach.MaSach=cuonsach.MaSach
                                    inner join dausach on dausach.MaDauSach=sach.MaDauSach
                        WHERE docgia.MaDocGia=$madocgia ";
                    $result=$mysqli->query($sql);
                    $result1=$mysqli->query($sql);
                    if($result1->num_rows>0){
                        while($row=$result1->fetch_assoc()){
                            $ngayht=date("Y-m-d");
                            $ngayphaitra=$row["NgayPhaiTra"];
                            $ngaytra=$row["NgayTra"];
                            if(($ngaytra==0)&&(strtotime($ngayht)>strtotime($ngayphaitra))){
                                $sosachmuonquahan++;} 
                        }
                    }
                    ?>
                <div class="DGtrasach">
                    <div class="DGmuonsach divContent">
                        <h2>Thông tin độc giả</h2>
                        <div class="container">
                            <p>Mã độc giả: <strong id="madocgia"><?php echo $madocgia;?></strong> </p>
                            <p>Họ và tên: <?php echo $tendocgia;?></p>
                            <p>Hạn Thẻ: <?php echo $hanthehtml;?></p>
                            <p>Số lượng sách mượn quá hạn:<?php echo $sosachmuonquahan;?></p>
                        </div>
                    </div>
                    <?php
                    // require("jssachmuon.php");
                ?>
                    <div class="DSsachDGM divContent">
                        <h2>Danh sách sách độc giả đang mượn</h2>
                        <table id="resultSearchBook" class="bookLoan">
                            <thead id="BookTitle">
                                <th>STT</th>
                                <th>Mã Cuốn Sách</th>
                                <th>Tên sách</th>
                                <th>Ngày mượn</th>
                                <th>Ngày phải trả</th>
                            </thead>
                            <tbody class="danhsachsachchuanbichomuon">
                                <?php
                                if($result->num_rows>0){
                                $index = 0;
                                    while($row=$result->fetch_assoc()){
                                        $ngaytra=$row["NgayTra"];
                                        if($ngaytra==0){
                                            $index++;
                                            $tensach=$row["TenDauSach"];
                                            $ngaymuon=$row["NgayMuon"];
                                            $ngayphaitra=$row["NgayPhaiTra"];
                                            $macuonsach=$row["MaCuonSach"];
                                            $ngaymuonhtml = date("d/m/Y",strtotime($ngaymuon));
                                            $ngayphaitrahtml = date("d/m/Y",strtotime($ngayphaitra));
                                        ?>
                                        <tr>
                                            <td><?php echo $index;?></td>
                                            <td><?php echo $macuonsach;?></td>
                                            <td><?php echo $tensach;?></td>
                                            <td><?php echo $ngaymuonhtml;?></td>
                                            <td><?php echo $ngayphaitrahtml;?></td>
                                        </tr>
                                        <?php   
                                        }
                                    } }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                            <?php
            }}
            ?>
            

        <div class="divContent trasachMuon">
            <h2>Tìm sách mượn</h2>
            <form class="formSearch input" enctype="multipart/form-data"  method="POST">
                <div class="inputFirst">
                    <select class="sel" name="thongtin" id="kind" value = "selected">
                        <option  value="tensach">Tiêu đề</option>
                        <option value="tacgia">Tác giả</option>
                        <option value="theloai">Thể loại</option>
                        <option value="nhaxb">Nhà xuất bản</option>
                        <option value="namxb">Năm xuất bản</option>
                        <option selected = "batky" value="batky">Bất kỳ</option>
                     </select>
                </div>
                <div class="inputSecond">
                    <input type="text" name="querytext" placeholder="Nhập từ khóa cần tra cứu">
                    <input type="hidden" name="madocgia" id="hidden" value="0">
                </div>
                <div class="iconSearch">
                    <button type="submit" name="btnTimSachMuon">
                        <i class="fas fa-search"></i>
                    </button>
                </div>

                <?php
                    require("jssachmuon.php");
                ?>
            </form>
            <?php
            $mysqli->close();
        ?>
            <?php
                error_reporting(E_ERROR);
                require('dbconnect.php');
                require('XoaUnicodePHP.php');
                    if($_SERVER [ "REQUEST_METHOD" ] == "POST" ){
                        $name= $_POST["thongtin"];
                        $tutracuu= $_POST["querytext"];
                        $tutracuu1=mb_strtolower($tutracuu,'utf8');
                        $tutracuu2=vn_to_str($tutracuu1);
                        $sotutracuu=str_word_count($tutracuu2);
                    
                        //Khởi tạo mảng lưu trữ các mã đầu sách thỏa điều kiện tìm kiếm
                        

                        if ($name=='tacgia'){
                            $mangds[0]=0;
                            $chiso=0;
                            $check=0;
                            $sqltc="SELECT distinct TenTacGia,MaSach FROM tacgia inner join ct_tacgia on tacgia.MaTacGia=ct_tacgia.MaTacGia
                                                                                 inner join sach on sach.MaDauSach=ct_tacgia.MaDauSach";
                            if(!$resulttc=$mysqli->query($sqltc)) echo 'Loitracuu: '.$mysqli->error;
                            $resulttc1=$mysqli->query($sqltc);
                            if($resulttc->num_rows>0){
                                while($kqtc=$resulttc->fetch_assoc()){
                                    $giatri=$kqtc["TenTacGia"];                                        
                                    $giatri1=mb_strtolower($giatri,'utf8');  
                                    $giatri2=vn_to_str($giatri1);

                                                                                 
                                    if(strcmp($tutracuu1,$giatri1)==0){
                                        $bien=$kqtc["MaSach"];
                                        $bien1=array_count_values($mangds);
                                        $bien2=$bien1["$bien"];
                                        if($bien2==0){
                                        $mangds[$chiso]=$kqtc["MaSach"];
                                        $chiso++;
                                        $check++;}
                                    }}
                                while($kqtc=$resulttc1->fetch_assoc()){
                                    $giatri=$kqtc["TenTacGia"];                                        
                                    $giatri1=mb_strtolower($giatri,'utf8');  
                                    $giatri2=vn_to_str($giatri1);

                                    if((strcmp($tutracuu2,$giatri2)==0)&&($check==0)){
                                        $bien=$kqtc["MaSach"];
                                        $bien1=array_count_values($mangds);
                                        $bien2=$bien1["$bien"];
                                        if($bien2==0){
                                        $mangds[$chiso]=$kqtc["MaSach"];
                                        $chiso++;
                                        $check++;}
                                    }}
                                }
                            }
                        

                        if ($name=='tensach'){
                            $mangds[0]=0;
                            $chiso=0;
                            $check=0;
                            $sqltc="SELECT distinct TenDauSach,MaSach FROM dausach inner join sach on dausach.MaDauSach=sach.MaDauSach where sach.DaXoa=0";
                            if(!$resulttc=$mysqli->query($sqltc)) echo 'Loitracuu: '.$mysqli->error;
                            $resulttc1=$mysqli->query($sqltc);
                            if($resulttc->num_rows>0){
                                while($kqtc=$resulttc->fetch_assoc()){
                                    $giatri=$kqtc["TenDauSach"];                                        
                                    $giatri1=mb_strtolower($giatri,'utf8');  
                                    $giatri2=vn_to_str($giatri1);
                                    
                                                                                 
                                    if(strcmp($tutracuu1,$giatri1)==0){
                                        $mangds[$chiso]=$kqtc["MaSach"];
                                        $chiso++;
                                        $check++; 
                                      
                                    }}
                                while($kqtc=$resulttc1->fetch_assoc()){
                                    $giatri=$kqtc["TenDauSach"];                                        
                                    $giatri1=mb_strtolower($giatri,'utf8');  
                                    $giatri2=vn_to_str($giatri1);

                                    if((strcmp($tutracuu2,$giatri2)==0)&&($check==0)){
                                        $mangds[$chiso]=$kqtc["MaSach"];
                                        $chiso++;
                                       
                                    }}
                                }
                            }

                        if($name=='theloai'){
                            $mangds[0]=0;
                            $chiso=0;
                            $sqltc="SELECT TenTheLoai,MaSach FROM dausach inner join theloai on theloai.MaTheLoai=dausach.MaTheLoai
                                                                          inner join sach on sach.MaDauSach=dausach.MaDauSach";
                            if(!$resulttc=$mysqli->query($sqltc)) echo 'Loitracuu: '.$mysqli->error;
                            if($resulttc->num_rows>0){
                                while($kqtc=$resulttc->fetch_assoc()){
                                    $giatri=$kqtc["TenTheLoai"];
                                    $giatri1=strtolower($giatri);
                            
                                    if(strcmp($giatri1,$tutracuu1)==0) {
                                    $mangds[$chiso]=$kqtc["MaSach"];
                                    $chiso++;
                                    
                        }}}}

                        if($name=='nhaxb'){
                            $mangds[0]=0;
                            $chiso=0;
                            $check=0;
                            $sqltc="SELECT NhaXuatBan,MaSach FROM sach inner join dausach on dausach.MaDauSach=sach.MaDauSach where sach.DaXoa=0";
                            if(!$resulttc=$mysqli->query($sqltc)) echo 'Loitracuu: '.$mysqli->error;
                            $resulttc1=$mysqli->query($sqltc);
                            if($resulttc->num_rows>0){
                                while($kqtc=$resulttc->fetch_assoc()){
                                    $giatri=$kqtc["NhaXuatBan"];                                        
                                    $giatri1=mb_strtolower($giatri,'utf8');  
                                    $giatri2=vn_to_str($giatri1);

                                                                                 
                                    if(strcmp($tutracuu1,$giatri1)==0){
                                        $mangds[$chiso]=$kqtc["MaSach"];
                                        $chiso++;
                                        $check++; 
                                    }}
                                while($kqtc=$resulttc1->fetch_assoc()){
                                    $giatri=$kqtc["NhaXuatBan"];                                        
                                    $giatri1=mb_strtolower($giatri,'utf8');  
                                    $giatri2=vn_to_str($giatri1);

                                    if((strcmp($tutracuu2,$giatri2)==0)&&($check==0)){
                                        $mangds[$chiso]=$kqtc["MaSach"];
                                        $chiso++;
                                    }}
                                }
                            }
                        
                        if($name=='namxb'){
                            $mangds[0]=0;
                            $chiso=0;
                            $sql="SELECT MaSach,NamXuatBan
                                FROM sach
                                WHERE NamXuatBan='$tutracuu' and sach.DaXoa=0";
                            if(!$result12=$mysqli->query($sql)) echo 'Loi12: '.$mysqli->error;
                            if($result12->num_rows>0){
                                while($kq12=$result12->fetch_assoc()){
                                    $mangds[$chiso]=$kq12["MaSach"];
                                    $chiso++;
                                }
                            }
                        }
                        if($name=='batky'){
                            $mangds[0]=0;
                            $chiso=0;
                            $sqltc="SELECT TenDauSach,TenTheLoai,NhaXuatBan,NamXuatBan,TenTacGia,MaSach
                                    FROM dausach inner join sach on dausach.MaDauSach=sach.MaDauSach
                                                 inner join ct_tacgia on ct_tacgia.MaDauSach=dausach.MaDauSach
                                                 inner join tacgia on tacgia.MaTacGia=ct_tacgia.MaTacGia
                                                 inner join theloai on theloai.MaTheLoai=dausach.MaTheLoai
                                    WHERE sach.DaXoa=0";
                            if(!$resulttc=$mysqli->query($sqltc)) echo 'Loitracuu: '.$mysqli->error;
                            if($resulttc->num_rows>0){
                                while($kqtc=$resulttc->fetch_assoc()){                                 
                                    $giatriten=$kqtc["TenDauSach"];
                                    $giatriten1=mb_strtolower($giatriten,'utf8');
                                    $giatriten2=vn_to_str($giatriten1);

                                    $giatritl=$kqtc["TenTheLoai"];
                                    $giatritl1=strtolower($giatritl);

                                    $giatrinamxb=$kqtc["NamXuatBan"];

                                    $giatrinhaxb=$kqtc["NhaXuatBan"];
                                    $giatrinhaxb1=mb_strtolower($giatrinhaxb,'utf8');
                                    $giatrinhaxb2=vn_to_str($giatrinhaxb1);
                                    
                                    $giatritg=$kqtc["TenTacGia"];
                                    $giatritg1=mb_strtolower($giatritg,'utf8');
                                    $giatritg2=vn_to_str($giatritg1);

                                    if(strlen($tutracuu2)<7){
                                        $check=0;
                                        if(!strcmp($tutracuu2,$giatriten2)){ 
                                            $bien=$kqtc["MaSach"];
                                            $bien1=array_count_values($mangds);
                                            $bien2=$bien1["$bien"];
                                            if($bien2==0){
                                            $mangds[$chiso]=$kqtc["MaSach"];
                                            $chiso++;
                                            $check++;}
                                            }
                                        if((strcmp($tutracuu1,$giatritl1)==0)&&($check==0)){
                                            $bien=$kqtc["MaSach"];
                                            $bien1=array_count_values($mangds);
                                            $bien2=$bien1["$bien"];
                                            if($bien2==0){
                                            $mangds[$chiso]=$kqtc["MaSach"];
                                            $chiso++;
                                            $check++;}
                                        }
                                        if((strcmp($tutracuu,$giatrinamxb)==0)&&($check==0)){
                                            $bien=$kqtc["MaSach"];
                                            $bien1=array_count_values($mangds);
                                            $bien2=$bien1["$bien"];
                                            if($bien2==0){
                                            $mangds[$chiso]=$kqtc["MaSach"];
                                            $chiso++;
                                            $check++;}
                                        }
                                        if((strcmp($tutracuu2,$giatrinhaxb2)==0)&&($check==0)){
                                            $bien=$kqtc["MaSach"];
                                            $bien1=array_count_values($mangds);
                                            $bien2=$bien1["$bien"];
                                            if($bien2==0){
                                            $mangds[$chiso]=$kqtc["MaSach"];
                                            $chiso++;
                                            $check++;}
                                        }
                                        if((strcmp($tutracuu2,$giatritg2)==0)&&($check==0)){
                                            $bien=$kqtc["MaSach"];
                                            $bien1=array_count_values($mangds);
                                            $bien2=$bien1["$bien"];
                                            if($bien2==0){
                                            $mangds[$chiso]=$kqtc["MaSach"];
                                            $chiso++;
                                            $check++;}
                                        }
                                        }
                                    else{
                                        $check=0;
                                        $pos=strpos($giatriten2,$tutracuu2);
                                        if(($pos===false)){}
                                        else {
                                            $bien=$kqtc["MaSach"];
                                            $bien1=array_count_values($mangds);
                                            $bien2=$bien1["$bien"];
                                            if($bien2==0){
                                            $mangds[$chiso]=$kqtc["MaSach"];
                                            $chiso++;
                                            $check++;}
                                        }

                                        $pos=strpos($giatritg2,$tutracuu2);
                                        if(($pos===false)){}
                                        else {if($check==0){
                                            $bien=$kqtc["MaSach"];
                                            $bien1=array_count_values($mangds);
                                            $bien2=$bien1["$bien"];
                                            if($bien2==0){
                                            $mangds[$chiso]=$kqtc["MaSach"];
                                            $chiso++;
                                            $check++;}
                                        }
                                        
                                        $pos=strpos($giatrinhaxb2,$tutracuu2);
                                        if(($pos===false)){}
                                        else {if($check==0){
                                            $bien=$kqtc["MaSach"];
                                            $bien1=array_count_values($mangds);
                                            $bien2=$bien1["$bien"];
                                            if($bien2==0){
                                            $mangds[$chiso]=$kqtc["MaSach"];
                                            $chiso++;
                                            $check++;}
                                        }
                                    }

                            }}

                        }}}

                        
                        ?>
                        <div class="result">
                            <h2>Kết quả</h2>
                            <table id="resultSearchBook">
                                <thead>
                                    <th>STT</th>
                                    <th>Mã sách</th>
                                    <th>Tên Sách</th>
                                    <th>Tác giả</th>
                                    <th>Thể Loại</th>
                                    <th>Nhà Xuất Bản</th>
                                    <th>Năm Xuất Bản</th>
                                    <th>Tình trạng</th>
                                    <th>Mượn sách</th>
                                </thead>
                                <tbody id="TimSachMuon">
                                    <?php
                                        $index=0;
                                        if($mangds['0']!=0){
                                        foreach($mangds as $masachtracuu){
                                            $sql="SELECT sach.MaSach as MS, TenDauSach,TenTheLoai,NhaXuatBan,NamXuatBan, dausach.MaDauSach as MDS
                                            FROM sach inner join dausach on sach.MaDauSach=dausach.MaDauSach
                                                        inner join theloai on theloai.MaTheLoai=dausach.MaTheLoai
                                            WHERE sach.MaSach='$masachtracuu'";
                                        $result=$mysqli->query($sql);                                                                           
                                            while($row=$result->fetch_assoc()){
                                                $index++;
                                                $mads=$row["MDS"];
                                                $tensach=$row["TenDauSach"];
                                                $theloai=$row["TenTheLoai"];
                                                $masach=$row["MS"];
                                                $namxb=$row["NamXuatBan"];
                                                $nhaxb=$row["NhaXuatBan"];
                                                $sql1="SELECT * 
                                                    FROM cuonsach inner join sach on cuonsach.MaSach=sach.MaSach
                                                    WHERE TinhTrang='0' and sach.MaSach='$masach'";
                                                $x=$mysqli->query($sql1);
                                                if($x->num_rows>0){
                                                    $tinhtrang='Còn';
                                                } 
                                                else {$tinhtrang='Hết';
                                                        $macuonsach='NULL';}
                                                ?>
                                                <tr>
                                                    <td><?php echo $index; ?></td>
                                                    <td><?php echo $masach ;?></td>
                                                    <td><?php echo $tensach; ?></td>
                                                    <td>
                                                    <?php
                                                        $tg = "SELECT TenTacGia FROM tacgia INNER JOIN ct_tacgia ON ct_tacgia.MaTacGia=tacgia.MaTacGia WHERE ct_tacgia.MaDauSach=$mads";
                                                            $res_tg = $mysqli->query($tg);
                                                            if(($res_tg->num_rows) > 0){
                                                                while($row_tg = $res_tg->fetch_assoc()){
                                                                    ?>
                                                                    <p><?php echo $row_tg["TenTacGia"]; ?></p>
                                                                    <?php
                                                                }
                                                            }
                                                    ?>
                                                    </td>
                                                    <td><?php echo $theloai; ?></td>
                                                    <td><?php echo $nhaxb; ?></td>
                                                    <td><?php echo $namxb; ?></td>
                                                    <td><?php echo $tinhtrang; ?></td>
                                                    <td>
                                                        <?php
                                                            if($tinhtrang == 'Hết'){
                                                                // echo $tinhtrang;
                                                            }
                                                            else{
                                                                ?>
                                                                <form class="btnMuonSach" enctype="multipart/form-data" method="POST">
                                                                    <input type="hidden" name="maSachhidden" class="maSachhidden" value="<?php echo $masach; ?>">
                                                                    <input type="hidden" name="madocgia" class="maDGhidden">
                                                                    <button class="btnhidden" style="background-color: inherit; color:black;" type="submit" name="lapphieuMS">Mượn sách</button>
                                                                </form>
                                                                <?php
                                                            }
                                                        ?>
                                                    </td>
                                                </tr>
                                                <?php
                                            }}
                                        }
                                        ?>
                                        <h3>Tổng số sách: <span><?php echo $index ?></span></h3>
                                        <?php require("jsmaDGhidden.php");?>
                                </tbody>
                            </table>
                        </div>
                        <?php
                    }
                $mysqli->close(); 
            ?>
        </div>
    </div>
    <?php

    require('dbconnect.php');
    if(isset($_POST["lapphieuMS"])){
        $madocgia= $_POST["madocgia"];
        //echo $madocgia;
        $masach= $_POST["maSachhidden"]; 
        //echo $masach;
        $ngaymuon=date("Y-m-d");
        $sql="SELECT HoTen,NgayHetHan FROM docgia WHERE MaDocGia='$madocgia'";
        if(!$result=$mysqli->query($sql)) echo 'Loi1: '.$mysqli->error;
        $row=$result->fetch_assoc();
        $tendocgia=$row["HoTen"];
        $ngayhethan=$row["NgayHetHan"];
        $sosachmuonquahan=0;
        $sosachmuon=0;

        $sql="SELECT NgayPhaiTra,NgayTra
              FROM docgia inner join phieumuontra on docgia.MaDocGia=phieumuontra.MaDocGia
              WHERE docgia.MaDocGia=$madocgia";
        $result1=$mysqli->query($sql);
        if($result1->num_rows>0){
            while($row=$result1->fetch_assoc()){
                if($ngaytra==0) $sosachmuon++;
                $ngayht=date("Y-m-d");
                $ngayphaitra=$row["NgayPhaiTra"];
                $ngaytra=$row["NgayTra"];
                if(($ngaytra==0)&&(strtotime($ngayht)>strtotime($ngayphaitra))){
                    $sosachmuonquahan++;} 
            }
        }
        $check=0;
        $sql5="SELECT GiaTri from thamso where TenThamSo='SoSachMuonToiDa'";
        if(!$result=$mysqli->query($sql5)) echo 'Loi5: '.$mysqli->error;
        $row=$result->fetch_assoc();
        $sosachqd=$row["GiaTri"];
        if($sosachqd<=$sosachmuon) $check=1;

        $sql="SELECT TenDauSach,TenTheLoai,TenTacGia
            FROM sach inner join dausach on sach.MaDauSach=dausach.MaDauSach
                        inner join ct_tacgia on ct_tacgia.MaDauSach=dausach.MaDauSach
                        inner join tacgia on tacgia.MaTacGia=ct_tacgia.MaTacGia
                        inner join theloai on theloai.MaTheLoai=dausach.MaTheLoai
            WHERE sach.MaSach='$masach'";
        if(!$result=$mysqli->query($sql)) echo 'Loi2: '.$mysqli->error;
        $row=$result->fetch_assoc();
        $tensach=$row["TenDauSach"];
        $theloai=$row["TenTheLoai"];
        $tacgia=$row["TenTacGia"];
        
        $sql2="SELECT MaCuonSach from cuonsach inner join sach on cuonsach.MaSach=sach.MaSach where sach.MaSach='$masach' and TinhTrang='0' LIMIT 1";
        if(!$result2=$mysqli->query($sql2)) echo 'Loithu: '.$mysqli->error;
        $row=$result2->fetch_assoc();
        $macuonsach=$row["MaCuonSach"];
        
        $sql3="SELECT GiaTri from thamso where TenThamSo='SoNgayMuonToiDa'";
        $result3=$mysqli->query($sql3);
        $row=$result3->fetch_assoc();
        $songaymuonmax=$row["GiaTri"];
        
        $a=mktime(0,0,0,date("m"),date("d") +$songaymuonmax,date("Y"));
        $ngayphaitra=date("Y-m-d",$a);
        if(strtotime($ngayhethan)<strtotime($ngayphaitra)) $ngayphaitra=$ngayhethan;
        ?>

            <?php
                if($check == 1){
                    ?>
                    <div class="divTBTKadmin  thongbaocosachmuonquahan">
                        <div class="thongbaosachmoi">
                            <div class="TBthemmoi divktimthay">
                                    <div class="TBcontent theDGcontent">
                                        <i class="cosachmuonvuotquaqd fas fa-times"></i>
                                        <h1>Không thể mượn sách</h1>
                                        <h3>Số sách mượn đã vượt quá quy định!</h3>
                                        <div class="btn" style="display: flex; justify-content: center;">
                                            <button class="cosachmuonvuotquaqd">OK</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <script>
                            const cosachmuonvuotquaqd = document.querySelectorAll(".cosachmuonvuotquaqd");
                            for(let i = 0; i < cosachmuonvuotquaqd.length; i++){
                                cosachmuonvuotquaqd[i].addEventListener("click", function(){
                                    document.querySelector(".thongbaocosachmuonquahan").classList.add("action");
                                });
                            }

                        </script>
                    <?php
                }else{
                    if($sosachmuonquahan > 0){
                        ?>
                        <div class="divTBTKadmin  thongbaocosachmuonquahan">
                            <div class="thongbaosachmoi">
                                <div class="TBthemmoi divktimthay">
                                    <div class="TBcontent theDGcontent">
                                        <i class="cosachmuonquahan fas fa-times"></i>
                                        <h1>Không thể mượn sách</h1>
                                        <h3>Có sách mượn quá hạn chưa trả!</h3>
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
                                })
                            }
                        </script>
                        <?php
                    }else{
                         $ngaymuonhtml = date("d/m/Y",strtotime($ngaymuon));

                        ?>
                        <div class="thongbaosachmoi divphieumuon">
                            <div class="TBthemmoi">
                                <div class="TBcontent theDGcontent">
                                    <h1>Mượn sách thành công!</h1>
                                    <h2>Phiếu mượn sách</h2>
                                    <div class="lapphieumuonsach">
                                        <div class="headerphieuMS">
                                            <p>Họ tên độc giả:      <?php echo $tendocgia;?></p>
                                            <p>Ngày mượn:       <?php echo $ngaymuonhtml;?></p>
                                        </div>
                                        <div>
                                            <p>Mã sách:         <?php echo $macuonsach;?> </p>
                                            <p>Tên sách:        <?php echo $tensach;?></p>
                                            <p>Thể loại:        <?php echo $theloai;?></p>
                                            <p>Tác giả:         <?php echo $tacgia;?></p>
                                        </div>
                                        </div>
                                        <div class="btn closephieumuonsach" style="justify-content: center;">
                                            <form enctype="multipart/form-data" method="POST">
                                                <input type="hidden" name="madocgia" class="maDGhidden" value="<?php echo $madocgia;?>">
                                                    <button class="btnhidden" type="submit" name="tatTBlapPM">OK</button>
                                            </form>
                                            <?php require("jssachmuon.php");?>
                                        </div> 
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php                
                        $sql1="INSERT INTO phieumuontra(MaDocGia,MaCuonSach,NgayMuon,NgayPhaiTra) VALUES ('$madocgia','$macuonsach','$ngaymuon','$ngayphaitra')";
                        if(!$mysqli->query($sql1)) echo 'Loi56: '.$mysqli->error;
                        
                        $sql4="UPDATE cuonsach SET TinhTrang=1 WHERE MaCuonSach='$macuonsach'";
                        if(!$mysqli->query($sql4)) echo 'Loi4: '.$mysqli->error;
                    }
                }
            ?>

                        
    <?php
        
    }
    $mysqli->close();
?>
    <footer class="footerOP">
        <h4>
            Một sản phẩm của nhóm sinh viên trường Đại học Công nghệ thông tin
            <span>
                 ©
            </span>
        </h4>
    </footer>
</body>
</html>
