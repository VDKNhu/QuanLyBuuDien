<?php
require('dbconnect.php');
require('Classes/PHPExcel.php');

if(isset($_POST['btnGuiTacGia'])){
    $file = $_FILES['file']['tmp_name'];
    
    $objReader= PHPExcel_IOFactory::createReaderForFile($file);
    $objReader->setLoadSheetsOnly('Sheet1');

    $objExcel= $objReader->load($file);
    $sheetData= $objExcel->getActiveSheet()->toArray('null',true,true,true);

    $highestRow= $objExcel->setActiveSheetIndex()->getHighestRow();
  
    for($row=2; $row<=$highestRow; $row++){
        $hoten=$sheetData[$row]['A']; 
 
        $sql="INSERT INTO tacgia(TenTacGia) VALUES ('$hoten')";
	if($mysqli->query($sql)) echo 'Inserted';
        else echo 'Loi: '.$mysqli->error;
    }  }      
$mysqli->close();

?>
<?php
require('dbconnect.php');
//require('Classes/PHPExcel.php');
//error_reporting(E_ERROR);//Sau khi dam bao file chay hoan hao, dung error_reporting de remove cac warnings, 
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
		}}
	}
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
    $mysqli->close();
}


?>