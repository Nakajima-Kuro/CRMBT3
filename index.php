<?php
session_start();
include('includes/config.php');
if(isset($_POST['login']))
{
$status='1';
$email=$_POST['username'];
$password=md5($_POST['password']);
$sql ="SELECT email,password FROM users WHERE email=:email and password=:password and status=(:status)";
$query= $dbh -> prepare($sql);
$query-> bindParam(':email', $email, PDO::PARAM_STR);
$query-> bindParam(':password', $password, PDO::PARAM_STR);
$query-> bindParam(':status', $status, PDO::PARAM_STR);
$query-> execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
if($query->rowCount() > 0)
{
$_SESSION['alogin']=$_POST['username'];
echo "<script type='text/javascript'> document.location = 'profile.php'; </script>";
} else{
  
  echo "<script>alert('Tài khoản hoặc mật khẩu không đúng');</script>";

}

}

?>
<!doctype html>
<html lang="en">
 
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Login</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <link href="./css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/vendor/fonts/fontawesome/css/fontawesome-all.css">
    <style>
    html,
    body {
        height: 100%;
    }

    body {
        display: -ms-flexbox;
        display: flex;
        -ms-flex-align: center;
        align-items: center;
        padding-top: 40px;
        padding-bottom: 40px;
    }
    </style>
</head>

<body>
    <!-- ============================================================== -->
    <!-- login page  -->
    <!-- ============================================================== -->
    <div class="splash-container">
        <div class="card ">
            <div class="card-header text-center"><a href="."><img class="logo-img" src="./images/php.png" alt="logo"></a><span class="splash-description">Trang web quản lý nhân viên</span></div>
            <div class="card-body">
                <form method="post" style="background-color: white">
                    <div class="form-group">
                        <input for="" class="form-control form-control-lg" name="username" type="text" placeholder="Tên đăng nhập" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <input class="form-control form-control-lg" name="password" type="password" placeholder="Mật khẩu">
                    </div>
                    <button class="btn btn-primary btn-lg btn-block" name="login" type="submit">ĐĂNG NHẬP</button>
                </form>
            </div>
            <div class="card-footer bg-white p-0">
                <div class="card-footer-item card-footer-item-bordered text-center">
					 <p>Bạn chưa có tài khoản? <a href="register.php" >Đăng ký</a></p>
            </div>
        </div>
    </div>
  
    <!-- ============================================================== -->
    <!-- end login page  -->
    <!-- ============================================================== -->
    <!-- Optional JavaScript -->
    <script src="./css/jquery-3.3.1.min.js"></script>
    <script src="./css/bootstrap.bundle.js"></script>
</body>
 
</html>

</html>