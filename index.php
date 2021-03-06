<?php
session_start();
include('includes/config.php');
if (isset($_POST['login'])) {
	$status = '1';
	$email = $_POST['username'];
	$password = md5($_POST['password']);
	$sql = "SELECT email,password FROM users WHERE email=:email and password=:password and status=(:status)";
	$query = $dbh->prepare($sql);
	$query->bindParam(':email', $email, PDO::PARAM_STR);
	$query->bindParam(':password', $password, PDO::PARAM_STR);
	$query->bindParam(':status', $status, PDO::PARAM_STR);
	$query->execute();
	$results = $query->fetchAll(PDO::FETCH_OBJ);
	if ($query->rowCount() > 0) {
		$_SESSION['alogin'] = $_POST['username'];
		echo "<script type='text/javascript'> document.location = 'profile.php'; </script>";
	} else {

		echo "<script>alert('Invalid Details Or Account Not Confirmed');</script>";
	}
}

?>
<!doctype html>
<html lang="en" class="no-js">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">


	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.1/css/all.min.css">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
	<link rel="stylesheet" href="css/bootstrap-social.css">
	<link rel="stylesheet" href="css/bootstrap-select.css">
	<link rel="stylesheet" href="css/fileinput.min.css">
	<link rel="stylesheet" href="css/awesome-bootstrap-checkbox.css">
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="css/css/login.css">
</head>

<body>
	<div class="container">
		<div class="row">
			<div class="col-md-6 col-md-offset-3">
				<h1 class="text-center text-bold text-white mt-4x">Đăng nhập</h1>
				<div class="row pt-2x pb-3x">
					<div class="col-md-8 col-md-offset-2">
						<form method="post">

							<label for="" class="text-uppercase text-sm">Email</label>
							<input type="text" placeholder="Email" name="username" class="form-control mb" required>

							<label for="" class="text-uppercase text-sm">Mật khẩu</label>
							<input type="password" placeholder="Password" name="password" class="form-control mb" required>
							<button class="btn btn-primary btn-block" name="login" type="submit">Đăng nhập</button>
						</form>
						<br>
						<p>Không có tài khoản <a href="register.php">Đăng kí</a></p>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Loading Scripts -->
	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap-select.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/jquery.dataTables.min.js"></script>
	<script src="js/dataTables.bootstrap.min.js"></script>
	<script src="js/Chart.min.js"></script>
	<script src="js/fileinput.js"></script>
	<script src="js/chartData.js"></script>
	<script src="js/main.js"></script>

</body>

</html>