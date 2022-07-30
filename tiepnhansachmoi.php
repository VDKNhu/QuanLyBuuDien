
<?php
require('dbconnect.php');
require('Classes/PHPExcel.php');
error_reporting(E_ERROR);

if(isset($_POST['btnGuiTacGia'])){
    $file = $_FILES['file']['tmp_name'];
    
    $objReader= PHPExcel_IOFactory::createReaderForFile($file);
    $objReader->setLoadSheetsOnly('Sheet1');

    $objExcel= $objReader->load($file);
    $sheetData= $objExcel->getActiveSheet()->toArray('null',true,true,true);

    $highestRow= $objExcel->setActiveSheetIndex()->getHighestRow();
  
    for($row=1; $row<=$highestRow; $row++){
        $hoten=$sheetData[$row]['A']; 
 
        $k=0;                                                                                                      
        $sql2="SELECT TenTacGia FROM tacgia ";                                                                        
        if(!$result2=$mysqli->query($sql2)) echo 'Loi2: '.$mysqli->error;                                                                           
        while($t2=$result2->fetch_assoc()){
            if ($hoten==$t2["TenTacGia"]) $k=1;
        }
        if($k==0){
            $sql4="INSERT INTO tacgia(TenTacGia) VALUES ('$hoten')";
            if(!$mysqli->query($sql4)) echo 'Loi4: '.$mysqli->error;	
        }}
        ?>
        <div class="thongbaosachmoi importTC divphieuthu">
                                    <div class="TBthemmoi divktimthay">
                                        <div class="TBcontent theDGcontent">
                                            <h2>Đã Import tác giả!</h2>
                                            
                                            <form enctype="multipart/form-data" method="POST" >
                                                <div class="btn closephieumuonsach" style="display: flex; justify-content: center;">
                                                    <button name="importTGTC" type="submit" >OK</button>
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
//require('Classes/PHPExcel.php');
error_reporting(E_ERROR);//Sau khi dam bao file chay hoan hao, dung error_reporting de remove cac warnings, 
//notice va error khong hien ra browser

if(isset($_POST['btnGuiSach'])){
    $file = $_FILES['file']['tmp_name'];
    
    $objReader= PHPExcel_IOFactory::createReaderForFile($file);
    $objReader->setLoadSheetsOnly('Sheet1');

    $objExcel= $objReader->load($file);
    $sheetData= $objExcel->getActiveSheet()->toArray('null',true,true,true);

    $highestRow= $objExcel->setActiveSheetIndex()->getHighestRow();
    $tongtien=0;
    
    //do ct_pns tham chieu den phieunhapsach, nen phai tao SoPNS truoc, sau do thoat khoi vong while moi insert tổng tiền dòng 171
	$ngaynhap=date("Y-m-d");
	$sql20="INSERT INTO phieunhapsach(NgayLap) VALUES ('$ngaynhap')";
	if(!$mysqli->query($sql20)) echo 'Loi20: '.$mysqli->error;
    //Lay SoPNS 
    $sql1="SELECT max(SoPNS) as SoPNS FROM phieunhapsach";
    $result=$mysqli->query($sql1);
    $t=$result->fetch_assoc(); 
	$e=$t["SoPNS"];

	$mangtensach1[0]='0';
    $mangtheloai1[0]='0';
    $chiso1=0;

    $mangtensach2[0]='0';
    $mangtheloai2[0]='0';
    $chiso2=0;

    for($row=1; $row<=$highestRow; $row++){
	//Gan cac gia tri tu cac cot trong excel vao cac bien
    $tensach=$sheetData[$row]['A'];
	$theloai=$sheetData[$row]['B'];
	$namxb=$sheetData[$row]['C'];
	$nhaxb=$sheetData[$row]['D'];
	$dongia=$sheetData[$row]['E'];
	$soluongnhap=$sheetData[$row]['F'];
	$thanhtien=$sheetData[$row]['G'];
	$tacgia1=$sheetData[$row]['H'];
	$tacgia2=$sheetData[$row]['I'];
	$tacgia3=$sheetData[$row]['J'];
	$tacgia4=$sheetData[$row]['K'];
	$tacgia5=$sheetData[$row]['L'];

	$thoihan=date("Y")-($namxb);
	$sql="SELECT GiaTri FROM thamso WHERE TenThamSo='KhoangCachNamXB'";
	$result=$mysqli->query($sql);
	if($t=$result->fetch_assoc()) {
		$khoangcachxb=$t["GiaTri"];}

	if($thoihan<=$khoangcachxb){	
	
	$tongtien = $tongtien + $thanhtien;

    $demsotg=0;
    if($tacgia1!='NULL') $demsotg++;
    if($tacgia2!='NULL') $demsotg++;
    if($tacgia3!='NULL') $demsotg++;
    if($tacgia4!='NULL') $demsotg++;
    if($tacgia5!='NULL') $demsotg++;

	//Xet xem the loai co trong bang theloai khong?
	$k=0;
	$sql="SELECT TenTheLoai FROM theloai";
	$result=$mysqli->query($sql);
	while($t=$result->fetch_assoc()){
		if ($theloai==$t["TenTheLoai"]) $k=1;
	}
	if($k==0){
		$sql="INSERT INTO theloai(TenTheLoai) VALUES ('$theloai')";
		if(!$mysqli->query($sql)) echo 'Loi: '.$mysqli->error;
	}

	//Lay MaTheLoai trong db ung voi gia tri $theloai
	$sql2="SELECT MaTheLoai FROM theloai WHERE TenTheLoai='$theloai'";
	$result=$mysqli->query($sql2);
	if($t= $result->fetch_assoc()) {$a=$t["MaTheLoai"];}

	//Kiem tra xem co cung MaDauSach khong?
	$sql4="SELECT TenDauSach,MaTheLoai,NamXuatBan,NhaXuatBan,dausach.MaDauSach as MDS,MaSach
	      FROM sach inner join dausach on sach.MaDauSach=dausach.MaDauSach
          WHERE TenDauSach='$tensach' and MaTheLoai=$a";
	$result=$mysqli->query($sql4);
	$chon=0;
    if($result->num_rows>0){
		while($t = $result->fetch_assoc()){
			if(($t["NhaXuatBan"]==$nhaxb)&&($t["NamXuatBan"]==$namxb)){
				$chon=1;
                $z=$t["MaSach"];
                $r=$t["MDS"];
                
			}
			if($chon!=1){
				$chon=2;
				$r=$t["MDS"];
			}
		}
    }

    if(($chon==1)||($chon==2)){
        $sql89="SELECT count(MaTacGia) as sltg from ct_tacgia where MaDauSach='$r'";
        if(!$result89=$mysqli->query($sql89)) echo 'Loi89: '.$mysqli->error;
        $kq89=$result89->fetch_assoc();
        $sotg=$kq89["sltg"];

        $sql90="SELECT TenTacGia from ct_tacgia inner join tacgia on ct_tacgia.MaTacGia=tacgia.MaTacGia
                where MaDauSach='$r'";
        if(!$result90=$mysqli->query($sql90)) echo 'Loi90: '.$mysqli->error;
        while($sl=$result90->fetch_assoc()){
            $tentg=$sl["TenTacGia"];
            if($sotg!=$demsotg) $chon=3;
            else{
                if(!(($tacgia1==$tentg)||($tacgia2==$tentg)||($tacgia3==$tentg)||($tacgia4==$tentg)||($tacgia5==$tentg))) $chon=3;
            }
        }
    }

		switch($chon){
			case (0):
				$sql5="INSERT INTO dausach(TenDauSach,MaTheLoai,DaXoa) VALUES ('$tensach','$a',0)";
				if(!$mysqli->query($sql5)) echo 'Loi2: '. $mysqli->error;
				
				//Lay MaDauSach vua them
				$sql6="SELECT max(MaDauSach) as MaDS FROM dausach";
				$m=$mysqli->query($sql6);
				if ($x=$m->fetch_assoc()) {$b=$x["MaDS"];}

                //Them tacgia vao cac bang lien quan
                if($tacgia1!='NULL'){
                $k=0;                                                                                                      
                $sql="SELECT TenTacGia FROM tacgia ";                                                                        
                if(!$result=$mysqli->query($sql)) echo 'Loi34: '.$mysqli->error;                                                                           
                while($t=$result->fetch_assoc()){
                    if ($tacgia1==$t["TenTacGia"]) $k=1;
                }
                if($k==0){
                    $sql4="INSERT INTO tacgia(TenTacGia) VALUES ('$tacgia1')";
                    if(!$mysqli->query($sql4)) echo 'Loi: '.$mysqli->error;	
                }

                $sql3="SELECT MaTacGia FROM tacgia WHERE TenTacGia='$tacgia1'";
                $result=$mysqli->query($sql3);
                if($t= $result->fetch_assoc()) {$c=$t["MaTacGia"];}
				//Them MaTacGia vao ct_tacgia cung voi MaDauSach
				$sql7="INSERT INTO ct_tacgia(MaDauSach,MaTacGia) VALUES ('$b','$c')";
        		if(!$mysqli->query($sql7)) echo 'Loi3: '. $mysqli->error;

                if($tacgia2!='NULL'){
                $k=0;                                                                                                      
                $sql="SELECT TenTacGia FROM tacgia ";                                                                        
                $result=$mysqli->query($sql);                                                                               
                while($t=$result->fetch_assoc()){
                    if ($tacgia2==$t["TenTacGia"]) $k=1;
                }
                if($k==0){
                    $sql4="INSERT INTO tacgia(TenTacGia) VALUES ('$tacgia2')";
                    if(!$mysqli->query($sql4)) echo 'Loi: '.$mysqli->error;	
                }

                $sql3="SELECT MaTacGia FROM tacgia WHERE TenTacGia='$tacgia2'";
                $result=$mysqli->query($sql3);
                if($t= $result->fetch_assoc()) {$c=$t["MaTacGia"];}

				//Them MaTacGia vao ct_tacgia cung voi MaDauSach
				$sql7="INSERT INTO ct_tacgia(MaDauSach,MaTacGia) VALUES ('$b','$c')";
        		if(!$mysqli->query($sql7)) echo 'Loi3: '. $mysqli->error;

                if($tacgia3!='NULL'){
                $k=0;                                                                                                      
                $sql="SELECT TenTacGia FROM tacgia ";                                                                        
                $result=$mysqli->query($sql);                                                                               
                while($t=$result->fetch_assoc()){
                    if ($tacgia3==$t["TenTacGia"]) $k=1;
                }
                if($k==0){
                    $sql4="INSERT INTO tacgia(TenTacGia) VALUES ('$tacgia3')";
                    if(!$mysqli->query($sql4)) echo 'Loi: '.$mysqli->error;	
                }

                $sql3="SELECT MaTacGia FROM tacgia WHERE TenTacGia='$tacgia3'";
                $result=$mysqli->query($sql3);
                if($t= $result->fetch_assoc()) {$c=$t["MaTacGia"];}

				//Them MaTacGia vao ct_tacgia cung voi MaDauSach
				$sql7="INSERT INTO ct_tacgia(MaDauSach,MaTacGia) VALUES ('$b','$c')";
        		if(!$mysqli->query($sql7)) echo 'Loi3: '. $mysqli->error;

                if($tacgia4!='NULL'){
                $k=0;                                                                                                      
                $sql="SELECT TenTacGia FROM tacgia ";                                                                        
                $result=$mysqli->query($sql);                                                                               
                while($t=$result->fetch_assoc()){
                    if ($tacgia4==$t["TenTacGia"]) $k=1;
                }
                if($k==0){
                    $sql4="INSERT INTO tacgia(TenTacGia) VALUES ('$tacgia4')";
                    if(!$mysqli->query($sql4)) echo 'Loi: '.$mysqli->error;	
                }

                $sql3="SELECT MaTacGia FROM tacgia WHERE TenTacGia='$tacgia4'";
                $result=$mysqli->query($sql3);
                if($t= $result->fetch_assoc()) {$c=$t["MaTacGia"];}

				//Them MaTacGia vao ct_tacgia cung voi MaDauSach
				$sql7="INSERT INTO ct_tacgia(MaDauSach,MaTacGia) VALUES ('$b','$c')";
        		if(!$mysqli->query($sql7)) echo 'Loi3: '. $mysqli->error;

                if($tacgia5!='NULL'){
                $k=0;                                                                                                      
                $sql="SELECT TenTacGia FROM tacgia ";                                                                        
                $result=$mysqli->query($sql);                                                                               
                while($t=$result->fetch_assoc()){
                    if ($tacgia5==$t["TenTacGia"]) $k=1;
                }
                if($k==0){
                    $sql4="INSERT INTO tacgia(TenTacGia) VALUES ('$tacgia5')";
                    if(!$mysqli->query($sql4)) echo 'Loi: '.$mysqli->error;	
                }

                $sql3="SELECT MaTacGia FROM tacgia WHERE TenTacGia='$tacgia5'";
                $result=$mysqli->query($sql3);
                if($t= $result->fetch_assoc()) {$c=$t["MaTacGia"];}

				//Them MaTacGia vao ct_tacgia cung voi MaDauSach
				$sql7="INSERT INTO ct_tacgia(MaDauSach,MaTacGia) VALUES ('$b','$c')";
        		if(!$mysqli->query($sql7)) echo 'Loi3: '. $mysqli->error;}}}}}

				//Them thong tin vao db sach
				$sql8="INSERT INTO sach(MaDauSach,NhaXuatBan,NamXuatBan,SoLuong,GiaTien,DaXoa) VALUES ('$b','$nhaxb','$namxb','$soluongnhap','$dongia',0)";
        		if(!$mysqli->query($sql8)) echo 'Loi4: '. $mysqli->error;
	
				//Lay MaSach vua them
				$sql9="SELECT max(MaSach) as MaS FROM sach";
				$m=$mysqli->query($sql9);
				if ($x=$m->fetch_assoc()) {$d=$x["MaS"];}

				//Them thong tin vao db cuonsach
				for ($dem=0;$dem<$soluongnhap;$dem++){
					$sql10="INSERT INTO cuonsach(MaSach,TinhTrang,DaXoa) VALUES ('$d','Con',0)";
        			if(!$mysqli->query($sql10)) echo 'Loi5: '. $mysqli->error;
				}

				//Them thong tin vao db ct_pns
				$sql11="INSERT INTO ct_phieunhapsach(SoPNS,MaSach,SoLuongNhap,DonGia,ThanhTien) VALUES ($e,$d,'$soluongnhap','$dongia','$thanhtien')";
				if(!$mysqli->query($sql11)) echo 'Loi6: '. $mysqli->error;
				break;
			case (1):
				//Them thong tin vao db cuonsach
                $sql23="SELECT DonGia from ct_phieunhapsach where MaSach='$z'";
                if(!$result23=$mysqli->query($sql23)) echo 'Loi23: '.$mysqli->error;
                $ase=$result23->fetch_assoc();
                $ktdg=$ase["DonGia"];

                if($ktdg==$dongia){
				for ($dem=0;$dem<$soluongnhap;$dem++){
					$sql13="INSERT INTO cuonsach(MaSach,TinhTrang,DaXoa) VALUES ('$z','Con',0)";
        			if(!$mysqli->query($sql13)) echo 'Loi7: '. $mysqli->error;
				}
					
				$sql20="UPDATE sach SET SoLuong= (SoLuong + $soluongnhap) WHERE MaSach=$z";
				if(!$mysqli->query($sql20)) echo 'Loi20: '.$mysqli->error;
				
				$sql14="INSERT INTO ct_phieunhapsach(SoPNS,MaSach,SoLuongNhap,DonGia,ThanhTien) VALUES ('$e','$z','$soluongnhap','$dongia','$thanhtien')";
				if(!$mysqli->query($sql14)) echo 'Loi8: '. $mysqli->error;}
                else{
                    $mangtensach1[$chiso1]=$tensach;
                    $mangtheloai1[$chiso1]=$theloai;
                    $chiso1++;
                    
                }
                
				break;
			case (2):
				$sql15="INSERT INTO sach(MaDauSach,NhaXuatBan,NamXuatBan,SoLuong,GiaTien,DaXoa) VALUES ($r,'$nhaxb','$namxb','$soluongnhap','$dongia',0)";
				if(!$mysqli->query($sql15)) echo 'Loi9: '. $mysqli->error;

				//Lay MaSach vua them
				$sql16="SELECT max(MaSach) as MaS FROM sach";
				$m=$mysqli->query($sql16);
				if ($x=$m->fetch_assoc()) {$y=$x["MaS"];}

				for ($dem=0;$dem<$soluongnhap;$dem++){
					$sql19="INSERT INTO cuonsach(MaSach,TinhTrang,DaXoa) VALUES ('$y','Con',0)";
        			if(!$mysqli->query($sql19)) echo 'Loi19: '. $mysqli->error;
				}
				
				//Them vao ct_pns
				$sql30="INSERT INTO ct_phieunhapsach(SoPNS,MaSach,SoLuongNhap,DonGia,ThanhTien) VALUES ('$e','$y','$soluongnhap','$dongia','$thanhtien')";
				if(!$mysqli->query($sql30)) echo 'Loi30: '. $mysqli->error;
				break;	
            case(3):
                $mangtensach2[$chiso2]=$tensach;
                $mangtheloai2[$chiso2]=$theloai;
                $chiso2++;
				
                break;
						
		}
	}
}
	//Them tổng tiền vao db phieunhapsach
	$sql="UPDATE phieunhapsach SET TongTien=$tongtien 
		  WHERE SoPNS=$e";
	if(!$mysqli->query($sql)) echo 'Loi29: '. $mysqli->error;
    // echo $mangtensach1[0];
    if(($mangtensach1[0]!='0')||($mangtensach2[0]!='0')){
                        if($mangtensach1[0]!='0'){
                            foreach($mangtensach1 as $tensach){
                                foreach($mangtheloai1 as $theloai){
                                ?>
                                <div >
                                    <div class="thongbaosachmoi tbaosachsai  divphieuthu">
                                        <div class="TBthemmoi divktimthay">
                                            <div class="TBcontent theDGcontent">
                                                <h2>Bạn đã nhập sai thông tin của sách:<?php echo " ". $tensach." có thể loại ".$theloai ?></h2>
                                                
                                                <div class="btn closephieumuonsach">
                                                    <button class="tatTB">OK</button>
                                                </div> 
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }}
                        }

                        if($mangtensach2[0]!='0'){
                            foreach($mangtensach2 as $tensach){
                                foreach($mangtheloai2 as $theloai){
                                ?>
                                        <div >
                                            <div class="thongbaosachmoi tbaosachsai  divphieuthu">
                                                <div class="TBthemmoi divktimthay">
                                                    <div class="TBcontent theDGcontent">
                                                        <h2>Bạn đã nhập sai tên tác giả hoặc số lượng tác giả của sách:<?php echo " ". $tensach." có thể loại ".$theloai ?></h2>
                                                        
                                                        <div class="btn closephieumuonsach">
                                                            <button class="tatTB">OK</button>
                                                        </div> 
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php
                            }}}
	
				?>
				<script>
				const tatTB=document.querySelectorAll(".tatTB");
				const  thongbaosachsai=document.querySelectorAll(".tbaosachsai");
				for (let i=0;i<tatTB.length;i++){
					tatTB[i].addEventListener("click",function(){
						thongbaosachsai[i].classList.add("action");
					})
				}
				</script>
                <?php
    } else{
                ?>
                <div class="thongbaosachmoi importTC divphieuthu">
                                    <div class="TBthemmoi divktimthay">
                                        <div class="TBcontent theDGcontent">
                                            <h2>Đã Import sách!</h2>
                                            
                                            <form enctype="multipart/form-data" method="POST" >
                                                <div class="btn closephieumuonsach" style="display: flex; justify-content: center;">
                                                    <button name="importTGTC" type="submit" >OK</button>
                                                </div> 
                                            </form>
                                        </div>
                                    </div>
                                </div>

 				 <?php
        }
    $mysqli->close();
}


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
    <link rel="stylesheet" href="style-table.css">
    <link rel="stylesheet" href="style-ltdg.css">
    <link rel="stylesheet" href="style-option.css">
    <link rel="stylesheet" href="style_thongbao.css">
    <script src="js_tiepnhansachmoi.js" defer></script>
    <script src="js-thaydoisach.js" defer></script>
    <script src="jsbaocao.js" defer></script>
    <title>Quản lí sách</title>
</head>
<body>
    <div class="thongbaosachmoi TBthanhcong action">
        <div class="TBthemmoi">
            <div class="TBcontent">
                <h1>Thêm sách thành công!</h1>
                <button class="ok">
                    OK
                </button>
            </div>
        </div>
    </div>   
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
                    <li class="select backgd"><a href="tiepnhansachmoi.php" class="newbooks">Quản lí sách</a></li>
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
    <h1 style="margin-top: 80px; text-align:center; font-size:50px;">Quản lí sách</h1>
    <div class="tiepnhansachmoi divContent main"  id="Themsachmoi">
            <div class="navbar">
                <h2>Nhập thông tin sách mới</h2>
                <b><i>Lưu ý:</i></b><br>
                <i>Nếu nhập sách mới có tên đầu sách trùng với tên đầu sách đã nhập trước đây, thì tác giả và thể loại của đầu sách này cũng phải trùng với tác giả và thể loại của đầu sách đã nhập!</i><br>
                <i>Nếu nhập sách mới có tên đầu sách, nhà xuất bản, năm xuất bản trùng với đầu sách đã nhập trước đây, thì tác giả, thể loại, trị giá của đầu sách này cũng phải trùng với tác giả, thể loại, trị giá của đầu sách đã nhập!</i><br>
                <form class="formMain" action="book.php" method="POST">
                    <div>
                        Tên sách:
                        <input type="text" name="tensach" placeholder="Nhập tên sách" required>
                    </div>
                    <div id="themtacgia" class="navcss">
                        <div class="csssach">
                            Tác giả:
                            <div class="plusinput">
                                <div class="navbarTG" >
                                    <select name="tacgia1" id="tacgia" class="tacgia" value = "selected">
                                        <option value="selected">-Chọn-</option>
                                        <?php
                                            $conn = mysqli_connect('localhost', 'root','', 'quanlythuvien');
                                            $sql = "SELECT * FROM `tacgia` WHERE DaXoa=0";
                                            $result = mysqli_query($conn, $sql);
                                            if(mysqli_num_rows($result) > 0){
                                                while ($row = mysqli_fetch_assoc($result)){
                                                    ?>
                                                    <option value="<?php echo $row['MaTacGia']?>">
                                                        <?php echo $row['TenTacGia']?>
                                                    </option>
                                                    <?php
                                                }
                                            }
                                            mysqli_close($conn);
                                            ?>
                                    </select>
                                    <i class="fas fa-plus plusbtn"></i>
                                </div>
                                <div class="navbarTG action">
                                    <select name="tacgia2" id="tacgia" class="tacgia" value = "selected">
                                        <option value="selected">-Chọn-</option>
                                        <?php
                                            $conn = mysqli_connect('localhost', 'root','', 'quanlythuvien');
                                            $sql = "SELECT * FROM `tacgia` WHERE DaXoa=0";
                                            $result = mysqli_query($conn, $sql);
                                            if(mysqli_num_rows($result) > 0){
                                                while ($row = mysqli_fetch_assoc($result)){
                                                    ?>
                                                    <option value="<?php echo $row['MaTacGia']?>">
                                                        <?php echo $row['TenTacGia']?>
                                                    </option>
                                                    <?php
                                                }
                                            }
                                            mysqli_close($conn);
                                        ?>
                                    </select>
                                    <i class="fas fa-plus plusbtn"></i>
                                </div>
                                <div class="navbarTG action">
                                    <select name="tacgia3" id="tacgia" class="tacgia" value = "selected">
                                        <option value="selected">-Chọn-</option>
                                        <?php
                                            $conn = mysqli_connect('localhost', 'root','', 'quanlythuvien');
                                            $sql = "SELECT * FROM `tacgia` WHERE DaXoa=0";
                                            $result = mysqli_query($conn, $sql);
                                            if(mysqli_num_rows($result) > 0){
                                                while ($row = mysqli_fetch_assoc($result)){
                                                    ?>
                                                    <option value="<?php echo $row['MaTacGia']?>">
                                                        <?php echo $row['TenTacGia']?>
                                                    </option>
                                                    <?php
                                                }
                                            }
                                            mysqli_close($conn);
                                        ?>
                                    </select>
                                    <i class="fas fa-plus plusbtn"></i>
                                </div>
                                <div class="navbarTG action">
                                    <select name="tacgia4" id="tacgia" class="tacgia" value = "selected">
                                        <option value="selected">-Chọn-</option>
                                        <?php
                                            $conn = mysqli_connect('localhost', 'root','', 'quanlythuvien');
                                            $sql = "SELECT * FROM `tacgia` WHERE DaXoa=0";
                                            $result = mysqli_query($conn, $sql);
                                            if(mysqli_num_rows($result) > 0){
                                                while ($row = mysqli_fetch_assoc($result)){
                                                    ?>
                                                    <option value="<?php echo $row['MaTacGia']?>">
                                                        <?php echo $row['TenTacGia']?>
                                                    </option>
                                                    <?php
                                                }
                                            }
                                            mysqli_close($conn);
                                        ?>
                                    </select>
                                    <i class="fas fa-plus plusbtn"></i>
                                </div>
                                <div class="navbarTG action">
                                    <select name="tacgia5" id="tacgia" class="tacgia5" value = "selected">
                                        <option value="selected">-Chọn-</option>
                                        <?php
                                            $conn = mysqli_connect('localhost', 'root','', 'quanlythuvien');
                                            $sql = "SELECT * FROM `tacgia` WHERE DaXoa=0";
                                            $result = mysqli_query($conn, $sql);
                                            if(mysqli_num_rows($result) > 0){
                                                while ($row = mysqli_fetch_assoc($result)){
                                                    ?>
                                                    <option value="<?php echo $row['MaTacGia']?>">
                                                        <?php echo $row['TenTacGia']?>
                                                    </option>
                                                    <?php
                                                }
                                            }
                                            mysqli_close($conn);
                                        ?>
                                    </select>
                                    <i class="fas fa-plus plusbtn"></i>
                                </div>
                            </div>
                        </div>
                        <div>
                                <div class="csssach action inputM">
                                    Họ tên tác giả mới:
                                    <div class="cssinput">
                                        <div class="Width"> 
                                            <div class="Flex">
                                                <input style="margin-left: 0;" type="text" name="TGM1" placeholder="Nhập họ tên tác giả mới">
                                                <i class="fas fa-plus jsbtnM"></i>
                                            </div>
                                        </div>
                                        <div class="navbarM Width action">
                                            <div class="Flex">
                                                <input style="margin-left: 0;" type="text" name="TGM2" placeholder="Nhập họ tên tác giả mới">
                                                <i class="fas fa-plus jsbtnM"></i>
                                            </div>
                                        </div>
                                        <div class="navbarM Width action">
                                            <div class="Flex">
                                                <input style="margin-left: 0;" type="text" name="TGM3" placeholder="Nhập họ tên tác giả mới">
                                                <i class="fas fa-plus jsbtnM"></i>
                                            </div>
                                        </div>
                                        <div class="navbarM Width action">
                                            <div class="Flex">
                                                <input style="margin-left: 0;" type="text" name="TGM4" placeholder="Nhập họ tên tác giả mới">
                                                <i class="fas fa-plus jsbtnM"></i>
                                            </div>
                                        </div>
                                        <div class="navbarM Width action">
                                            <div class="Flex">
                                                <input style="margin-left: 0;" type="text" name="TGM5" placeholder="Nhập họ tên tác giả mới">
                                                <i class="fas fa-plus"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <a class="TGmoi navM"><i>Tác giả mới</i></a>
                        </div>
                    </div>
                    
                    <div id="themtheloai" class="navcss">
                            <div class="csssach">
                                Thể loại:
                                <div class="plusinput">
                                    <select name="theloai" id="kindBook" value = "selected">
                                        <option value="selected">-Chọn-</option>
                                        <?php
                                            $conn = mysqli_connect('localhost', 'root','', 'quanlythuvien');
                                            $sql = "SELECT * FROM `theloai` WHERE DaXoa=0";
                                            $result = mysqli_query($conn, $sql);
                                            if(mysqli_num_rows($result) > 0){
                                                while ($row = mysqli_fetch_assoc($result)){
                                                    ?>
                                                    <option value="<?php echo $row['MaTheLoai']?>">
                                                        <?php echo $row['TenTheLoai']?>
                                                    </option>
                                                    <?php
                                                }
                                            }
                                            mysqli_close($conn);
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div>
                                <div class="csssach action inputM">
                                    Thể loại sách mới:
                                    <input  class="cssinput" type="text" name="TL" placeholder="Nhập tên thể loại mới">
                                </div>
                                <a class="Smoi navM"><i>Thể loại mới</i></a>
                            </div>
                    </div>
                    <div id="themxuatban" class="navcss">
                        <div class="csssach">
                            Nhà xuất bản:
                            <input class="cssinput" type="text" name="nhaxuatban" placeholder="Nhập nhà xuất bản" required>
                        </div>
                        <div class="csssach">
                                Năm xuất bản:
                                <?php
                                    $conn = mysqli_connect('localhost', 'root','', 'quanlythuvien');

                                    $khoangcachxb="SELECT GiaTri FROM thamso WHERE TenThamSo='KhoangCachNamXB'";
                                    $res_kcxb = mysqli_query($conn, $khoangcachxb);
                                    $row_kcxb = mysqli_fetch_assoc($res_kcxb);
                                    $khoangcachxb = $row_kcxb['GiaTri'];

                                    $max = date("Y");
                                    $min = $max - $khoangcachxb;
                                
                                ?>
                                <input class="cssinput"  type="number" name="namxuatban" min="<?php echo $min ?>" max="<?php echo $max ?>" step="1" value="2021" placeholder="Nhập năm xuất bản" required>
                            </div>
                    </div>
                    <div class="navcss">
                        <div class="csssach">
                            Ngày nhập:
                            <input class="cssinput" value="<?php echo date("Y-m-d");?>" type="date" name="ngaynhap" placeholder="Ngày nhập sách" required>
                        </div>

                        <div class="csssach">
                            Trị giá (đồng):
                            <input  class="cssinput" type="number" name="trigia" placeholder="Nhập trị giá" min="1" required>
                        </div>
                        <div class="csssach slsach">
                            Số lượng sách:
                            <input  class="cssinput" type="number" name="tongsosach" placeholder="Nhập số lượng sách" min="1" required>
                        </div>
                    </div>
                    <div class="btn">
                        <button type="submit">Lưu</button>
                    </div>
                </form>
            </div>
    </div>

    <div class="main search">
            <div class=" importsach divContent">
                    <div class="chungMain " id="Import">
                        <h2>Nhập danh sách sách</h2>
                        <form class="formMain" method="POST" enctype="multipart/form-data">
                            <input type="file" name="file">
                            <button type="submit" name="btnGuiSach">Import</button>
                        </form>
                    </div>
                    <div>
                        <h2>Nhập danh sách tác giả</h2>
                        <div class="chungMain">
                            <form class="formMain" method="POST" enctype="multipart/form-data">
                                <input type="file" name="file">
                                <button type="submit" name="btnGuiTacGia">Import</button>
                            </form>
                        </div>
                    </div>
            </div>
            <div class="divContent thaydoi">
                <div class="thaydoitheloai">
                    <h2 style="display: flex; justify-content: space-between;">
                        <p>Thể loại sách</p>
                        <p id="DanhsachTheloai">Danh sách thể loại</p>
                    </h2>
                    <div class="formMain">
                        <form class="formthaydoi" enctype="multipart/form-data" method="POST">
                            <div>
                            Tên thể loại:
                            <input type="text" name="theloaisachmoi" placeholder="Nhập tên thể loại mới" required>
                            <br>
                            </div>
                            <div>
                                <button name="themtheloaisach" type="submit" class="them">Thêm</button>
                            </div>
                        </form>
                        <div>
                            <button id="xoaTL" class="xoa btnxoatheloai">Xóa</button>
                            <button class="sua btnsuatheloai">Sửa</button>
                        </div>
                    </div>
                    <?php
                        $conn=mysqli_connect('localhost','root','','quanlythuvien') or die('fail');

                        if(isset($_POST["themtheloaisach"])){
                            $tentl=$_POST["theloaisachmoi"];

                            $sql_kttl="SELECT * FROM theloai WHERE TenTheLoai='$tentl' AND DaXoa=0";
                            $res_kttl=mysqli_query($conn,$sql_kttl);
                            if(mysqli_num_rows($res_kttl)>0){
                                ?>
                                <div class="divTBTKadmin  thongbaocosachmuonquahan">
                                    <div class="thongbaosachmoi">
                                        <div class="TBthemmoi divktimthay">
                                            <div class="TBcontent theDGcontent">
                                                <i class="cosachmuonquahan fas fa-times"></i>
                                                <h2>Thông tin thể loại bị trùng!</h2>
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
                                        });
                                    }
                                </script>
                            <?php
                            }else{
                            $matl=0;
                            $daxoa=0;
                            $sql_tl="INSERT INTO theloai (MaTheLoai, TenTheLoai, DaXoa) VALUES ('$matl','$tentl','$daxoa')";
                            if(mysqli_query($conn,$sql_tl)){
                                ?>
                                <div class="thongbaosachmoi TBTDTTDN divphieuthu">
                                    <div class="TBthemmoi divktimthay">
                                        <div class="TBcontent theDGcontent">
                                            <h2>Đã thêm thể loại!</h2>
                                            
                                            <form enctype="multipart/form-data" method="POST" >
                                                <div class="btn closephieumuonsach">
                                                    <button name="tattb" type="submit" >OK</button>
                                                </div> 
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                
                            <?php
                            }
                        }
                    }
                    mysqli_close($conn);
                    ?>
                    <div class="divxoatheloai action ">
                        <div class="thongbaosachmoi  thongbaothaydoi">
                            <div class="TBthemmoi divktimthay">
                                <form enctype="multipart/form-data" method="POST">
                                    <div class="TBcontent theDGcontent">
                                        <i class="close fas fa-times"></i>
                                        <h2>Xóa thể loại sách</h2>
                                        <div class="csssach">
                                            <p>Chọn thể loại cần xóa:</p>
                                            <div class="plusinput">
                                                <select name="theloai" id="TLcanxoa" value = "selected" required>
                                                    <option value="">-Chọn-</option>
                                                    <?php
                                                        $conn = mysqli_connect('localhost', 'root','', 'quanlythuvien');
                                                        $sql = "SELECT * FROM `theloai` WHERE DaXoa=0";
                                                        $result = mysqli_query($conn, $sql);
                                                        if(mysqli_num_rows($result) > 0){
                                                            while ($row = mysqli_fetch_assoc($result)){
                                                                ?>
                                                                <option value="<?php echo $row['MaTheLoai']?>">
                                                                    <?php echo $row['TenTheLoai']?>
                                                                </option>
                                                                <?php
                                                            }
                                                        }
                                                        mysqli_close($conn);
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="btn closephieumuonsach">
                                            <button name = "xoa" type="submit" class="xoa">Xóa</button>
                                        </div> 
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <?php
                        $conn = mysqli_connect('localhost', 'root','', 'quanlythuvien');
                        if(isset($_POST["xoa"])){
                            $matheloai = $_POST["theloai"];

                            $sql_check="SELECT * FROM dausach WHERE DaXoa=0 AND MaTheLoai='$matheloai'";
                            if($res_check=mysqli_query($conn,$sql_check)){
                                if($row_check=mysqli_num_rows($res_check)>0){
                                    ?>
                                    <div class="divTBTKadmin  thongbaotheloaikthexoa">
                                        <div class="thongbaosachmoi">
                                            <div class="TBthemmoi divktimthay">
                                                <div class="TBcontent theDGcontent">
                                                    <i class="cosachthuocTL  fas fa-times"></i>
                                                    <h2>Không thể xóa thể loại vì tồn tại đầu sách thuộc thể loại này!</h2>
                                                    <div class="btn" style="display: flex; justify-content: center;">
                                                        <button class="cosachthuocTL">OK</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <script>
                                        const cosachthuocTL = document.querySelectorAll(".cosachthuocTL");
                                        for(let i = 0; i < cosachthuocTL.length; i++){
                                            cosachthuocTL[i].addEventListener("click", function(){
                                                document.querySelector(".thongbaotheloaikthexoa").classList.add("action");
                                            });
                                        }
                                    </script>
                                <?php    
                                }                           
                                else{
                                    $sql_xtl="UPDATE theloai SET DaXoa=1 WHERE MaTheLoai='$matheloai' AND DaXoa=0";
                                    if(mysqli_query($conn,$sql_xtl)){
                                        ?>
                                        <div class="thongbaosachmoi TBTDTTDN divphieuthu">
                                            <div class="TBthemmoi divktimthay">
                                                <div class="TBcontent theDGcontent">
                                                    <h2>Đã xóa thể loại!</h2>
                                                    
                                                    <form enctype="multipart/form-data" method="POST" >
                                                        <div class="btn closephieumuonsach">
                                                            <button name="tattb" type="submit" >OK</button>
                                                        </div> 
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    <?php
                                    }
                                }
                            }
        
                            }
                        mysqli_close($conn);
                    ?>
                    <div class="divsuatheloai action ">
                        <div class="thongbaosachmoi  thongbaothaydoi">
                            <div class="TBthemmoi divktimthay">
                                <form enctype="multipart/form-data" method="POST">
                                    <div class="TBcontent theDGcontent">
                                        <i class="close fas fa-times"></i>
                                        <h2>Sửa thể loại</h2>
                                        <div class="csssach">
                                                <p>Thể loại cũ:</p>
                                                <select name="theloai" id="TLcu" value = "selected" required>
                                                    <option value="">-Chọn-</option>
                                                    <?php
                                                        $conn = mysqli_connect('localhost', 'root','', 'quanlythuvien');
                                                        $sql = "SELECT * FROM `theloai` WHERE DaXoa=0";
                                                        $result = mysqli_query($conn, $sql);
                                                        if(mysqli_num_rows($result) > 0){
                                                            while ($row = mysqli_fetch_assoc($result)){
                                                                ?>
                                                                <option value="<?php echo $row['MaTheLoai']?>">
                                                                    <?php echo $row['TenTheLoai']?>
                                                                </option>
                                                                <?php
                                                            }
                                                        }
                                                        mysqli_close($conn);
                                                    ?>
                                                </select>
                                                <p>Thể loại mới:</p>
                                                <input type="text" placeholder="Nhập tên tác giả mới" name="tentlmoi" required>
                                        </div>
                                        <div class="btn closephieumuonsach">
                                            <button name = "sua" type="submit" class="xoa">Cập nhật</button>
                                        </div> 
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                        $conn = mysqli_connect('localhost', 'root','', 'quanlythuvien');
                        if(isset($_POST["sua"])){
                            $matheloai = $_POST["theloai"];
                            $tentlmoi=$_POST["tentlmoi"];

                            $sql_kttl="SELECT * FROM theloai WHERE TenTheLoai='$tentlmoi' AND DaXoa=0";
                            $res_kttl=mysqli_query($conn,$sql_kttl);
                            if(mysqli_num_rows($res_kttl)>0){
                                ?>
                                    <div class="divTBTKadmin  thongbaotheloaibitrung">
                                        <div class="thongbaosachmoi">
                                            <div class="TBthemmoi divktimthay">
                                                <div class="TBcontent theDGcontent">
                                                    <i class="theloaibitrung  fas fa-times"></i>
                                                    <h2>Thông tin thể loại bị trùng!</h2>
                                                    <div class="btn" style="display: flex; justify-content: center;">
                                                        <button class="theloaibitrung">OK</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <script>
                                        const theloaibitrung = document.querySelectorAll(".theloaibitrung");
                                        for(let i = 0; i < theloaibitrung.length; i++){
                                            theloaibitrung[i].addEventListener("click", function(){
                                                document.querySelector(".thongbaotheloaibitrung").classList.add("action");
                                            });
                                        }
                                    </script>
                                <?php
                            }
                            else{
                            $sql_stl="UPDATE theloai SET TenTheLoai='$tentlmoi' WHERE MaTheLoai='$matheloai'";
                            if(mysqli_query($conn,$sql_stl)){
                                ?>
                                <div>
                                    <div class="thongbaosachmoi TBTDTTDN divphieuthu">
                                        <div class="TBthemmoi divktimthay">
                                            <div class="TBcontent theDGcontent">
                                                <h2>Thay đổi thông tin thể loại thành công!</h2>
                                                
                                                <div class="btn closephieumuonsach">
                                                    <button id="tatTBTDTTDN">OK</button>
                                                </div> 
                                            </div>
                                        </div>
                                    </div>
                                    <script>
                                        document.getElementById("tatTBTDTTDN").addEventListener("click", function(){
                                            document.querySelector(".thongbaosachmoi").classList.add("action");
                                        })
                                    </script>
                                </div>
                                        <div class="thongbaosachmoi TBTDTTDN divphieuthu">
                                            <div class="TBthemmoi divktimthay">
                                                <div class="TBcontent theDGcontent">
                                                    <h2>Đã đổi tên thể loại!</h2>
                                                    
                                                    <form enctype="multipart/form-data" method="POST" >
                                                        <div class="btn closephieumuonsach">
                                                            <button name="tattb" type="submit" >OK</button>
                                                        </div> 
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                            <?php
                            }
                            }
                        }
                        mysqli_close($conn);
                    ?>

                <div class="thaydoitacgia">
                    <h2 style="display: flex; justify-content: space-between;">
                        <p>Tác giả</p>
                        <p id="DanhsachTacgia">Danh sách tác giả</p>
                    </h2>
                    <div class="formMain">
                        <form class="formthaydoi" enctype="multipart/form-data" method="POST">
                            <div style="display:flex; justify-content: space-between">
                                <p>Tên tác giả:</p>
                                <input style="width:230px; margin-left:0px;" type="text" name="tentacgiamoi" placeholder="Nhập tên tác giả mới" required>
                                <br>
                                <div style="margin-left:20px">
                                    <button name="themtacgiamoi" type="submit" class="them">Thêm</button>
                                </div>
                            </div>
                        </form>
                        <div>
                            <button id="xoaTG" class="xoa btnxoatacgia">Xóa</button>
                            <button class="sua btnsuatacgia">Sửa</button>
                        </div>
                    </div>
                    <?php
                        $conn=mysqli_connect('localhost','root','','quanlythuvien') or die('fail');

                        if(isset($_POST["themtacgiamoi"])){
                            $tentg=$_POST["tentacgiamoi"];

                            $sql_kttg="SELECT * FROM tacgia WHERE TenTacGia='$tentg' AND DaXoa=0";
                            if($res_kttg=mysqli_query($conn,$sql_kttg)){
                                    if(mysqli_num_rows($res_kttg)>0){
                                        ?>
                                        <div class="divTBTKadmin  thongbaoTTTGbitrung">
                                            <div class="thongbaosachmoi">
                                                <div class="TBthemmoi divktimthay">
                                                    <div class="TBcontent theDGcontent">
                                                        <i class="TTTGbitrung fas fa-times"></i>
                                                        <h2>Thông tin tác giả bị trùng!</h2>
                                                        <div class="btn" style="display: flex; justify-content: center;">
                                                            <button class="TTTGbitrung">OK</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <script>
                                            const TTTGbitrung = document.querySelectorAll(".TTTGbitrung");
                                            for(let i = 0; i < TTTGbitrung.length; i++){
                                                TTTGbitrung[i].addEventListener("click", function(){
                                                    document.querySelector(".thongbaoTTTGbitrung").classList.add("action");
                                                });
                                            }
                                        </script>
                                        <?php
                                    }
                                    else{
                                        $matg=0;
                                        $daxoa=0;
                                        $sql_tg="INSERT INTO tacgia (MaTacGia, TenTacGia, DaXoa) VALUES ('$matg','$tentg','$daxoa')";
                                        if(mysqli_query($conn,$sql_tg)){
                                            ?>
                                                <div class="thongbaosachmoi TBTDTTDN divphieuthu">
                                                    <div class="TBthemmoi divktimthay">
                                                        <div class="TBcontent theDGcontent">
                                                            <h2>Đã thêm tác giả mới!</h2>
                                                            
                                                            <form enctype="multipart/form-data" method="POST" >
                                                                <div class="btn closephieumuonsach">
                                                                    <button name="themTGmoi" type="submit" >OK</button>
                                                                </div> 
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                        <?php
                                        }
                                    }
                            }
                        }
                    
                
                    mysqli_close($conn);
                    ?>

                    <div class="divxoatacgia action">
                        <div class="thongbaosachmoi  thongbaothaydoi">
                            <div class="TBthemmoi divktimthay">
                                <form enctype="multipart/form-data" method="POST">
                                    <div class="TBcontent theDGcontent">
                                        <i class="close fas fa-times"></i>
                                        <h2>Xóa tác giả</h2>
                                        <div class="csssach">
                                            <p>Tác giả:</p>
                                                <select name="tacgia" id="tacgia" class="tacgia" value = "selected" required>
                                                    <option value="">-Chọn-</option>
                                                    <?php
                                                        $conn = mysqli_connect('localhost', 'root','', 'quanlythuvien');
                                                        $sql = "SELECT * FROM `tacgia` WHERE DaXoa=0";
                                                        $result = mysqli_query($conn, $sql);
                                                        if(mysqli_num_rows($result) > 0){
                                                            while ($row = mysqli_fetch_assoc($result)){
                                                                ?>
                                                                <option value="<?php echo $row['MaTacGia']?>">
                                                                    <?php echo $row['TenTacGia']?>
                                                                </option>
                                                                <?php
                                                            }
                                                        }
                                                            mysqli_close($conn);
                                                            ?>
                                                </select>
                                        </div>
                                        <div class="btn closephieumuonsach">
                                            <button name = "xoatg" type="submit" class="xoa">Xóa</button>
                                        </div> 
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <?php
                        $conn=mysqli_connect('localhost','root','','quanlythuvien') or die('fail');

                        if(isset($_POST["xoatg"])){
                            $matg=$_POST["tacgia"];

                            $mysql_check="SELECT * FROM ct_tacgia WHERE MaTacGia='$matg'";
                            if($res_check=mysqli_query($conn,$mysql_check)){
                                if($row_check=mysqli_num_rows($res_check)>0){
                                    ?>
                                    <div class="divTBTKadmin  tbkthexoaTG">
                                        <div class="thongbaosachmoi">
                                            <div class="TBthemmoi divktimthay">
                                                <div class="TBcontent theDGcontent">
                                                    <i class="kthexoaTG fas fa-times"></i>
                                                    <h2>Không thể xóa tác giả vì còn tồn tại đầu sách của tác giả đó!</h2>
                                                    <div class="btn" style="display: flex; justify-content: center;">
                                                        <button class="kthexoaTG">OK</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <script>
                                        const kthexoaTG = document.querySelectorAll(".kthexoaTG");
                                        for(let i = 0; i < kthexoaTG.length; i++){
                                            kthexoaTG[i].addEventListener("click", function(){
                                                document.querySelector(".tbkthexoaTG").classList.add("action");
                                            });
                                        }
                                    </script>
                                <?php       
                                }
                            
                            else{
                            $sql_kttg="UPDATE tacgia SET DaXoa=1 WHERE MaTacGia='$matg'";
                            if(mysqli_query($conn,$sql_kttg)){
                                ?>
                                        <div class="thongbaosachmoi TBTDTTDN divphieuthu">
                                            <div class="TBthemmoi divktimthay">
                                                <div class="TBcontent theDGcontent">
                                                    <h2>Đã xóa tác giả!</h2>
                                                    
                                                    <form enctype="multipart/form-data" method="POST" >
                                                        <div class="btn closephieumuonsach">
                                                            <button name="themTGmoi" type="submit" >OK</button>
                                                        </div> 
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                            <?php
                            }
                        }
                    }
                }
                    mysqli_close($conn);
                    ?>

                    <div class="divsuatacgia action">
                        <div class="thongbaosachmoi  thongbaothaydoi">
                            <div class="TBthemmoi divktimthay">
                                <form enctype="multipart/form-data" method="POST">
                                    <div class="TBcontent theDGcontent">
                                        <i class="close fas fa-times"></i>
                                        <h2>Sửa tác giả</h2>
                                        <div class="csssach">
                                                <p>Tác giả cũ:</p>
                                                <select name="tacgia" id="tacgia" class="tacgia" value = "selected" required>
                                                    <option value="">-Chọn-</option>
                                                    <?php
                                                        $conn = mysqli_connect('localhost', 'root','', 'quanlythuvien');
                                                        $sql = "SELECT * FROM `tacgia` WHERE DaXoa=0";
                                                        $result = mysqli_query($conn, $sql);
                                                        if(mysqli_num_rows($result) > 0){
                                                            while ($row = mysqli_fetch_assoc($result)){
                                                                ?>
                                                                <option value="<?php echo $row['MaTacGia']?>">
                                                                    <?php echo $row['TenTacGia']?>
                                                                </option>
                                                                <?php
                                                            }
                                                        }
                                                            mysqli_close($conn);
                                                            ?>
                                                </select>
                                                <p>Tác giả mới:</p>
                                                <input type="text" placeholder="Nhập tên tác giả mới" name="tentgmoi" required>
                                        </div>
                                        <div class="btn closephieumuonsach">
                                            <button name = "suatg" type="submit" class="xoa">Cập nhật</button>
                                        </div> 
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <?php
                        $conn=mysqli_connect('localhost','root','','quanlythuvien') or die('fail');

                        if(isset($_POST["suatg"])){
                            $matg=$_POST["tacgia"];
                            $tentgmoi=$_POST["tentgmoi"];

                                $sql_stg="SELECT * FROM tacgia WHERE MaTacGia='$matg' AND TenTacGia='$tentgmoi'AND DaXoa='0' ";
                                $res_stg=mysqli_query($conn,$sql_stg);
                                if(mysqli_num_rows($res_stg)>0){
                                    ?>
                                    <div class="divTBTKadmin  ThongBaoTTTGbitrung">
                                        <div class="thongbaosachmoi">
                                            <div class="TBthemmoi divktimthay">
                                                <div class="TBcontent theDGcontent">
                                                    <i class="TTTGBiTrung fas fa-times"></i>
                                                    <h2>Thông tin độc giả bị trùng!</h2>
                                                    <div class="btn" style="display: flex; justify-content: center;">
                                                        <button class="TTTGBiTrung">OK</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <script>
                                        const TTTGBiTrung = document.querySelectorAll(".TTTGBiTrung");
                                        for(let i = 0; i < TTTGBiTrung.length; i++){
                                            TTTGBiTrung[i].addEventListener("click", function(){
                                                document.querySelector(".ThongBaoTTTGbitrung").classList.add("action");
                                            });
                                        }
                                    </script>
                                <?php
                                }
                                else{
                                $sql_stg="UPDATE tacgia SET TenTacGia='$tentgmoi' WHERE MaTacGia='$matg'";
                                if(mysqli_query($conn,$sql_stg)){
                                    ?>
                                        <div class="thongbaosachmoi TBTDTTDN divphieuthu">
                                            <div class="TBthemmoi divktimthay">
                                                <div class="TBcontent theDGcontent">
                                                    <h2>Đã sửa thông tin tác giả!</h2>
                                                    
                                                    <form enctype="multipart/form-data" method="POST" >
                                                        <div class="btn closephieumuonsach">
                                                            <button name="themTGmoi" type="submit" >OK</button>
                                                        </div> 
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                <?php
                                }
                            }    
                        }                   
                    mysqli_close($conn);
                    ?>

                </div>
            </div>
    </div>
    <div class="divContent main thaydoiquydinh ">
                <h2>Danh sách sách</h2>
                <div class="container_caidatchung">
                    <form action="?.php" method="POST">
                        <table id="resultSearchBook">
                            <thead>
                                <th>STT</th>
                                <th>Mã sách</th>
                                <th>Tên đầu sách</th>
                                <th>Tác giả</th>
                                <th>Thể loại</th>
                                <th>Nhà xuất bản</th>
                                <th>Năm xuất bản</th>
                                <th>Số lượng nhập</th>
                                <th>Giá tiền</th>
                                <th>Xem thông tin cuốn sách</th>
                                <th>Chỉnh sửa</th>
                                <th>Xóa</th>
                            </thead>
                            <tbody>
                                <?php
                                    $conn = mysqli_connect('localhost', 'root', '', 'quanlythuvien') or die ('fail');
                                    if(mysqli_connect_errno()){
                                        echo "failed to connect to Mysql: ".mysqli_connect_error();
                                        exit();
                                    }
                                    $sql = "SELECT DISTINCT dausach.MaDauSach, sach.MaSach, TenDauSach, TenTheLoai, NhaXuatBan, NamXuatBan, SoLuong, GiaTien, dausach.DaXoa AS DaXoaDauSach, sach.DaXoa AS DaXoaSach
                                        FROM dausach INNER JOIN sach ON dausach.MaDauSach = sach.MaDauSach
                                        INNER JOIN theloai ON dausach.MaTheLoai=theloai.MaTheLoai";
                                    $result = mysqli_query($conn, $sql);
                                    $index=1;
                                    if(mysqli_num_rows($result) > 0){
                                        while ($row = mysqli_fetch_assoc($result)){
                                            if($row["DaXoaDauSach"] == '0' && $row["DaXoaSach"] == '0' ){
                                            ?>
                                            <tr>
                                                <td class="stt"><?php echo $index ?></td>
                                                <td class="masach"><?php echo $row["MaSach"] ?></td>
                                                <td class="tends"><?php echo $row["TenDauSach"] ?></td>
                                                <td class="tacgia">
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
                                                 
                                                </td>
                                                <td class="theloai"><?php echo $row["TenTheLoai"] ?></td>
                                                <td class="nhaxb"><?php echo $row["NhaXuatBan"] ?></td>
                                                <td class="namxb"><?php echo $row["NamXuatBan"] ?></td>
                                                <td class="sl"><?php echo $row["SoLuong"] ?></td>
                                                <td class="giatien"><?php echo $row["GiaTien"] ?></td>
                                                <td><a href="option_book.php?GetID=<?php echo $row["MaSach"] ?>">Xem thông tin</a></td>
                                                <td><a href="option_edit_s.php?GetID=<?php echo $row["MaSach"] ?>">Chỉnh sửa</a></td>
                                                <td><a href="option_delete_s.php?GetID=<?php echo $row["MaSach"] ?>">Xóa</a></td>
                                            </tr>
                                            <?php 
                                            $index=$index+1;
                                
                                            }
                                        }
                                    }

                                        
                            ?>
                            <h3> <?php echo "Danh sách gồm " . ($index-1) . " sách.";  ?> </h3>        
                            </tbody>
                        </table>
                            <br>                                                              
                            <?php
                            mysqli_close($conn);
                        ?>
                    </form>
                </div>
            </div>
    <?php require('dbconnect.php'); ?>
    
    <div class="divTBTKadmin action TBdanhsachTG">
        <div class="thongbaosachmoi">
            <div class="TBthemmoi divktimthay">
                <div class="TBcontent theDGcontent">
                    <i class="btnDSTG fas fa-times"></i>
                    <h2>Danh sách tác giả</h2>
                    <table id="resultSearchBook">
                        <tbody  class="scroll_tbody_y table_body">
                            <tr>
                                <th style="width:100px">STT</th>
                                <th style="width:100px" >Mã tác giả</th>
                                <th style="width:200px">Tên tác giả</th>
                            </tr>
                        <?php
                            $sql99="SELECT MaTacGia,TenTacGia from tacgia where DaXoa = '0'";
                            if(!$result99=$mysqli->query($sql99)) echo 'Loitg99: '.$mysqli->error;
                            $index = 0;
                            if($result99->num_rows>0){
                                while($row99=$result99->fetch_assoc()){
                                    $index++;
                                    $matacgia=$row99["MaTacGia"];
                                    $tentacgia=$row99["TenTacGia"];
                                    ?>
                                    <tr>
                                        <td><?php echo $index;?></td>
                                        <td><?php echo $matacgia;?></td>
                                        <td><?php echo $tentacgia;?></td>
                                    </tr>
                                    <?php
                                }
                            }
                        ?>
                        </tbody>
                    </table>
                    <div class="btn" style="display: flex; justify-content: center;">
                         <button class="btnDSTG">OK</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="divTBTKadmin action TBdanhsachTL">
        <div class="thongbaosachmoi">
            <div class="TBthemmoi divktimthay">
                <div class="TBcontent theDGcontent">
                    <i class="btnDTLS fas fa-times"></i>
                    <h2>Danh sách thể loại sách</h2>
                    <table id="resultSearchBook">
                        <tbody  class="scroll_tbody_y table_DSTL ">
                            <tr>
                                <th style="width:100px">STT</th>
                                <th style="width:100px">Mã thể loại</th>
                                <th style="width:150px">Tên thể loại</th>
                            </tr>
                            <?php
                                $sql99="SELECT MaTheLoai,TenTheLoai from theloai where DaXoa = '0'";
                                if(!$result99=$mysqli->query($sql99)) echo 'Loitl99: '.$mysqli->error;
                                $ind = 0;
                                if($result99->num_rows>0){
                                    while($row99=$result99->fetch_assoc()){
                                        $ind++;
                                        $matheloai=$row99["MaTheLoai"];
                                        $tentheloai=$row99["TenTheLoai"];
                                        ?>
                                        <tr>
                                            <td><?php echo $ind;?></td>
                                            <td><?php echo $matheloai;?></td>
                                            <td><?php echo $tentheloai;?></td>
                                        </tr>
                                        <?php
                                    }
                                }
                                
                            ?>
                        </tbody>
                    </table>
                    <div class="btn" style="display: flex; justify-content: center;">
                         <button class="btnDTLS">OK</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        const btnDSTG = document.querySelectorAll(".btnDSTG");
        for(let i = 0; i < btnDSTG.length; i++){
            btnDSTG[i].addEventListener("click", function(){
                document.querySelector(".TBdanhsachTG").classList.add("action");
            });
        }

        const btnDTLS = document.querySelectorAll(".btnDTLS");
        for(let i = 0; i < btnDTLS.length; i++){
            btnDTLS[i].addEventListener("click", function(){
                document.querySelector(".TBdanhsachTL").classList.add("action");
            });
        }
        const btnDanhSachTG = document.getElementById("DanhsachTacgia");
        btnDanhSachTG.addEventListener("click", function(){
            document.querySelector(".TBdanhsachTG").classList.remove("action");
        })
        const btnDanhSachTL = document.getElementById("DanhsachTheloai");
        btnDanhSachTL.addEventListener("click", function(){
            document.querySelector(".TBdanhsachTL").classList.remove("action");
        })


        
    </script>
<?php $mysqli->close(); ?>
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