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
    <script src="jsbaocao.js" defer></script>
    <title>Tra cứu sách</title>
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
                    <li class="select backgd"><a href="tracuusach.php" class="tracuusach">Tra cứu sách</a></li>
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
    <h1 style="margin-top: 80px; text-align:center; font-size:50px;">Tra cứu sách</h1>

    <div class="search main">
        
        <div class="inputContent divContent">
            <h2>Tra cứu sách</h2>

            <div class="inputNav ">
            <form class="formSearch input" action method="POST">
                        <div class="inputFirst">
                            <select class="sel" name="thongtin" id="kind" value="selected">
                                <option  <?php if ( $_SERVER [ "REQUEST_METHOD" ] == "POST" ) if($_POST["thongtin"] == "batky") echo "selected";?> value="batky">Bất kỳ</option>
                                <option <?php if ( $_SERVER [ "REQUEST_METHOD" ] == "POST" ) if($_POST["thongtin"] == "tensach") echo "selected";?> value="tensach">Tiêu đề</option>
                                <option  <?php if ( $_SERVER [ "REQUEST_METHOD" ] == "POST" ) if($_POST["thongtin"] == "tacgia") echo "selected";?> value="tacgia">Tác giả</option>
                                <option  <?php if ( $_SERVER [ "REQUEST_METHOD" ] == "POST" ) if($_POST["thongtin"] == "theloai") echo "selected";?> value="theloai">Thể loại</option>
                                <option  <?php if ( $_SERVER [ "REQUEST_METHOD" ] == "POST" ) if($_POST["thongtin"] == "nhaxb") echo "selected";?> value="nhaxb">Nhà xuất bản</option>
                                <option  <?php if ( $_SERVER [ "REQUEST_METHOD" ] == "POST" ) if($_POST["thongtin"] == "namxb") echo "selected";?> value="namxb">Năm xuất bản</option>
                                <option <?php if ( $_SERVER [ "REQUEST_METHOD" ] == "POST" ) if($_POST["thongtin"] == "tinhtrang") echo "selected";?> value="tinhtrang">Tình trạng</option>
                            </select>
                        </div>
                        <div class="inputSecond">
                            <input type="text" name="querytext" placeholder="Nhập từ khóa cần tra cứu" value="<?php if ( $_SERVER [ "REQUEST_METHOD" ] == "POST" ) echo $_POST["querytext"];?>">
                        </div>
                        <div class="iconSearch">
                            <button type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </form>
                        
                        
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

                                    $index = 0;
                                    ?>
                                    <div class="result">
                                        <h2>Kết quả</h2>
                                        <table id="resultSearchBook">
                                            <thead>
                                                <th>STT</th>
                                                <th>Mã sách</th>
                                                <th>Tên đầu sách</th>
                                                <th>Tác giả</th>
                                                <th>Thể loại</th>
                                                <th>Nhà xuất bản</th>
                                                <th>Năm xuất bản</th>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    //hien thi nhung sach con sach chua muon
                                                    if($mangds['0']!=0){
                                                        foreach($mangds as $masachtracuu){
                                                            $sql="SELECT sach.MaSach, TenDauSach,TenTheLoai,NhaXuatBan,NamXuatBan, dausach.MaDauSach
                                                            FROM sach inner join dausach on sach.MaDauSach=dausach.MaDauSach
                                                                        inner join theloai on theloai.MaTheLoai=dausach.MaTheLoai
                                                            WHERE sach.MaSach='$masachtracuu'";
                                                        $result=$mysqli->query($sql);                                                                           
                                                            while($row=$result->fetch_assoc()){
                                                                $index++;
                                                            ?>
                                                            <tr>
                                                                <td class="stt"><?php echo $index; ?></td>
                                                                <td class="masach"><?php echo $row["MaSach"]; ?></td>
                                                                <td class="tensach"><?php echo $row["TenDauSach"]; ?></td>
                                                                <td class="tacgia">
                                                                <?php
                                                                    $mads = $row["MaDauSach"];
                                                                    $tg = "SELECT TenTacGia FROM tacgia INNER JOIN ct_tacgia ON ct_tacgia.MaTacGia=tacgia.MaTacGia WHERE ct_tacgia.MaDauSach=$mads";
                                                                        $res_tg = mysqli_query($mysqli, $tg);
                                                                        if(mysqli_num_rows($res_tg) > 0){
                                                                            while($row_tg = mysqli_fetch_assoc($res_tg)){
                                                                                ?>
                                                                                <p><?php echo $row_tg["TenTacGia"]; ?></p>
                                                                                <?php
                                                                            }
                                                                        }

                                                                    ?>
                                                                </td>
                                                                <td class="theloai"><?php echo $row["TenTheLoai"]; ?></td>
                                                                <td class="nhaxuatban"><?php echo $row["NhaXuatBan"]; ?></td>
                                                                <td class="namxuatban"><?php echo $row["NamXuatBan"]; ?></td>
                                                            </tr>
                                                            <?php 
                                                        }

                                                    }}
                                                    ?>
                                                    <h3>Tổng số sách: <span><?php echo $index ?></span></h3>
                                            </tbody>
                                        </table>
                                    </div
                                       <?php
                                
                                }
                                    mysqli_close($mysqli);
                            ?>
                <p></p>
                <div class="sachmoinhap">
                    <h2>Danh sách 10 sách mới nhập</h2>
                        <table id="resultSearchBook">
                            <thead>
                                <th>STT</th>
                                <th>Mã sách</th>
                                <th>Tên đầu sách</th>
                                <th>Tác giả</th>
                                <th>Thể loại</th>
                                <th>Nhà xuất bản</th>
                                <th>Năm xuất bản</th>
                            </thead>
                            <tbody>
                                    <?php

                                        require ('dbconnect.php');
                                        $sql1="SELECT Max(MaSach) as ms FROM sach ";
                                        $result=$mysqli->query($sql1);
                                        $row=$result->fetch_assoc();
                                        $maxms=$row["ms"];
                                        if($maxms<10){
                                            $minms='1';
                                        }
                                        else{$minms=$maxms - 9;}

                                        //Kiem tra xem co sach nao đã xóa không?
                                        $sql10="SELECT MaSach,DaXoa FROM sach where MaSach>=$minms";
                                        if(!$kq=$mysqli->query($sql10)) echo 'Loi10: '.$mysqli->error;
                                        if($kq->num_rows>0){
                                            while($kq1=$kq->fetch_assoc()){
                                                $ktxoa=$kq1["DaXoa"];
                                                $masach=$kq1["MaSach"];
                                                if($ktxoa==1){
                                                    $masach=0;                                                    
                                                    while(($minms>0)&&($masach==0)){                                     
                                                        $minms--;
                                                        $sql20="SELECT MaSach,DaXoa from sach where MaSach='$minms'";
                                                        if(!$result20=$mysqli->query($sql20)) echo 'Loi20: '.$mysqli->error;
                                                        $kq20=$result20->fetch_assoc();
                                                        $ktxoakhac=$kq20["DaXoa"];
                                                        $mskhac=$kq20["MaSach"];
                                                        if($ktxoakhac==0) $masach=$mskhac; 
                                                    }
                                                } 
                                            }
                                        }

                                        $sql="SELECT MaSach from sach where MaSach>=$minms and DaXoa=0";
                                        $result=$mysqli->query($sql);
                                        $index = 0;
                                        if($result->num_rows>0){
                                            while($row=$result->fetch_assoc()){
                                                $masach=$row["MaSach"];
                                                $sql2="SELECT dausach.MaDauSach,TenDauSach,TenTacGia,TenTheLoai,NhaXuatBan,NamXuatBan
                                                    FROM sach inner join dausach on sach.MaDauSach=dausach.MaDauSach
                                                                inner join ct_tacgia on ct_tacgia.MaDauSach=dausach.MaDauSach
                                                                inner join tacgia on tacgia.MaTacGia=ct_tacgia.MaTacGia
                                                                inner join theloai on dausach.MaTheLoai=theloai.MaTheLoai
                                                    WHERE MaSach='$masach'";
                                                $result2=$mysqli->query($sql2);
                                                $q=$result2->fetch_assoc();
                                                $tensach=$q["TenDauSach"];
                                                $tacgia=$q["TenTacGia"];
                                                $theloai=$q["TenTheLoai"];
                                                $nhaxuatban=$q["NhaXuatBan"];
                                                $namxuatban=$q["NamXuatBan"];
                                                $index ++;
                                                    ?>
                                                <tr>
                                                    <td class="stt"><?php echo $index; ?></td>
                                                    <td class="masach"><?php echo $masach; ?></td>
                                                    <td class="tensach"><?php echo $tensach; ?></td>
                                                    <td class="tacgia">
                                                    <?php
                                                        $mads = $q["MaDauSach"];
                                                        $tg = "SELECT TenTacGia FROM tacgia INNER JOIN ct_tacgia ON ct_tacgia.MaTacGia=tacgia.MaTacGia WHERE ct_tacgia.MaDauSach=$mads";
                                                            $res_tg = $mysqli->query($tg);
                                                            if($res_tg->num_rows > 0){
                                                                while($row_tg = $res_tg->fetch_assoc()){
                                                                    ?>
                                                                    <p><?php echo $row_tg["TenTacGia"]; ?></p>
                                                                    <?php
                                                                }
                                                            }

                                                        ?>
                                                    </td>
                                                    <td class="theloai"><?php echo $theloai; ?></td>
                                                    <td class="nhaxuatban"><?php echo $nhaxuatban; ?></td>
                                                    <td class="namxuatban"><?php echo $namxuatban; ?></td>
                                                </tr>
                                                <?php
                                                }
                                            }
                                  
                                        $mysqli->close();

                                    ?>
                            </tbody>
                        </table>
                </div>

            </div>
        </div>

        <div class="loan divContent">
            <h2>Sách mượn nhiều</h2>
            <div class="Books">
                <div class="Book">
                    <div class="bookDetail">
                        <?php
                            $conn = mysqli_connect('localhost', 'root','', 'quanlythuvien')   or die ('fail');
                            $sql3="SELECT distinct sach.MaSach, TenDauSach, Count(SoPhieu), NhaXuatBan
                                    FROM phieumuontra INNER JOIN cuonsach ON phieumuontra.MaCuonSach=cuonsach.MaCuonSach
                                    INNER JOIN sach ON cuonsach.MaSach=sach.MaSach
                                    INNER JOIN dausach ON sach.MaDauSach=dausach.MaDauSach
                                    GROUP BY sach.MaSach, phieumuontra.MaCuonSach ORDER BY Count(SoPhieu) DESC limit 5";
                            $res3=mysqli_query($conn,$sql3);
                            if(mysqli_num_rows($res3)>0){
                                while($row3=mysqli_fetch_assoc($res3)){
                                    ?>
                                    <h4 class="name">
                                    <?php
                                        echo $row3["TenDauSach"];
                                    ?>
                                    </h4>
                                    <p class="nhaxb">
                                    <?php
                                        echo $row3["NhaXuatBan"];
                                    ?>
                                    </p> 
                                    <i>*****</i>
                                    <br> 
                                    <br>
                                    <?php          
                                }
                            }
                        ?>
                        <?php
                            mysqli_close($conn);
                        ?>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</body>
<footer>
        <h4>
            Một sản phẩm của nhóm sinh viên trường Đại học Công nghệ thông tin
            <span>
                 ©
            </span>
        </h4>
</footer>
</html>

