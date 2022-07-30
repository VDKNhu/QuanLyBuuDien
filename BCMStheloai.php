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
    <title>Báo cáo mượn sach theo thể loại</title>
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
                    <li class="select  backgd">
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
    <h1 style="margin-top: 80px; text-align:center; font-size:50px;">Báo cáo</h1>
    <div class=" main">
        <div class="navbar divContent">
            <h2>Lập báo cáo mượn sách theo thể loại</h2>
            <form class="formMain baocao jsform"  enctype="multipart/form-data"  method="POST">
                        <div class="cssbaocao">
                            <div>
                                Nhập tháng năm: 
                            </div>
                            <div>
                                <input type="month" value="<?php echo date("Y-m",strtotime('-1 month'));?>" placeholder="Nhập tháng" max="<?php echo date("Y-m",strtotime('-1 month'));?>" placeholder="Nhập tháng năm" name="thangnhap"><br>
                            </div>
                        </div>
                        <div class="btn">
                            <button type="submit" class="jsbtn" name="btnmstl">Lập báo cáo</button>
                        </div>
            </form>
                    <?php

                        require('dbconnect.php');

                        if(isset($_POST['btnmstl'])){
                            $month = $_POST["thangnhap"];
                            $thang = date("m",strtotime($month));
                            $nam = date("Y",strtotime($month));
                            ?>
                            <div class="baocao jsbaocao">
                                <div class="formMain">
                                    <h2>Báo cáo tình hình mượn sách theo thể loại</h2>
                                    <table id="resultSearchBook" class="baocaoTable">
                                        <tr>
                                            <td  style="text-align: center;" class="baocaoHearder">Báo cáo tình hình mượn sách theo thể loại</td>
                                        </tr>
                                        <tr>
                                            <td style="text-align: center;" class="baocaoHearder">Tháng: 
                                                <strong><?php echo $thang."/".$nam;?></strong>
                                            </td>
                                        </tr>
                                    </table>
                                    <table id="resultSearchBook">
                                        <tr>
                                            <th>STT</th>
                                            <th>Tên thể loại</th>
                                            <th>Số lượt mượn</th>
                                            <th>Tỷ lệ</th>
                                        </tr>

                                        <?php
                                        $taodate=mktime(0,0,0,$thang,1,$nam);
                                        $date1=date("Y-m",$taodate);
                                        $dateht=date("Y-m");
                                        
                                        
                                        if(strtotime($date1)<strtotime($dateht)){
                                            $sql="SELECT count(SoPhieu) as Tong from phieumuontra
                                                  WHERE month(NgayMuon)=$thang and year(NgayMuon)=$nam";
                                                $p=$mysqli->query($sql);
                                                if($row=$p->fetch_assoc()) {$a=$row["Tong"];}

                                                if($a==0){
                                                    ////////////////THÊM THÔNG BÁO KHÔNG CÓ THỐNG KÊ Ở ĐÂY NÈ~~~~~~~~~~~~
                                                    ?>
                                                    <div class="divTBTKadmin  thongbaocosachmuonquahan">
                                                        <div class="thongbaosachmoi">
                                                            <div class="TBthemmoi divktimthay">
                                                                <div class="TBcontent theDGcontent">
                                                                    <i class="cosachmuonquahan fas fa-times"></i>
                                                                    <h3 style="margin: 0;" >Không có sách nào được mượn trong</h3>
                                                                    <h4>tháng <?php echo $thang.'/'.$nam;?></h4>

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

                                                    /////XONG T VẪN ĐỂ MẤY CÁI BIẾN CÓ GIÁ TRỊ 0 VỚI NULL ĐỂ XUẤT RA MÀN HÌNH NHA
                                                } else{
                                            //Kiem tra xem thoi gian vua nhap da lap bao cao chua? Neu roi thi khong lap nua
                                            $sql2="SELECT MaBCTHMS, TongSoLuotMuon from bc_tinhhinhmuonsach where Nam=$nam and Thang=$thang";
                                            $result=$mysqli->query($sql2);
                                            if ($result->num_rows==0){
                                                
                                                $sql1="INSERT INTO bc_tinhhinhmuonsach(Thang,Nam,TongSoLuotMuon) VALUES ('$thang','$nam',$a)";
                                                if (!$mysqli->query($sql1)) echo 'Loi: '.$mysqli->error;
                                                                                
                                                //Lay MaBCTHMS vua them
                                                $sql4="SELECT max(MaBCTHMS) as MaBC FROM bc_tinhhinhmuonsach";
                                                $p=$mysqli->query($sql4);
                                                if ($t=$p->fetch_assoc()) {$c=$t["MaBC"];}
                                        
                                                $sql2="SELECT distinct MaTheLoai, count( phieumuontra.MaCuonSach) as soluot
                                                        FROM phieumuontra inner join cuonsach on phieumuontra.MaCuonSach=cuonsach.MaCuonSach
                                                        inner join sach on sach.MaSach=cuonsach.MaSach
                                                        inner join dausach on dausach.MaDauSach=sach.MaDauSach
                                                        WHERE month(NgayMuon)=$thang and year(NgayMuon)=$nam
                                                        GROUP BY MaTheLoai";
                                                $p=$mysqli->query($sql2);
                                                    while($t=$p->fetch_assoc()){
                                                        $b=$t["soluot"];
                                                        $tyle=$b/$a;
                                                        $tyle=$tyle*100;
                                                        $tyle1=round($tyle,2);
                                                        $y=$t["MaTheLoai"];
                                                        $sql3="INSERT INTO ct_bc_tinhhinhmuonsach(MaBCTHMS,MaTheLoai,SoLuotMuon,TyLe) VALUES ($c,$y,$b,$tyle1)";
                                                        if(!$mysqli->query($sql3)) echo 'Loi: '.$mysqli->error;
                                        
                                                    }
                                            }                                                                                     
                                            else{
                                                $row=$result->fetch_assoc();
                                                $c=$row["MaBCTHMS"];
                                                $a=$row["TongSoLuotMuon"];
                                            }
                                            $index=0;
                                            $sql="SELECT TenTheLoai,SoLuotMuon,TyLe 
                                                  FROM ct_bc_tinhhinhmuonsach inner join theloai on ct_bc_tinhhinhmuonsach.MaTheLoai=theloai.MaTheLoai
                                                  WHERE  MaBCTHMS=$c";
                                            $result=$mysqli->query($sql);
                                            while($row=$result->fetch_assoc()){
                                                $tyle1=$row["TyLe"];
                                                $b=$row["SoLuotMuon"];
                                                $tentheloai=$row["TenTheLoai"];
                                                $index++;
                                                ?>
                                                        <tr>
                                                            <td><?php echo $index;?></td>
                                                            <td><?php echo $tentheloai;?></td>
                                                            <td><?php echo $b;?></td>
                                                            <td><?php echo $tyle1; ?>%</td>
                                                        </tr>
                                                <?php
                                            }
                                        }} else $a=0;
                                        ?>
                                    </table>
                                    <table id="resultSearchBook">
                                        <tr>
                                            <td>Tổng số lượt mượn: 
                                                <strong> <?php echo $a;?></strong>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                                    <?php
                        }
                        $mysqli->close();
                        
                        ?>
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
</div>
</body>
</html>