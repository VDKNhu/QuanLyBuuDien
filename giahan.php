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
    <title>Gia hạn</title>
</head>
<body>
<?php
    require('dbconnect.php');
    error_reporting(E_ERROR);
    
    ?>
        <div >
        <div class="thongbaosachmoi thongbaoxacnhan">
            <div class="TBthemmoi divktimthay">
                <form enctype="multipart/form-data" method="POST">
                    <div class="TBcontent theDGcontent">
                        <a href="lapthedocgia.php"><i class="fas fa-times"></i></a>
                        <h2>Xác nhận gia hạn thẻ độc giả</h2>
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
            $sql19="SELECT GiaTri from thamso where TenThamSo='ThoiHanthe'";
            if(!$result19=$mysqli->query($sql19)) echo 'Loi19: '.$mysqli->error;
            $kq19=$result19->fetch_assoc();
            $thoihanqd=$kq19["GiaTri"];
    
            $taongay=mktime(0,0,0,date("m")+$thoihanqd,date("d"),date("Y"));
            $ngayhethanmoi=date("Y-m-d",$taongay);
            
            $sql17="UPDATE docgia set DaHetHan='0', NgayHetHan='$ngayhethanmoi' where MaDocGia ='$madocgia'";
            if(!$mysqli->query($sql17)) echo 'Loi16: '.$mysqli->error;
            ?>
            <div >
                <div class="thongbaosachmoi thongbaoxacnhan">
                    <div class="TBthemmoi divktimthay">
                            <div class="TBcontent theDGcontent">
                                <a href="lapthedocgia.php"><i class="fas fa-times"></i></a>
                                <h2>Gia hạn thành công!</h2>
                                <div class="btn closephieumuonsach">
                                    <button class="tatTB">
                                        <a href="lapthedocgia.php">OK</a>
                                    </button>
                                </div> 
                            </div>
                    </div>
                </div>
            </div>
            <?php
        }
        $mysqli->close();
?>
</body>
</html>