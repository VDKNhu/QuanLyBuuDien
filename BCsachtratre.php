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
    <script src="baocao.js" defer></script>
    <script src="jsbaocao.js" defer></script>
    <title>Báo cáo sách trả trễ</title>
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
                    <li class="select backgd">
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
            <h2>Lập báo cáo tình hình sách trả trễ</h2>
            <form class="formMain baocao jsform" enctype="multipart/form-data" method="POST">
                    <div class="cssbaocao">
                        <div>
                            Ngày:
                        </div>
                        <div>
                            <input type="date" value="<?php echo date("Y-m-d",strtotime('-1 day'));?>" name="datenhap" placeholder="Nhập ngày" max="<?php echo date("Y-m-d",strtotime('-1 day'));?>">
                        </div>
                    </div>
                    <div class="btn">
                            <button type="submit" class="jsbtnstt" name = "btnstt">Lập báo cáo</button>
                        </div>
                </form>
                    <?php

                        require('dbconnect.php');

                        if(isset($_POST['btnstt'])){
                            $date = $_POST["datenhap"];
                            $ngaynhap=date("d",strtotime($date));
                            $thangnhap=date("m",strtotime($date));
                            $namnhap=date("Y",strtotime($date));
                        ?>
                        <div class="formMain jsbaocao ">
                            <h2>Báo cáo thống kê tình hình sách trả trễ</h2>
                                <table id="resultSearchBook" class="baocaoTable">
                                    <tr>
                                        <td style="text-align: center;" lass="baocaoHearder">Báo cáo thống kê sách trả trễ</td>
                                    </tr>
                                    <tr>
                                        <td  style="text-align: center;" class="baocaoHearder">Ngày: 
                                            <strong> 
                                            <?php echo $ngaynhap."/".$thangnhap."/".$namnhap;?>
                                            </strong>
                                        </td>
                                    </tr>
                                </table>
                                <table id="resultSearchBook">
                                    <tr>
                                        <th>STT</th>
                                        <th>Tên đầu sách</th>
                                        <th>Ngày mượn</th>
                                        <th>Số ngày trả trễ</th>
                                    </tr>

                                    <?php
                                        $taodate=mktime(0,0,0,$thangnhap,$ngaynhap,$namnhap);
                                        $ngay=date("Y-m-d",$taodate);
                                        $ngayht=date("Y-m-d");
                                        $d=0;

                                        if(strtotime($ngayht)>strtotime($ngay)){
                                            //Kiem tra xem ngay vua nhap da lap bao cao chua, neu roi thi khong lap nua? 
                                            $sql2="SELECT * from bc_sachtratre where year(Ngay)=$namnhap and month(Ngay)=$thangnhap and day(Ngay)=$ngaynhap ";
                                            $result=$mysqli->query($sql2);
                                            if ($result->num_rows==0){
                                                $sql="SELECT MaCuonSach, SoPhieu, NgayPhaiTra, NgayMuon,NgayTra
                                                    FROM phieumuontra"; 
                                                $p=$mysqli->query($sql);
                                                if($p->num_rows>0){
                                                    while($row=$p->fetch_assoc()){
                                                        $a=$row["NgayPhaiTra"];
                                                        $b=$row["NgayTra"];
                                                        //Bao cao duoc lap theo dieu kien nhap: nhap ngay nao thi lap bao cao tinh tu ngay do ve truoc
                                                        if(((strtotime($ngay)<strtotime($b))&&(strtotime($ngay)>strtotime($a)))||($b==0)&&(strtotime($ngay)>strtotime($a))){
                                                            $date1=date_create($a);
                                                            $date2=date_create($ngay);
                                                            $diff=date_diff($date1,$date2);
                                                            $t=$diff->format('%d');
                                                            $c=$row["NgayMuon"];
                                                            $d=$row["MaCuonSach"];

                                                            $sql1="INSERT INTO bc_sachtratre(Ngay,MaCuonSach,NgayMuon,SoNgayTraTre) VALUES ('$ngay','$d','$c',$t)";
                                                            if(!$mysqli->query($sql1)) echo 'Loi: '.$mysqli->error;
                                                        }
                                                    }
                                                }
                                            } 
                                            $ind=0;
                                            
                                            $sql="SELECT MaCuonSach, Ngay, NgayMuon, SoNgayTraTre FROM bc_sachtratre where year(Ngay)=$namnhap and month(Ngay)=$thangnhap and day(Ngay)=$ngaynhap ";
                                            $result=$mysqli->query($sql);
                                            if($result->num_rows>0){
                                            while($row=$result->fetch_assoc()){
                                                $k=$row["MaCuonSach"];
                                                $date=$row["Ngay"];
                                                $c=$row["NgayMuon"];
                                                $t=$row["SoNgayTraTre"];
                                                $ind++;

                                                
                                                $sql1="SELECT TenDauSach FROM bc_sachtratre inner join cuonsach on bc_sachtratre.MaCuonSach=cuonsach.MaCuonSach
                                                                                            inner join sach on sach.MaSach=cuonsach.MaSach
                                                                                            inner join dausach on dausach.MaDauSach=sach.MaDauSach
                                                       WHERE bc_sachtratre.MaCuonSach=$k and year(Ngay)=$namnhap and month(Ngay)=$thangnhap and day(Ngay)=$ngaynhap";
                                                if(!$p=$mysqli->query($sql1)) echo 'Loi p: '.$mysqli->error;
                                                $x=$p->fetch_assoc();
                                                $tensach=$x["TenDauSach"];
                                                
                                                ?>
                                                    <tr>
                                                        <td><?php echo $ind;?></td>
                                                        <td><?php echo $tensach;?></td>
                                                        <td><?php echo $c;?></td>
                                                        <td><?php echo $t;?></td>
                                                    </tr>

                                                <?php
                                            }}else{
                                                ///////XUẤT THÔNG BÁO KHÔNG THỐNG KÊ ĐƯỢC DỮ LIỆU Ở ĐÂYY NHA
                                                ?>
                                                
                                                    <div class="divTBTKadmin  thongbaocosachmuonquahan">
                                                        <div class="thongbaosachmoi">
                                                            <div class="TBthemmoi divktimthay">
                                                                <div class="TBcontent theDGcontent">
                                                                    <i class="cosachmuonquahan fas fa-times"></i>
                                                                    <h3 style="margin: 0;" >Không có sách nào bị trả trễ trong</h3>
                                                                    <h4>ngày <?php echo $ngaynhap.'/'.$thangnhap.'/'.$namnhap;?></h4>

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
                                                
                                            }
                                        }
                                    ?>
                                </table>
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
</body>
</html>