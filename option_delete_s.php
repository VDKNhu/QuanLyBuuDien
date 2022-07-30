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
    <title>Xóa thông tin sách</title>
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
        <div class="inputContent divContent">
            <h1>Xóa đầu sách, sách, cuốn sách</h1>
            <div class="book">
                <br><h2>Xóa đầu sách</h2>
                <i>Lưu ý: Nếu xóa đầu sách thì tất cả các sách và cuốn sách thuộc đầu sách tương ứng sẽ bị xóa theo!</i>
                <i>Không xóa đầu sách có cuốn sách đang được mượn!</i>
                <table id="resultSearchBook">
                    <thead>
                        <th>STT</th>
                        <th>Tên đầu sách</th>
                        <th>Thể loại</th>
                        <th>Xóa</th>
                    </thead>
                    <?php 
                        $masach = $_GET['GetID'];
                        $conn = mysqli_connect('localhost', 'root', '', 'quanlythuvien') or die ('fail');
                        if(mysqli_connect_errno()){
                            echo "failed to connect to Mysql: ".mysqli_connect_error();
                            exit();
                        }
                        $inde=0;
                        $sql1 = "SELECT DISTINCT dausach.MaDauSach, sach.MaSach, TenDauSach, TenTheLoai 
                            FROM dausach INNER JOIN sach ON dausach.MaDauSach = sach.MaDauSach
                            INNER JOIN theloai ON dausach.MaTheLoai=theloai.MaTheLoai
                            WHERE sach.MaSach=$masach AND dausach.DaXoa=0";
                        $result1 = mysqli_query($conn, $sql1);
                        $row1 = mysqli_fetch_assoc($result1);
                        $inde++;
                    ?>
                    <tr>
                        <td><?php echo $inde;?></td>
                        <td class="tendausach"><?php echo $row1["TenDauSach"]; ?></td>
                        <td class="tl"><?php echo $row1["TenTheLoai"]; ?></td>
                        <?php
                        $madsach=$row1["MaDauSach"];
                        $sql_ds = "SELECT * FROM sach INNER JOIN cuonsach ON sach.MaSach=cuonsach.MaSach WHERE MaDauSach='$madsach' AND TinhTrang=1";
                        $res_ds = mysqli_query($conn,$sql_ds);
                        if(mysqli_num_rows($res_ds)>0){
                            ?>
                            <td></td>
                            <?php
                        }
                        else{
                            ?>
                            <td>
                                <form  enctype="multipart/form-data" method="POST">
                                    <input type="hidden" name="madausach" class="maSachhidden" value="<?php echo $row1["MaDauSach"]; ?>">
                                    <button class="btnhidden" style="background-color: inherit; color:black; margin:0;" type="submit" name="btnxoadausach">Xóa</button>
                                </form> 
                            </td>
                            <?php
                        }
                        ?>
                    </tr>
                    <h4>Danh sách gồm <?php echo $inde;?> đầu sách</h4>
                </table>
                <?php
                if(isset($_POST['btnxoadausach'])){
                    ?>
                    <div class="divTBTKadmin  tbxoadausach">
                        <div class="thongbaosachmoi">
                            <div class="TBthemmoi divktimthay">
                                <div class="TBcontent theDGcontent">
                                    <i class=" btntattbxoadausach bitrung fas fa-times"></i>
                                    <h2>Xác nhận xóa đầu sách!</h2>
                                    <form enctype="multipart/form-data" method="POST" >
                                        <input type="hidden" name="madausach" class="maSachhidden" value="<?php echo $row1["MaDauSach"]; ?>">
                                        <div class="btn" style="justify-content: center;">
                                            <button type="submit" name="xacnhanxoadausach" >OK</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <script>
                        document.querySelector(".btntattbxoadausach").addEventListener("click", function(){
                            document.querySelector(".tbxoadausach").classList.add("action");
                        })
                    </script>

                    <?php
                }
                    if(isset($_POST['xacnhanxoadausach'])){
                        $mads = $_POST['madausach'];
                        
                        $sql1 = "UPDATE cuonsach INNER JOIN sach ON cuonsach.MaSach=sach.MaSach
                                SET cuonsach.DaXoa=1 WHERE sach.MaDauSach=$mads AND cuonsach.DaXoa=0";
                        if(mysqli_query($conn, $sql1)){}
                    
                        $sql2 = "UPDATE sach
                                SET DaXoa=1 WHERE sach.MaDauSach=$mads AND sach.DaXoa=0";
                        if(mysqli_query($conn, $sql2)){}
                    
                        $sql3 = "UPDATE dausach
                                SET DaXoa=1 WHERE MaDauSach=$mads AND DaXoa=0";
                        if(mysqli_query($conn, $sql3)){
                            ?>
                    
                        <div class="divTBTKadmin  tbxoadausach">
                            <div class="thongbaosachmoi">
                                <div class="TBthemmoi divktimthay">
                                    <div class="TBcontent theDGcontent">
                                    
                                        <h2>Đã xóa đầu sách!</h2>
                                            <div class="btn" style="justify-content: center;">
                                                <button ><a href="tiepnhansachmoi.php">OK</a></button>
                                            </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    
                            <?php
                        }
                    }
                ?>
                <br><h2>Xóa sách</h2>
                <i>Lưu ý: Nếu xóa sách thì tất cả các cuốn sách thuộc sách tương ứng sẽ bị xóa theo!</i>
                <i>Không xóa sách có cuốn sách đang được mượn!</i>
                <table id="resultSearchBook">
                    <thead>
                        <th>STT</th>
                        <th>Mã sách</th>
                        <th>Tác giả</th>
                        <th>Nhà xuất bản</th>
                        <th>Năm xuất bản</th>
                        <th>Số lượng nhập</th>
                        <th>Giá tiền</th>
                        <th>Xóa</th>
                    </thead>
                    <?php 
                        $sql2 = "SELECT DISTINCT MaDauSach FROM sach WHERE MaSach='$masach'";
                        $res2 = mysqli_query($conn,$sql2);
                        $row2 = mysqli_fetch_assoc($res2);
                        $madausach = $row2['MaDauSach'];

                        $sql = "SELECT DISTINCT dausach.MaDauSach, sach.MaSach, TenTheLoai, NhaXuatBan, NamXuatBan, SoLuong, GiaTien 
                            FROM dausach INNER JOIN sach ON dausach.MaDauSach = sach.MaDauSach
                            INNER JOIN ct_tacgia ON dausach.MaDauSach=ct_tacgia.MaDauSach
                            INNER JOIN tacgia ON ct_tacgia.MaTacGia=tacgia.MaTacGia
                            INNER JOIN theloai ON dausach.MaTheLoai=theloai.MaTheLoai
                            WHERE dausach.MaDauSach=$madausach AND dausach.DaXoa=0 AND sach.DaXoa=0";
                            $ind = 0;
                        $result = mysqli_query($conn, $sql);
                        if(mysqli_num_rows($result)>0){
                            while($row=mysqli_fetch_assoc($result)){
                                $ind++;
                    ?>
                    <tr>
                        <td><?php echo $ind; ?></td>
                        <td class="masach"><?php echo $row["MaSach"]; ?></td>
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
                        <td class="nhaxb"><?php echo $row["NhaXuatBan"]; ?></td>
                        <td class="namxb"><?php echo $row["NamXuatBan"]; ?></td>
                        <td class="sl"><?php echo $row["SoLuong"]; ?></td>
                        <td class="gt"><?php echo $row["GiaTien"]; ?></td>
                        <?php
                            $sql_ds = "SELECT * FROM sach INNER JOIN cuonsach ON sach.MaSach=cuonsach.MaSach WHERE MaDauSach='$mads' AND TinhTrang=1";
                            $res_ds = mysqli_query($conn,$sql_ds);
                            if(mysqli_num_rows($res_ds)>0){
                                ?>
                                <td></td>
                                <?php
                            }
                            else{
                                ?>
                                <td>
                                    <form  enctype="multipart/form-data" method="POST">
                                        <input type="hidden" name="btnmasach" class="maSachhidden" value="<?php echo $row["MaSach"]; ?>">
                                        <button class="btnhidden" style="background-color: inherit; color:black; margin:0;" type="submit" name="btnxoasach">Xóa</button>
                                    </form> 
                                </td>
                                <?php
                            }
                        ?>
                    </tr>
                    <?php
                            }
                        }
                        if(isset($_POST['btnxoasach'])){
                            ?>
                            <div class="divTBTKadmin  tbxoasach">
                                <div class="thongbaosachmoi">
                                    <div class="TBthemmoi divktimthay">
                                        <div class="TBcontent theDGcontent">
                                            <i class=" btntattbxoasach bitrung fas fa-times"></i>
                                            <h2>Xác nhận xóa sách!</h2>
                                            <form enctype="multipart/form-data" method="POST" >
                                                <input type="hidden" name="masach" class="maSachhidden" value="<?php echo $_POST['btnmasach']; ?>">
                                                <div class="btn" style="justify-content: center;">
                                                    <button type="submit" name="xacnhanxoasach" >OK</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <script>
                                document.querySelector(".btntattbxoasach").addEventListener("click", function(){
                                    document.querySelector(".tbxoasach").classList.add("action");
                                })
                            </script>
                            <?php
                        }
                        if(isset($_POST['xacnhanxoasach'])){
                            $masach = $_POST['masach'];
                            
                            $sql1 = "UPDATE cuonsach INNER JOIN sach ON cuonsach.MaSach=sach.MaSach
                            SET cuonsach.DaXoa=1 WHERE sach.MaSach='$masach' AND cuonsach.DaXoa=0";
                            if(mysqli_query($conn, $sql1)){}
                        
                            $sql2 = "UPDATE sach
                                    SET DaXoa=1 WHERE MaSach='$masach' AND DaXoa=0";
                            if(mysqli_query($conn, $sql2)){
                                ?>

                                <div class="divTBTKadmin  tbxoadausach">
                                    <div class="thongbaosachmoi">
                                        <div class="TBthemmoi divktimthay">
                                            <div class="TBcontent theDGcontent">
                                            
                                                <h2>Đã xóa sách!</h2>
                                                    <div class="btn" style="justify-content: center;">
                                                        <button ><a href="tiepnhansachmoi.php">OK</a></button>
                                                    </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <?php
                            }

                        }
                    
                    ?>
                    <h4>Danh sách gồm <?php echo $ind ;?> sách</h4>
                </table>
                <br>
                <table id="resultSearchBook">
                <br><h2>Xóa cuốn sách</h2>
                <i>Lưu ý: Cuốn sách đang được mượn thì không được xóa!</i>
                    <thead>
                        <th>STT</th>
                        <th>Mã sách</th>
                        <th>Mã cuốn sách</th>
                        <th>Tình trạng</th>
                        <th>Xóa</th>
                    </thead>
                    <br>
                    <tbody>
                    <?php 
                        $masach = $_GET['GetID'];
                        $sql = "SELECT DISTINCT sach.MaSach, MaCuonSach, TinhTrang 
                            FROM dausach INNER JOIN sach ON dausach.MaDauSach = sach.MaDauSach
                            INNER JOIN ct_tacgia ON dausach.MaDauSach=ct_tacgia.MaDauSach
                            INNER JOIN tacgia ON ct_tacgia.MaTacGia=tacgia.MaTacGia
                            INNER JOIN theloai ON dausach.MaTheLoai=theloai.MaTheLoai
                            INNER JOIN cuonsach ON cuonsach.MaSach=sach.MaSach
                            WHERE dausach.MaDauSach=$madausach AND dausach.DaXoa=0 AND sach.DaXoa=0 AND cuonsach.DaXoa=0";
                        $result = mysqli_query($conn, $sql);
                        $index=0;
                        if(mysqli_num_rows($result) > 0){
                            while ($row = mysqli_fetch_assoc($result)){
                                $damuon = 0;
                                $index++;
                                if($row["TinhTrang"]==0) $tinhtrang="Chưa mượn";
                                else {
                                    $damuon++;
                                    $tinhtrang = "Đã mượn";
                                } 
                    ?>
                        <tr>
                            <td><?php echo $index;?></td>
                            <td class="masach"><?php echo $row["MaSach"] ?></td>
                            <td class="macuonsach"><?php echo $row["MaCuonSach"] ?></td>
                            <td class="tinhtrang"><?php echo $tinhtrang; ?></td>
                        <?php
                            if($row["TinhTrang"]==0) {
                            ?>
                            <td>
                                <form  enctype="multipart/form-data" method="POST">
                                    <input type="hidden" name="btnmacuonsach" class="maSachhidden" value="<?php echo $row["MaCuonSach"]; ?>">
                                    <button class="btnhidden" style="background-color: inherit; color:black; margin:0;" type="submit" name="btnxoacuonsach">Xóa</button>
                                </form> 
                            </td>
                            <?php
                            }
                            else {
                            ?>
                            <td></td>
                            <?php
                            }
                        ?>
                        </tr>
                        <?php
                            }
                        }
                        ?>
                        <h4>Danh sách gồm <?php echo $index;?> cuốn sách</h4>
                    </tbody>
                </table>
                <br>       
            <?php  
                if(isset($_POST['btnxoacuonsach'])){
                    ?>
                            <div class="divTBTKadmin  tbxoacuonsach">
                                <div class="thongbaosachmoi">
                                    <div class="TBthemmoi divktimthay">
                                        <div class="TBcontent theDGcontent">
                                            <i class=" btntattbxoacuonsach bitrung fas fa-times"></i>
                                            <h2>Xác nhận xóa sách!</h2>
                                            <form enctype="multipart/form-data" method="POST" >
                                                <input type="hidden" name="macuonsach" class="maSachhidden" value="<?php echo $_POST['btnmacuonsach']; ?>">
                                                <div class="btn" style="justify-content: center;">
                                                    <button type="submit" name="xacnhanxoacuonsach" >OK</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <script>
                                document.querySelector(".btntattbxoacuonsach").addEventListener("click", function(){
                                    document.querySelector(".tbxoacuonsach").classList.add("action");
                                })
                            </script>
                    <?php
                }
                if(isset($_POST['xacnhanxoacuonsach'])){
                    $macs = $_POST['macuonsach'];
                    $sql1 = "UPDATE cuonsach 
                            SET DaXoa=1 WHERE MaCuonSach=$macs AND DaXoa=0";
                    if(mysqli_query($conn, $sql1)){
                        ?>
                                <div class="divTBTKadmin  tbxoadausach">
                                    <div class="thongbaosachmoi">
                                        <div class="TBthemmoi divktimthay">
                                            <div class="TBcontent theDGcontent">
                                            
                                                <h2>Đã xóa cuốn sách!</h2>
                                                    <div class="btn" style="justify-content: center;">
                                                        <button ><a href="tiepnhansachmoi.php">OK</a></button>
                                                    </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                        <?php
                    }
                }
                mysqli_close($conn);
            ?>
            </div>
            <div class="btn">
                <button><a href="tiepnhansachmoi.php">Quay lại</a></button>
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
