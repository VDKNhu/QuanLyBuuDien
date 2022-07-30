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
    <link rel="stylesheet" href="style-ltdg.css">
    <link rel="stylesheet" href="style_thongbao.css">
    <title>Xóa thẻ độc giả</title>
</head>
<body>
    <?php
        $conn = mysqli_connect('localhost', 'root', '', 'quanlythuvien') or die ('fail');
        if(mysqli_connect_errno()){
            echo "failed to connect to Mysql: ".mysqli_connect_error();
            exit();
        }
        ?>
        <div >
            <div class="thongbaosachmoi thongbaoxacnhan">
                <div class="TBthemmoi divktimthay">
                    <form enctype="multipart/form-data" method="POST">
                        <div class="TBcontent theDGcontent">
                            <a href="lapthedocgia.php"><i class="fas fa-times"></i></a>
                            <h2>Xác nhận xóa thẻ độc giả</h2>
                            <input type="hidden" name="madocgia" value="<?php echo $_GET['GetID']; ?>">
                            <div class="btn closephieumuonsach">
                                <button name = "xacnhan" type="submit" class="tatTB">OK</button>
                            </div> 
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <?php

        if(isset($_POST['xacnhan'])){
            $madocgia = $_POST['madocgia'];
            $check=0;
            $sql_xoa="SELECT * FROM phieumuontra WHERE MaDocGia='$madocgia'";
            $res_xoa=mysqli_query($conn,$sql_xoa);
            if(mysqli_num_rows($res_xoa)>0){
                while($row_xoa=mysqli_fetch_assoc($res_xoa)){
                    if($row_xoa["NgayTra"]==''){
                        $check=1;
                        ?>
                        <div class="thongbaosachmoi">
                            <div class="TBthemmoi">
                                <div class="TBcontent theDGcontent">
                                    <a href="lapthedocgia.php"><i style="right: 32vw;" class="fas fa-times"></i></a>

                                    <h1>Thẻ còn sách đang mượn</h1>
                                    <h2 style="border: none;"> Không thể xóa thẻ!</h2>
                                    <div class="btn">
                                        <button><a href="lapthedocgia.php">Quay lại</a></button>
                                        <button><a href="index-home.php">Trở về trang chủ</a></button>
                                    </div>
                                </div>
                            </div>
                        </div>
            
                        <?php
            
                    }
                }
            }else{
            $sql_ = "UPDATE docgia SET 
                        DaXoa = 1
                    WHERE MaDocGia='$madocgia'";
            if(mysqli_query($conn, $sql_)){
                ?>
                <div class="thongbaosachmoi">
                    <div class="TBthemmoi">
                        <div class="TBcontent theDGcontent">
                            <a href="lapthedocgia.php"><i style="right: 31.5vw;" class="fas fa-times"></i></a>
                            <h1>Xóa thẻ độc giả thành công!</h1>
                            <div class="btn">
                                <button><a href="lapthedocgia.php">Quay lại</a></button>
                                <button><a href="index-home.php">Trở về trang chủ</a></button>
                            </div>
                        </div>
                    </div>
                </div>

                <?php
                }
            }
        }
        mysqli_close($conn);
    ?>
</body>
</html>