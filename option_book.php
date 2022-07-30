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
    <title>Xem thông tin sách</title>
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
    <div class="main">
        <div class=" divContent">
            <div class="book">
            <h2>Mã sách: <?php echo $_GET['GetID']; ?></h2>
                <table id="resultSearchBook">
                    <thead>
                        <th>Tên đầu sách</th>
                        <th>Tác giả</th>
                        <th>Thể loại</th>
                        <th>Nhà xuất bản</th>
                        <th>Năm xuất bản</th>
                        <th>Số lượng nhập</th>
                        <th>Giá tiền</th>
                    </thead>
                    <?php 
                        $masach = $_GET['GetID'];
                        $conn = mysqli_connect('localhost', 'root', '', 'quanlythuvien') or die ('fail');
                        if(mysqli_connect_errno()){
                            echo "failed to connect to Mysql: ".mysqli_connect_error();
                            exit();
                        }
                        $sql = "SELECT DISTINCT dausach.MaDauSach, sach.MaSach, TenDauSach, TenTacGia, TenTheLoai, NhaXuatBan, NamXuatBan, SoLuong, GiaTien 
                            FROM dausach INNER JOIN sach ON dausach.MaDauSach = sach.MaDauSach
                            INNER JOIN ct_tacgia ON dausach.MaDauSach=ct_tacgia.MaDauSach
                            INNER JOIN tacgia ON ct_tacgia.MaTacGia=tacgia.MaTacGia
                            INNER JOIN theloai ON dausach.MaTheLoai=theloai.MaTheLoai
                            INNER JOIN cuonsach ON sach.masach=cuonsach.masach
                            WHERE sach.MaSach=$masach";
                        $result = mysqli_query($conn, $sql);
                        $row = mysqli_fetch_assoc($result);
                    ?>
                    <tr>
                        <td class="tendausach"><?php echo $row["TenDauSach"]; ?></td>
                        <td class="tg">
                        <?php 
                            $mads = $row["MaDauSach"];
                            $tg = "SELECT TenTacGia FROM tacgia INNER JOIN ct_tacgia ON ct_tacgia.MaTacGia=tacgia.MaTacGia WHERE ct_tacgia.MaDauSach=$mads";
                                $res_tg = mysqli_query($conn, $tg);
                                if(mysqli_num_rows($res_tg) > 0){
                                    while($row_tg = mysqli_fetch_assoc($res_tg)){
                                        ?>
                                        <p><?php echo $row_tg["TenTacGia"]; ?></p>
                                        <?php
                                    }
                                }
                    ?>

                        </td>
                        <td class="tl"><?php echo $row["TenTheLoai"]; ?></td>
                        <td class="nhaxb"><?php echo $row["NhaXuatBan"]; ?></td>
                        <td class="namxb"><?php echo $row["NamXuatBan"]; ?></td>
                        <td class="sl"><?php echo $row["SoLuong"]; ?></td>
                        <td class="gt"><?php echo $row["GiaTien"]; ?></td>
                    </tr>

                </table>
                <br>

                <table id="resultSearchBook">
                 <h2>Thông tin cuốn sách</h2>
                    <thead>
                        <th>STT</th>
                        <th>Mã cuốn sách</th>
                        <th>Tình trạng</th>
                    </thead>
                    <br>
                    <tbody>
                        <?php 
                            $masach = $_GET['GetID'];
                            $sql = "SELECT DISTINCT * FROM cuonsach WHERE MaSach=$masach";
                            $result = mysqli_query($conn, $sql);
                            $index=1;
                            if(mysqli_num_rows($result) > 0){
                                $damuon = 0;
                                while ($row = mysqli_fetch_assoc($result)){
                                    if($row["TinhTrang"]==0) $tinhtrang="Chưa mượn";
                                    else {
                                        $damuon++;
                                        $tinhtrang = "Đã mượn";
                                    } 
                                    ?>
                                    <tr>
                                        <td class="stt"><?php echo $index ?></td>
                                        <td class="macuonsach"><?php echo $row["MaCuonSach"] ?></td>
                                        <td class="tinhtrang"><?php echo $tinhtrang; ?></td>
                                    </tr>
                                    <?php 
                                    $index=$index+1;
                                }
                            }
                        ?>
                    <h4 class="total"> <?php echo "Danh sách gồm " . ($index-1) . " cuốn sách (" . $damuon . " cuốn sách đã mượn).";  ?> </h4> 
                    </tbody>
                </table>
            <br>         
            <div class="btn" style="display:flex; justify-content: space-between;">
                <a href="tiepnhansachmoi.php"><button>Quay lại</button></a>
            </div>      
            </div>
            <?php
                mysqli_close($conn);
            ?>
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
