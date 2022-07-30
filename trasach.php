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
    <script src="js_trasachthutien.js" defer></script>
    <script src="jsbaocao.js" defer></script>
    <title>Trả sách</title>
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
                    <li class="select  backgd"><a href="trasach.php">Trả sách</a></li>
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
    <h1 style="margin-top: 80px; text-align:center; font-size:50px;">Phiếu trả sách</h1>

    <div class="main" style="width:80vw">
        <div class="trasach " style="width:80vw">
            <div class="divContent thongtindocgia">
                <h2>Thông tin độc giả trả sách</h2>
                <div class="thongtinDG">
                <form class="container" enctype="multipart/form-data" method="POST">
                    Mã Độc Giả: 
                    <input class="inputmaDG" type="number" name="madocgia" placeholder="Nhập mã độc giả"> <br>
                    Họ và Tên:
                    <input class="inputtenDG" type="text" name="tendocgia" placeholder="Nhập tên độc giả">
                    <div class="btn btnDGMS">
                        <button type="submit" class="save" name="btnTimDGTS">Tìm</button>
                    </div>
                </form>
                </div>
            </div>
        </div>
        <?php

            require('dbconnect.php');
            if (isset($_POST["btnTimDGTS"]) || isset($_POST["lapphieuTS"]) || isset($_POST["LapPTTP"]) || isset($_POST["LapPhieuthutienphatTC"])){
                $madocgia=$_POST["madocgia"];
                if(isset($_POST["btnTimDGTS"])){
                    $tendocgia = $_POST["tendocgia"];
                    $sql="SELECT TongNo from docgia where MaDocGia='$madocgia' and HoTen = '$tendocgia'";
                }
                else{
                    $sql="SELECT TongNo, HoTen from docgia where MaDocGia='$madocgia'";
                }
                if(!$result=$mysqli->query($sql)) echo 'Loi100: '.$mysqli->error;

                //Ở ĐÂY XÉT TRƯỜNG HỢP TÌM ĐƯỢC MÃ ĐỘC GIẢ, CÒN NẾU KHÔNG TÌM ĐƯỢC THÌ XUẤT THÔNG BÁO TRONG MỆNH ĐỀ ELSE (TỰ THÊM ELSE) 
                if ($result->num_rows>0){
                    $row=$result->fetch_assoc();
                    if(isset($_POST["btnTimDGTS"])){
                        $notruoc=$row["TongNo"];
                    }
                    else{
                        $notruoc=$row["TongNo"];
                        $tendocgia = $row["HoTen"];
                    }
                    ?>
                    <div class="DGtrasach">
                        <div class="DGmuonsach divContent">
                            <h2>Thông tin độc giả</h2>
                            <div class="container">
                                <p>Mã độc giả: <?php echo $madocgia;?></p>
                                <p>Họ và tên: <?php echo $tendocgia;?></p>
                                <p>Nợ: <?php echo $notruoc;?> đồng</p>

                            </div>
                        </div>
                        <div class="DSsachDGM divContent">
                            <h2>Danh sách sách độc giả đang mượn</h2>
                            <table id="resultSearchBook" class="bookLoan">
                                <thead id="BookTitle">
                                    <th>STT</th>
                                    <th>Mã Cuốn Sách</th>
                                    <th>Tên sách</th>
                                    <th>Trả sách</th>
                                </thead>
                                <tbody class="danhsachsachchuanbichomuon">
                                <?php
                                    $sql="SELECT TenDauSach,NgayMuon, NgayPhaiTra,cuonsach.MaCuonSach, NgayTra
                                        FROM docgia inner join phieumuontra on docgia.MaDocGia=phieumuontra.MaDocGia
                                                    inner join cuonsach on cuonsach.MaCuonSach=phieumuontra.MaCuonSach
                                                    inner join sach on sach.MaSach=cuonsach.MaSach
                                                    inner join dausach on dausach.MaDauSach=sach.MaDauSach
                                        WHERE docgia.MaDocGia='$madocgia'";
                                    if(!$result=$mysqli->query($sql)) echo 'Loi1: '.$mysqli->error;
                                    $index = 0;
                                    if($result->num_rows>0){
                                        //Danh sach sach doc gia dang muon
                                        while($row=$result->fetch_assoc()){
                                            $q=$row["NgayTra"];
                                            if($q==NULL){
                                            $index++;
                                            $ngayphaitra=$row["NgayPhaiTra"];
                                            $ngaymuon=$row["NgayMuon"];
                                            $tensach=$row["TenDauSach"];
                                            $macuonsach=$row["MaCuonSach"];
                                            ?>
                                            <tr class="DSSTra" > 
                                                <td><?php echo $index;?></td>
                                                <td><?php echo $macuonsach;?></td>
                                                <td><?php echo $tensach;?></td>
                                                <td>
                                                    <form enctype="multipart/form-data" method="POST">
                                                        <input type="hidden" name="maSachhidden" class="maSachhidden" value="<?php echo $macuonsach;?>">
                                                        <input type="hidden" name="madocgia" class="maDGhidden" value="<?php echo $madocgia?>">
                                                        <button class="btnhidden" type="submit" name="lapphieuTS" style="padding:0; margin:0; color:black; background-color: inherit;">Trả sách</button>
                                                    </form>
                                                </td>
                                            </tr>
                                            <?php
                                            }  
                                    }
                                        
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <?php
                }
                else{
                    ?>
                    <div class="divTBTKadmin  thongbaobitrung">
                        <div class="thongbaosachmoi">
                            <div class="TBthemmoi divktimthay">
                                <div class="TBcontent theDGcontent">
                                    <a href="trasach.php"><i class="bitrung fas fa-times"></i></a>
                                    <h2>Không tìm thấy độc giả!</h2>
                                    
                                    <div class="btn" style="justify-content: center;">
                                        <button><a href="trasach.php">OK</a></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <?php
                }
            }   
            $mysqli->close();
        ?>
    </div>
    <?php

        require('dbconnect.php');
        if (isset($_POST["lapphieuTS"])){
            $macuonsach=$_POST["maSachhidden"];
            $madocgia=$_POST["madocgia"];
            $sql="SELECT HoTen,NgayPhaiTra,TongNo,NgayMuon,NgayTra from docgia inner join phieumuontra on docgia.MaDocGia=phieumuontra.MaDocGia
                where docgia.MaDocGia='$madocgia' and MaCuonSach='$macuonsach'";
            if(!$result=$mysqli->query($sql)) echo 'Loi1: '.$mysqli->error;
            while($row=$result->fetch_assoc()){
                $q=$row["NgayTra"];
                if($q==NULL){
                    $ngayphaitra=$row["NgayPhaiTra"];
                    $notruoc=$row["TongNo"];
                    $ngaymuon=$row["NgayMuon"];
                    $tendocgia=$row["HoTen"];
                }
            }
            $ngaymuonhtml = date("d/m/Y",strtotime($ngaymuon));
            
            $ngaytra=date("Y-m-d");//Ngay tra
            $ngaytrahtml = date("d/m/Y",strtotime($ngaytra));
            $date1=date_create($ngaytra);
            $date2=date_create($ngaymuon);
            $diff=date_diff($date1,$date2);
            $songaym=$diff->format('%d');// so ngay muon
            $sothangm=$diff->format('%m');

            $songaymuon=$sothangm*30 + $songaym;

            $sql="SELECT GiaTri from thamso where TenThamSo='TienPhatMoiNgay'";
            if(!$result=$mysqli->query($sql)) echo 'Loi3: '.$mysqli->error;
            $row=$result->fetch_assoc();
            $tpmn=$row["GiaTri"];

            $sql="SELECT GiaTri from thamso where TenThamSo='SoNgayMuonToiDa'";
            if(!$result=$mysqli->query($sql)) echo 'Loi4: '.$mysqli->error;
            $row=$result->fetch_assoc();
            $snmmax=$row["GiaTri"];
            
            if($songaymuon>$snmmax) $t=$songaymuon - $snmmax;
            else $t=0;
            $tienphat=$t*$tpmn;// tien phat

            $tongno=$notruoc + $tienphat;//tong no
            $sql="SELECT SoPhieu,NgayTra from phieumuontra where MaDocGia='$madocgia' and MaCuonSach='$macuonsach' ";
            if(!$result=$mysqli->query($sql)) echo 'Loi50: '.$mysqli->error;
            if($result->num_rows>0){
                while($row=$result->fetch_assoc()){
                $sophieu=$row["SoPhieu"];
                $kt=$row["NgayTra"];
                if($kt==NULL){
                $sql="UPDATE phieumuontra SET NgayTra='$ngaytra',SoNgayMuon='$songaymuon',TienPhat='$tienphat', TienNoKyNay = '$tienphat'
                      WHERE SoPhieu='$sophieu'";
                if(!$mysqli->query($sql)) echo "Loi5: ".$mysqli->error; 
                }}

            $sql="UPDATE cuonsach set TinhTrang='0' where MaCuonSach='$macuonsach' ";
            if(!$mysqli->query($sql)) echo "Loi6: ".$mysqli->error; 

            $sql="UPDATE docgia SET TongNo='$tongno' where MaDocGia='$madocgia'";
            if(!$mysqli->query($sql)) echo "Loi7: ".$mysqli->error; 
            }
            ?>
                <div class="thongbaosachmoi divphieumuon">
                    <div class="TBthemmoi">
                        <div class="TBcontent theDGcontent">
                            <h1>Trả sách thành công!</h1>
                            <h2>Phiếu trả sách</h2>
                            <form id="formTSTT" enctype="multipart/form-data" method="POST">
                                <div class="lapphieumuonsach">
                                    <div class="headerphieuMS headerPhieutra">
                                        <p>Họ tên độc giả: <?php echo $tendocgia;?></p>
                                        <div>
                                            <p>Ngày trả: <?php echo $ngaytrahtml;?></p>
                                            <p>Tiền phạt kì này: <?php echo $tienphat;?> đồng</p>
                                            <p>Tổng nợ: <?php echo $tongno;?> đồng</p>
                                        </div>
                                    </div>
                                    <div>
                                        <p>Mã cuốn sách: <?php echo $macuonsach;?></p>
                                        <p>Ngày mượn :<?php echo $ngaymuonhtml;?></p>
                                        <p>Số Ngày Mượn: <?php echo $songaymuon;?></p>
                                        <p>Tiền phạt:  <?php echo $tienphat;?> đồng</p>
                                    </div>
                                    <div class="TrasachThutien">
                                        <p id="btnTSTT">Thu Tiền</p> 
                                        <?php
                                            $sql="SELECT GiaTri from thamso where TenThamSo='ApDungQD6'";
                                            if(!$result=$mysqli->query($sql)) echo 'Loi 8: '.$mysqli->error;
                                            $row=$result->fetch_assoc();
                                            $qd6=$row["GiaTri"];
                                        ?>
                                        <input class="action" type="number" name="inputTSTT" id="inputTSTT" placeholder="Nhập số tiền thu"
                                        min="0" max="<?php if(($qd6 == 1)){echo $tienphat;}?>">
                                        <input type="hidden" name="sophieu" value="<?php echo $sophieu?>">
                                        <input type="hidden" name="madocgia" value="<?php echo $madocgia?>">
                                    </div>
                                </div>
                                <div class="btn closephieumuonsach" style="justify-content: center;">
                                    <button class="btnhidden"type="submit" name="LapPTTP">OK</button>
                                </div> 
                            </form>

                    </div>
                </div>
            </div>
            <?php
            
            
        }

        $mysqli->close();

    ?>

    <?php

        require('dbconnect.php');
        if (isset($_POST["LapPTTP"])){
            $tientra=$_POST["inputTSTT"];//so tien thu
            $madocgia=$_POST["madocgia"];
            $sophieumuontra=$_POST["sophieu"];
            
            $sql2="UPDATE phieumuontra SET SoTienTra='$tientra',TienNoKyNay=TienNoKyNay-'$tientra' where SoPhieu='$sophieumuontra'";
            if(!$mysqli->query($sql2)) echo 'Loi17: '.$mysqli->error;

            $sql="SELECT HoTen,TongNo from docgia WHERE MaDocGia='$madocgia'";
            $result=$mysqli->query($sql);
            $row=$result->fetch_assoc();
            $tendg=$row["HoTen"];// ten doc gia
            $tongno=$row["TongNo"];// tong no
            
            $sql="SELECT GiaTri from thamso where TenThamSo='ApDungQD6'";
            if(!$result=$mysqli->query($sql)) echo 'Loi 8: '.$mysqli->error;
    
            $row=$result->fetch_assoc();
            $qd6=$row["GiaTri"];
            
            $conlai1=0;
            if($tientra>0){

                    $conlai=$tongno-$tientra;//no con lai
                    //if ($conlai<0) $conlai1=$tientra - $tongno;// so tien đóng dư
                    
                    ?>
                    <form method="POST" enctype="multipart/form-data">
                        <div class="thongbaosachmoi divphieuthu">
                            <div class="TBthemmoi">
                                <div class="TBcontent theDGcontent">
                                    <h2>Phiếu thu tiền phạt</h2>
                                    <div class="lapphieumuonsach">
                                            <p>Họ tên độc giả: <?php echo $tendg;?> </p>
                                            <p>Tổng nợ: <?php echo $tongno;?> đồng</p>
                                            <p>Số tiền thu:<?php echo $tientra;?> đồng</p>
                                            <p>Còn lại:<?php echo $conlai;?> đồng</p>
                                    </div>
                                    <div class="btn closephieumuonsach">
                                        <input type="hidden" name="madocgia" value="<?php echo $madocgia;?>">
                                        <button type="submit" name="LapPhieuthutienphatTC">OK</a></button>
                                    </div> 
                                </div>
                            </div>
                        </div>
                    </form>
                <?php
                    $ngaytra=date("Y-m-d");//Ngay tra
                    $sql="INSERT INTO phieuthutienphat(MaDocGia,NgayThu,TongNo,SoTienThu,ConLai) VALUES ('$madocgia','$ngaytra','$tongno','$tientra','$conlai')";
                    if(!$mysqli->query($sql)) echo 'Loi10: '.$mysqli->error;
            
                    $sql="UPDATE docgia SET TongNo='$conlai' where MaDocGia='$madocgia'";
                    if(!$mysqli->query($sql)) echo 'Loi11: '.$mysqli->error;

            
            } 
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