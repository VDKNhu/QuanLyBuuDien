<?php 
    session_start();
    $conn=mysqli_connect('localhost','root','','quanlythuvien') or die('fail');

    $manguoidung=$_SESSION["manguoidung"];
    $sql_12="SELECT * FROM nguoidung INNER JOIN docgia ON nguoidung.MaNguoiDung=docgia.MaNguoiDung WHERE nguoidung.MaNguoiDung='$manguoidung'";
    $res_12=mysqli_query($conn,$sql_12);
    $row_12=mysqli_fetch_assoc($res_12);
    $hoten=$row_12["HoTen"];  
?>

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
    <title>Thông tin mượn trả</title>
</head>
<body>
    <div class="option">    
        <div class="header">
            <ul class="container-main">
                <li class="select">
                    <a href="index-docgia.php">
                        <i class="fas fa-home"></i>
                        Trang chủ
                    </a>
                </li>
                <li class="select"><a href="tracuusach-docgia.php" class="tracuusach">Tra cứu sách</a></li>
                <li class="select"><a href="thongtindocgia.php" class="thongtindocgia">Thông tin độc giả</a></li>
                <li class="select backgd"><a href="thongtinmuontra-docgia.php" class="thongtindocgia">Thông tin mượn/trả sách</a></li>
            </ul>
        </div>
    </div>
    <h1 style="margin-top: 80px; text-align:center; font-size:50px;">Thông tin mượn trả</h1>

        <div class="main divthongtinmuontraDG">
            <div class="divContent divthongtinDG">
                <h2>Thông tin độc giả</h2>
                <div class="container">
                    <?php
                        $sql_ = "SELECT * FROM docgia WHERE MaNguoiDung = '$manguoidung'";
                        $result_ = mysqli_query($conn, $sql_);
                        $row_ = mysqli_fetch_assoc($result_);
                        $ngayhethan = $row_['NgayHetHan'];
                        $ngayhethanhtml = date("d/m/Y",strtotime($ngayhethan));
                        ?>
                        <p>Mã độc giả: <?php echo $row_['MaDocGia'];?></p>
                        <p>Họ Tên:  <?php echo $row_['HoTen'];?></p>
                        <p>Ngày hết hạn:  <?php echo $ngayhethanhtml;?></p>
                        <p>Tổng Nợ:  <?php echo $row_['TongNo'];?></p>
                        <?php
                    ?>
                </div>
            </div>
            <div class="divContent divthongtinMT">
                <h2>Thông tin mượn/trả sách</h2>
                <div class="book">
                    <table id="resultSearchBook">
                        <thead>
                            <th>STT</th>
                            <th>Mã cuốn sách</th>
                            <th>Tên đầu sách</th>
                            <th>Ngày mượn</th>
                            <th>Ngày phải trả</th>
                            <th>Ngày trả</th>
                            <th>Sách quá hạn</th>
                        </thead>
                        <tbody>
                            <?php 
                                $sql = "SELECT * FROM dausach INNER JOIN sach ON dausach.MaDauSach=sach.MaDauSach
                                            INNER JOIN cuonsach ON sach.MaSach=cuonsach.MaSach
                                            INNER JOIN phieumuontra ON phieumuontra.MaCuonSach=cuonsach.MaCuonSach
                                            INNER JOIN docgia ON phieumuontra.MaDocGia=docgia.MaDocGia
                                            WHERE docgia.MaNguoiDung=$manguoidung";
                                $result = mysqli_query($conn, $sql);
                                $index=1;
                                $dem=0;
                                if(mysqli_num_rows($result)!=0){
                                    while($row=mysqli_fetch_assoc($result)){
                                        ?>
                                        <tr>
                                            <td><?php echo $index++;?></td>
                                            <td class="macs"><?php echo $row["MaCuonSach"]; ?></td>
                                            <td class="tends"><?php echo $row["TenDauSach"]; ?></td>
                                            <td class="ngaymuon"><?php
                                                $ngaymuon =  $row["NgayMuon"]; 
                                                $ngaymuonhtml = date("d/m/Y",strtotime($ngaymuon));
                                                echo $ngaymuonhtml;
                                             ?></td>
                                            <td class="ngayphaitra"><?php
                                                $ngayphaitra =  $row["NgayPhaiTra"]; 
                                                $ngayphaitrahtml = date("d/m/Y",strtotime($ngayphaitra));
                                                echo $ngayphaitrahtml;
                                             ?></td>
                                            <td class="ngaytra">
                                                <?php 
                                                    $ngaytra = $row["NgayTra"];
                                                    $ngaytrahtml =  date("d/m/Y",strtotime($ngaytra));
                                                    if($row["NgayTra"]=='') echo "Chưa trả sách";
                                                    else echo $ngaytrahtml; 
                                                ?>
                                            </td>
                                            <td class="sachquanhan">
                                                <?php  
                                                    $today=date("Y-m-d");
                                                    if($row["NgayTra"]=='' && $today>$row["NgayPhaiTra"]){
                                                        echo "Quá hạn";
                                                        $dem++;
                                                    }
                                                    if($row["NgayTra"]!='' && $row["NgayTra"]>$row["NgayPhaiTra"]){ 
                                                        echo "Quá hạn";
                                                        $dem++;
                                                    }
                                                ?>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                }
                            ?>
                            <h4 style="margin-bottom:10px;">
                                <?php
                                echo "Bạn đã mượn ".($index-1)." cuốn sách.";
                                echo " (Số sách quá hạn: ". $dem." cuốn sách)";
                                ?>
                                </h4>
                    <?php

                        $sql_13="SELECT GiaTri FROM thamso WHERE TenThamSo='TienPhatMoiNgay'";
                        $res_13=mysqli_query($conn,$sql_13);
                        $row_13=mysqli_fetch_assoc($res_13);
                        $tienphat=$row_13["GiaTri"];
                    ?>
                        </tbody>
                        
                    </table>
                    <br>
                    <br>
                    <i>Lưu ý: Độc giả trả trễ sách sẽ phải đóng thêm tiền phạt trả trễ là <?php echo $tienphat;?> đồng/ngày.</i>


                </div>
            </div>
        </div>
    <?php
        mysqli_close($conn);
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

