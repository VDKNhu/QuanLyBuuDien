
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
    <link rel="stylesheet" href="style-option.css">
    <link rel="stylesheet" href="style-ltdg.css">
    <link rel="stylesheet" href="style-table.css">
    <link rel="stylesheet" href="style_thongbao.css">
    <script src="js-option.js" defer></script>
    <script src="jsbaocao.js" defer></script>
    <title>Cài đặt</title>
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
                    <li class="select backgd">
                        <a href="option.php">
                            Cài đặt
                        </a>
                    </li>
                    <!-- <li class="select"><a href="danhsachphieu.php">Danh sách phiếu</a></li> -->
            </ul>
        </div>
    </div>
    <h1 style="margin-top: 80px; text-align:center; font-size:50px;">Cài đặt</h1>

    <div class="optionContent">
        <div class="optionSelect divContent">
            <h2>Cài đặt</h2>
            <div class="selectContainer">
                <ul>
                    <li class="list ThayDoi khac backgd">Thông tin thẻ độc giả</li>
                    <li class="list import chung ">Thông tin sách</li>
                    <li class="list DSTDG">Thông tin mượn trả</li>
                    <li class="list DSS">Thông tin thu tiền</li>
                </ul>
            </div>
        </div>
        <?php
                        $conn = mysqli_connect('localhost', 'root', '', 'quanlythuvien') or die ('fail');
                        if(mysqli_connect_errno()){
                            echo "failed to connect to Mysql: ".mysqli_connect_error();
                            exit();
                        }
                        $sql1 = "SELECT GiaTri FROM `thamso` WHERE TenThamSo='TuoiToiThieu'";
                        $res1 = mysqli_query($conn, $sql1);
                        $row1 = mysqli_fetch_assoc($res1);
                        $tuoitoithieu = $row1['GiaTri'];

                        $sql2 = "SELECT GiaTri FROM `thamso` WHERE TenThamSo='TuoiToiDa'";
                        $res2 = mysqli_query($conn, $sql2);
                        $row2 = mysqli_fetch_assoc($res2);
                        $tuoitoida = $row2['GiaTri'];

                        $sql3 = "SELECT GiaTri FROM `thamso` WHERE TenThamSo='ThoiHanThe'";
                        $res3 = mysqli_query($conn, $sql3);
                        $row3 = mysqli_fetch_assoc($res3);
                        $thoihanthe = $row3['GiaTri'];

                        $sql4 = "SELECT GiaTri FROM `thamso` WHERE TenThamSo='KhoangCachNamXB'";
                        $res4 = mysqli_query($conn, $sql4);
                        $row4 = mysqli_fetch_assoc($res4);
                        $kcxb = $row4['GiaTri'];

                        $sql5 = "SELECT GiaTri FROM `thamso` WHERE TenThamSo='SoNgayMuonToiDa'";
                        $res5 = mysqli_query($conn, $sql5);
                        $row5 = mysqli_fetch_assoc($res5);
                        $maxslngay = $row5['GiaTri'];

                        $sql6 = "SELECT GiaTri FROM `thamso` WHERE TenThamSo='SoSachMuonToiDa'";
                        $res6 = mysqli_query($conn, $sql6);
                        $row6 = mysqli_fetch_assoc($res6);
                        $maxslsach = $row6['GiaTri'];

                        $sql7 = "SELECT GiaTri FROM `thamso` WHERE TenThamSo='TienPhatMoiNgay'";
                        $res7 = mysqli_query($conn, $sql7);
                        $row7 = mysqli_fetch_assoc($res7);
                        $tienphatmoingay = $row7['GiaTri'];

                        $sql8 = "SELECT GiaTri FROM `thamso` WHERE TenThamSo='ApDungQD6'";
                        $res8 = mysqli_query($conn, $sql8);
                        $row8 = mysqli_fetch_assoc($res8);
                        $qd6 = $row8['GiaTri'];

                ?>
        <div class="optionDetail divContent">
            <form enctype="multipart/form-data" method="POST">
                <div class="KhacContent">
                    <h2>Thay đổi thông tin thẻ độc giả</h2>
                    <i>Lưu ý: Giá trị của tuổi tối thiểu, tuổi tối đa, thời hạn thẻ phải là số dương, tuổi tối thiểu phải bé hơn tuổi tối đa!</i>
                    <div class="container">
                        <div class="cssoption">
                            <div class="bar">
                                <p>Tuổi tối thiểu:</p>
                                <input name="tuoitoithieu" type="number" max="<?php echo $tuoitoida;?> " class="tuoimin" value="<?php echo $tuoitoithieu?>">
                                <button name="luuthaydoi" type="submit" class="save">Lưu thay đổi</button>
                            </div>
                            <div class="btn">
                            </div>
                        </div>
                        <div class="cssoption">
                            <div class="bar">
                                <p>Tuổi tối đa:</p>
                                <input name="tuoitoida" type="number" min = "<?php echo $tuoitoithieu ;?>" class="tuoimax" value="<?php echo $tuoitoida?>">
                                <button name="luuthaydoi" type="submit" class="save">Lưu thay đổi</button>
                            </div>
                            <div class="btn">
                            </div>
                        </div>
                        <div class="cssoption">
                            <div class="bar">
                                <p>Thời hạn thẻ</p>
                                <input name="thoihanthe" type="number" class="thoihangiatrithe" value="<?php echo $thoihanthe?>">
                                <button name="luuthaydoi" type="submit" class="save">Lưu thay đổi</button>
                            </div>
                            <div class="btn">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="KhacContent action">
                    <h2>Thay đổi thông tin sách</h2>
                    <i>Lưu ý: Giá trị của khoảng cách năm xuất bản phải là số dương!</i>
                    <div class="container">
                        <div class="namxb cssoption">
                            <div class="bar">
                                <p>Khoảng cách năm xuất bản:</p>
                                <input name="kcxb" type="number" min="0" value="<?php echo $kcxb?>">
                                <button name="luuthaydoi" type="submit" class="save">Lưu thay đổi</button>
                            </div>
                            <div class="btn">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="KhacContent action">
                    <h2>Thay đổi thông tin mượn trả</h2>
                    <i>Lưu ý: Giá trị của số ngày mượn tối đa, số sách mượn tối đa, tiền phạt mỗi ngày phải là số dương!</i>
                    <div class="container">
                        <div class="cssoption">
                            <div class="bar">
                                <p>Số ngày mượn tối đa: </p>
                                <input name="songaymuontoida" type="number" min="1" value="<?php echo $maxslngay?>">
                                <button name="luuthaydoi" type="submit" class="save">Lưu thay đổi</button>
                            </div>
                            <div class="btn">
                            </div>
                        </div>
                        <div class="cssoption">
                            <div class="bar">
                                <p>Số sách mượn tối đa: </p>
                                <input name="sosachmuontoida" type="number" min="1" value="<?php echo $maxslsach?>">
                                <button name="luuthaydoi" type="submit" class="save">Lưu thay đổi</button>
                            </div>
                            <div class="btn">
                            </div>
                        </div>
                        <div class="cssoption">
                            <div class="bar">
                                <p>Tiền phạt mỗi ngày:</p>
                                <input name="tienphatmoingay" type="number" min="1" value="<?php echo $tienphatmoingay?>">
                                <button name="luuthaydoi" type="submit" class="save">Lưu thay đổi</button>
                            </div>
                            <div class="btn">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="KhacContent action">
                    <h2>Thông tin thu tiền</h2>
                    <div class="container">
                                <p>Số tiền thu có nhỏ hơn số tiền nợ hay không:</p>
                        <div class="cssoption quydinh_">
                            <div>
                                <input type="radio" name="sotienthu" value="yes" checked="checked">
                                <label for="yes">Có</label> <br>
                            </div>
                            <div>
                                <input type="radio" name="sotienthu" value="no">
                                <label for="no">Không</label>
                            </div>

                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <?php
         mysqli_close($conn);
    ?>
    <?php
    $conn = mysqli_connect('localhost', 'root', '', 'quanlythuvien') or die ('fail');
    if(mysqli_connect_errno()){
        echo "failed to connect to Mysql: ".mysqli_connect_error();
        exit();
    }
    if (isset($_POST['luuthaydoi']) ){
        $ma=0;
        $check=-1;
        $tuoitoithieu = $_POST["tuoitoithieu"];
        $tuoitoida = $_POST["tuoitoida"];
        $thoihan = $_POST["thoihanthe"];
        $kcxb = $_POST["kcxb"];
        $songaymuontoida = $_POST["songaymuontoida"];
        $sosachmuontoida = $_POST["sosachmuontoida"];
        $tienphatmoingay = $_POST["tienphatmoingay"];
        
        $tuoimin = "SELECT GiaTri FROM thamso WHERE TenThamSo = 'TuoiToiThieu'";
        $res1 = mysqli_query($conn, $tuoimin);
        $row1 = mysqli_fetch_assoc($res1);
        $tuoimin = $row1['GiaTri'];

        $tuoimax = "SELECT GiaTri FROM thamso WHERE TenThamSo = 'TuoiToiDa'";
        $res2 = mysqli_query($conn, $tuoimax);
        $row2 = mysqli_fetch_assoc($res2);
        $tuoimax = $row2['GiaTri'];

        $thoihanthe = "SELECT GiaTri FROM thamso WHERE TenThamSo = 'ThoiHanThe'";
        $res3 = mysqli_query($conn, $thoihanthe);
        $row3 = mysqli_fetch_assoc($res3);
        $thoihanthe = $row3['GiaTri'];

        $khoangcachxb = "SELECT GiaTri FROM thamso WHERE TenThamSo = 'KhoangCachNamXB'";
        $res4 = mysqli_query($conn, $khoangcachxb);
        $row4 = mysqli_fetch_assoc($res4);
        $khoangcachxb = $row4['GiaTri'];

        $maxslngay = "SELECT GiaTri FROM thamso WHERE TenThamSo = 'SoNgayMuonToiDa'";
        $res5 = mysqli_query($conn, $maxslngay);
        $row5 = mysqli_fetch_assoc($res5);
        $maxslngay = $row5['GiaTri'];

        $maxslsach = "SELECT GiaTri FROM thamso WHERE TenThamSo = 'SoSachMuonToiDa'";
        $res6 = mysqli_query($conn, $maxslsach);
        $row6 = mysqli_fetch_assoc($res6);
        $maxslsach = $row6['GiaTri'];

        $tienphat = "SELECT GiaTri FROM thamso WHERE TenThamSo = 'TienPhatMoiNgay'";
        $res7 = mysqli_query($conn, $tienphat);
        $row7 = mysqli_fetch_assoc($res7);
        $tienphat = $row7['GiaTri'];

        $qd6 = "SELECT GiaTri FROM thamso WHERE TenThamSo = 'ApDungQD6'";
        $res8 = mysqli_query($conn, $qd6);
        $row8 = mysqli_fetch_assoc($res8);
        $qd6 = $row8['GiaTri'];

        if($tuoimin != $tuoitoithieu && $tuoitoithieu != '' && $tuoitoithieu > 0 && $tuoitoithieu < $tuoitoida){
            $sql1 = "UPDATE thamso SET GiaTri='$tuoitoithieu' WHERE TenThamSo = 'TuoiToiThieu'";
            if(mysqli_query($conn, $sql1)){
                $check=1;
                ?>
                <div class="divTBTKadmin thongbaoDoiTTTKTC">
                    <div class="thongbaosachmoi">
                        <div class="TBthemmoi divktimthay">
                            <div class="TBcontent theDGcontent">
                                <a href="option.php"><i class="bitrung fas fa-times"></i></a>
                                <h2>Đã thay đổi!</h2>
                                <div class="btn">
                                        <a href="option.php"><button>OK</button></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            }
        }
        else if($tuoimax != $tuoitoida && $tuoitoida != '' && $tuoitoida > 0 && $tuoitoida > $tuoitoithieu){
            $sql2 = "UPDATE thamso SET GiaTri='$tuoitoida' WHERE TenThamSo = 'TuoiToiDa'";
            if(mysqli_query($conn, $sql2)){
                $check=1;
                ?>
                <div class="divTBTKadmin thongbaoDoiTTTKTC">
                    <div class="thongbaosachmoi">
                        <div class="TBthemmoi divktimthay">
                            <div class="TBcontent theDGcontent">
                                <a href="option.php"><i class="bitrung fas fa-times"></i></a>
                                <h2>Đã thay đổi!</h2>
                                <div class="btn">
                                        <a href="option.php"><button>OK</button></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            }
        }
        else if($thoihan != $thoihanthe && $thoihan != '' && $thoihanthe > 0){
            $sql3 = "UPDATE thamso SET GiaTri='$thoihan' WHERE TenThamSo = 'ThoiHanThe'";
            if(mysqli_query($conn, $sql3)){
                $check=1;
                ?>
                <div class="divTBTKadmin thongbaoDoiTTTKTC">
                    <div class="thongbaosachmoi">
                        <div class="TBthemmoi divktimthay">
                            <div class="TBcontent theDGcontent">
                                <a href="option.php"><i class="bitrung fas fa-times"></i></a>
                                <h2>Đã thay đổi!</h2>
                                <div class="btn">
                                        <a href="option.php"><button>OK</button></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            }
        }
        else if($kcxb != $khoangcachxb && $kcxb != '' && $kcxb > 0){
            $sql4 = "UPDATE thamso SET GiaTri='$kcxb' WHERE TenThamSo = 'KhoangCachNamXB'";
            if(mysqli_query($conn, $sql4)){
                $check=1;
                ?>
                <div class="divTBTKadmin thongbaoDoiTTTKTC">
                    <div class="thongbaosachmoi">
                        <div class="TBthemmoi divktimthay">
                            <div class="TBcontent theDGcontent">
                                <a href="option.php"><i class="bitrung fas fa-times"></i></a>
                                <h2>Đã thay đổi!</h2>
                                <div class="btn">
                                        <a href="option.php"><button>OK</button></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            }
        }
        else if($songaymuontoida != $maxslngay && $songaymuontoida != '' && $songaymuontoida > 0){
            $sql5 = "UPDATE thamso SET GiaTri='$songaymuontoida' WHERE TenThamSo = 'SoNgayMuonToiDa'";
            if(mysqli_query($conn, $sql5)){
                $check=1;
                ?>
                <div class="divTBTKadmin thongbaoDoiTTTKTC">
                    <div class="thongbaosachmoi">
                        <div class="TBthemmoi divktimthay">
                            <div class="TBcontent theDGcontent">
                                <a href="option.php"><i class="bitrung fas fa-times"></i></a>
                                <h2>Đã thay đổi!</h2>
                                <div class="btn">
                                        <a href="option.php"><button>OK</button></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <?php
            }
        }
        else if($sosachmuontoida != $maxslsach && $sosachmuontoida != '' && $sosachmuontoida > 0){
            $sql6 = "UPDATE thamso SET GiaTri='$sosachmuontoida' WHERE TenThamSo = 'SoSachMuonToiDa'";
            if(mysqli_query($conn, $sql6)){
                $check=1;
                ?>
                <div class="divTBTKadmin thongbaoDoiTTTKTC">
                    <div class="thongbaosachmoi">
                        <div class="TBthemmoi divktimthay">
                            <div class="TBcontent theDGcontent">
                                <a href="option.php"><i class="bitrung fas fa-times"></i></a>
                                <h2>Đã thay đổi!</h2>
                                <div class="btn">
                                        <a href="option.php"><button>OK</button></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <?php
            }
        }
        else if($tienphat != $tienphatmoingay && $tienphatmoingay != '' && $tienphatmoingay > 0){
            $sql7 = "UPDATE thamso SET GiaTri='$tienphatmoingay' WHERE TenThamSo = 'TienPhatMoiNgay'";
            if(mysqli_query($conn, $sql7)){
                $check=1;
                ?>
                <div class="divTBTKadmin thongbaoDoiTTTKTC">
                    <div class="thongbaosachmoi">
                        <div class="TBthemmoi divktimthay">
                            <div class="TBcontent theDGcontent">
                                <a href="option.php"><i class="bitrung fas fa-times"></i></a>
                                <h2>Đã thay đổi!</h2>
                                <div class="btn">
                                        <a href="option.php"><button>OK</button></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <?php
            }
        }
        
        
        if($check!=1){
            ?>
                <div class="divTBTKadmin thongbaoDoithaydoitrung">
                    <div class="thongbaosachmoi">
                        <div class="TBthemmoi divktimthay">
                            <div class="TBcontent theDGcontent">
                                <a class="closethaydoi"><i class="bitrung fas fa-times"></i></a>
                                <h2>Không thể thay đổi giá trị do vi phạm ràng điều kiện trong lưu ý hoặc giá trị thay đổi bị trùng hoặc rỗng!</h2>
                                <div class="btn" style="justify-content: center;">
                                   <button class="btnclosethaydoi">OK</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <script>
                    document.querySelector(".btnclosethaydoi").addEventListener("click", function(){
                        document.querySelector(".thongbaoDoithaydoitrung").classList.add("action");
                    })
                    document.querySelector(".closethaydoi").addEventListener("click", function(){
                        document.querySelector(".thongbaoDoithaydoitrung").classList.add("action");
                    })
                </script>
            <?php
        }
    }
    mysqli_close($conn);
?>

</body>
</html>