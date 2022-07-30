<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" />
    <link rel="stylesheet" href="style-home.css">
    <link rel="stylesheet" href="style_thongbao.css">
    <link rel="stylesheet" href="style-login.css">
    <link rel="stylesheet" href="style-option.css">
    <title>Login</title>
</head>
<body>
    <div class="navbar">
    <h1 style="margin-top: 50px; text-align:center; font-size:50px;">Đăng nhập</h1>

        <form enctype="multipart/form-data" method="POST">
            <div class="imgContainer">
                <img class="accountLogo" src="image/accountLogo.png" alt="#">
            </div>
    
            <div class="container">
                    Tên đăng nhập:<br>
                    <input type="text" placeholder="Nhập tên đăng nhập" name="username"><br>
                    Mật khẩu:<br>
                    <input type="password" placeholder="Nhập mật khẩu" name="password"><br>
                    <button type="submit" name="dangnhap">Đăng nhập</button><br>
                <div class="foodter">
                    <a href="index-main.php">Trang chủ</a>
                    <a id="dangki" class="register">Đăng kí hoặc quên mật khẩu</a>
                </div>
            </div>
    
        </form>
    </div>
                        <div class="divTBTKadmin action  thongbaodkitk">
                            <div class="thongbaosachmoi">
                                <div class="TBthemmoi divktimthay" style="height: 40vh;">
                                    <div class="TBcontent theDGcontent" style="height:90%; padding-top:20px">
                                        <i class="dkitaikhoan fas fa-times"></i>
                                        <h2>Để đăng kí tài khoản hoặc lấy lại mật khẩu vui lòng tới thư viện để làm thủ tục!</h2>
                                        <div class="btn" style="display: flex; justify-content: center; padding:0;">
                                            <button class="dkitaikhoan" style="width:70px; font: size 18px;" class="tenloaidocgiabitrung">OK</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
            
    <?php
    session_start();

    $conn = mysqli_connect('localhost', 'root','', 'quanlythuvien')   or die ('fail');
    if ( isset($_POST['dangnhap'])){
        $uname=$_POST["username"];
        $password=$_POST["password"];

        $sql="SELECT * FROM nguoidung WHERE TenDangNhap='$uname' AND MatKhau='$password'";
        $res=mysqli_query($conn,$sql);
        if(mysqli_num_rows($res)>0){
            $row=mysqli_fetch_assoc($res);
            $manhom=$row["MaNhom"];

            $_SESSION["loggedin"]=true;
            $_SESSION["manguoidung"]=$row["MaNguoiDung"];

            switch($manhom){
                // 1: super admin
                // 2: admin
                // 3: student
                case 1:
                    header("location: index-superadmin.php");
                    break;
                case 2:
                    header("location: index-home.php");
                    break;
                case 3:
                    $manguoidung=$row["MaNguoiDung"];
                    $sql_="SELECT MaDocGia from docgia WHERE MaNguoiDung='$manguoidung'";
                    $res_=mysqli_query($conn,$sql_);
                    $row_=mysqli_fetch_assoc($res_);
                    $_SESSION["madocgia"]=$row_["MaDocGia"];
        
                    header("location: index-docgia.php");
                    break;
                default:
                    header("location: index-main.php");
            }
        }
        else{
            ?>
                <div class="thongbaosachmoi divphieumuon" id="TBao">
                    <div class="TBthemmoi">
                        <div class="TBcontent theDGcontent">
                            <h3>Tên đăng nhập hoặc mật khẩu sai.</h3>
                            <h4>Vui lòng đăng nhập lại!</h4>
                            <div class="btn closephieumuonsach" style="display: flex; justify-content: center;">
                                <button id="tatTB">OK</button>
                            </div> 
                        </div>
                    </div>
                </div>
                <script>
                    document.getElementById("tatTB").addEventListener("click", function(){
                        document.getElementById("TBao").classList.add("action");
                    })
                </script>
            <?php
        }
    }
    mysqli_close($conn);
    ?>

    <script>
    document.getElementById("dangki").addEventListener("click", function(){
        document.querySelector(".thongbaodkitk").classList.remove("action");
    })
    const dkitk = document.querySelectorAll(".dkitaikhoan");
    for(let i = 0; i < dkitk.length; i++){
        dkitk[i].addEventListener("click", function(){
        document.querySelector(".thongbaodkitk").classList.add("action");
        });
    }
</script>
</body>
</html>