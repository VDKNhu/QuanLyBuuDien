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
    <title>Lập phiếu thu tiền phạt</title>
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
                    <li class="select"><a href="tiepnhansachmoi.php">Quản lí sách</a></li>
                    <li class="select"><a href="tracuusach.php">Tra cứu sách</a></li>
                    <li class="select"><a href="sachmuon.php">Mượn sách</a></li>
                    <li class="select"><a href="trasach.php">Trả sách</a></li>
                    <li class="select backgd"><a href="phieuthutienphat.php">Phiếu thu tiền phạt</a></li>
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
    <h1 style="margin-top: 80px; text-align:center; font-size:50px;">Phiếu thu tiền phạt</h1>

    <div class="main "  style="width:80vw">
        <div class="phieumuonsach ">
            <div class="divContent thongtindocgia">
                <h2>Thông tin độc giả nộp phạt</h2>
                <div class="thongtinDG">
                <form class="container" enctype="multipart/form-data" method="POST">
                    Mã Độc Giả: 
                    <input class="inputmaDG" type="number" name="madocgia" placeholder="Nhập mã độc giả"> <br>
                    Họ và Tên:
                    <input class="inputtenDG" type="text" name="tendocgia" placeholder="Nhập tên độc giả">
                    <div class="btn btnDGMS">
                        <button type="submit" class="save" name="timDGTraTien">Tìm</button>
                    </div>
                </form>
                </div>
            </div>
        </div>
        <?php

            require('dbconnect.php');
            if (isset($_POST["timDGTraTien"])  || isset($_POST["LapPhieuthutienphatTC"]) || isset($_POST["LapPhieuthutienphatTC"])){
                $madocgia=$_POST["madocgia"];
                if(isset($_POST["timDGTraTien"])){
                    $tendocgia = $_POST["tendocgia"];
                    $sql="SELECT TongNo from docgia 
                        where MaDocGia='$madocgia' and HoTen = '$tendocgia'";
                }
                else{
                    $sql="SELECT TongNo,HoTen from docgia 
                        where MaDocGia='$madocgia'";
                }
                $result=$mysqli->query($sql);
                
                //Ở ĐÂY XÉT TRƯỜNG HỢP TÌM ĐƯỢC MÃ ĐỘC GIẢ, CÒN NẾU KHÔNG TÌM ĐƯỢC THÌ XUẤT THÔNG BÁO TRONG MỆNH ĐỀ ELSE (TỰ THÊM ELSE) 
                if ($result->num_rows>0){
                    $row=$result->fetch_assoc();
                    $tongno=$row["TongNo"];
                    if(isset($_POST["LapPhieuthutienphatTC"]) || isset($_POST["LapPhieuthutienphatTC"])){
                        $tendocgia = $row["HoTen"];
                    }

                    ?>
                    <div class="divContent">
                        <h2>Thông tin Độc giả trả sách</h2>
                        <div class="container thutien">
                        <div class="TTDGtratien">
                                Mã độc giả: <?php echo $madocgia;?>
                                <br>
                                Họ và tên: <?php echo $tendocgia;?>
                                <br>
                            </div>

                            <form method="POST" enctype="maltipart/form-data">
                                <div class="sotienthu">
                                    Tổng nợ: <?php echo $tongno;?>
                                    <br>
                                    Số tiền thu: 
                                    <?php
                                        $sql="SELECT GiaTri from thamso where TenThamSo='ApDungQD6'";
                                        if(!$result=$mysqli->query($sql)) echo 'Loi 8: '.$mysqli->error;
                                        $row=$result->fetch_assoc();
                                        $qd6 = $row["GiaTri"];
                                        ?>
                                    <input required type="number" name="sotienthu" placeholder="Nhập số tiền thu" 
                                    max = "<?php if($qd6==1){echo $tongno;}?>">
                                    <input type="hidden" name="madocgia" value="<?php echo $madocgia;?>">
                                    <br>
                                    Còn lại: <?php echo $tongno;?>
                                    <br>
                                    <div class="btn" style="justify-content: center;">
                                        <button type="submit" name="lapPT">OK</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                <?php
                }
                else {
                    ?>
                    <div class="divTBTKadmin  thongbaobitrung">
                        <div class="thongbaosachmoi">
                            <div class="TBthemmoi divktimthay">
                                <div class="TBcontent theDGcontent">
                                    <a href="phieuthutienphat.php"><i class="bitrung fas fa-times"></i></a>
                                    <h2>Không tìm thấy độc giả!</h2>
                                    
                                    <div class="btn" style="justify-content: center;">
                                        <button><a href="phieuthutienphat.php">OK</a></button>
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
    if (isset($_POST["lapPT"])){
        $madocgia=$_POST["madocgia"];
        $sotienthu=$_POST["sotienthu"];
        $sql="SELECT TongNo,HoTen from docgia where MaDocGia='$madocgia'";
        $result=$mysqli->query($sql);
        
        if ($result->num_rows>0){
            $row=$result->fetch_assoc();
            $tongno=$row["TongNo"];
            $tendocgia=$row["HoTen"];
        
            $conlai=$tongno - $sotienthu;
        
            $ngayht=date("Y-m-d");
            ?>
            <form method="POST" enctype="multipart/form-data">
                <div class="thongbaosachmoi divphieuthu">
                    <div class="TBthemmoi">
                        <div class="TBcontent theDGcontent">
                            <h2>Phiếu thu tiền phạt</h2>
                            <div class="lapphieuthutienphat">
                                    <p>Họ tên độc giả: <?php echo $tendocgia;?> </p>
                                    <p>Tổng nợ: <?php echo $tongno;?> đồng</p>
                                    <p>Số tiền thu:<?php echo $sotienthu;?> đồng</p>
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
            $sql="INSERT INTO phieuthutienphat(MaDocGia,NgayThu,TongNo,SoTienThu,ConLai) 
                VALUES ('$madocgia','$ngayht','$tongno','$sotienthu','$conlai')";
            if(!$mysqli->query($sql)) echo 'Loi2:'.$mysqli->error;
        
            $sql="UPDATE docgia SET TongNo=$conlai WHERE MaDocGia='$madocgia' ";
            if(!$mysqli->query($sql)) echo 'Loi1: '.$mysqli->error;
        
            
        
        }
    }


    $mysqli->close();

?>
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