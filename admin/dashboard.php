<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['alogin']) == 0) {
	header('location:index.php');
} else {
?>
	<!doctype html>
	<html lang="en" class="no-js">

	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
		<meta name="description" content="">
		<meta name="author" content="">
		<meta name="theme-color" content="#3e454c">

		<title>Trang chủ Admin</title>

		<!-- Font awesome -->
		<link rel="stylesheet" href="css/font-awesome.min.css">
		<!-- Sandstone Bootstrap CSS -->
		<link rel="stylesheet" href="css/bootstrap.min.css">
		<!-- Bootstrap Datatables -->
		<link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
		<!-- Bootstrap social button library -->
		<link rel="stylesheet" href="css/bootstrap-social.css">
		<!-- Bootstrap select -->
		<link rel="stylesheet" href="css/bootstrap-select.css">
		<!-- Bootstrap file input -->
		<link rel="stylesheet" href="css/fileinput.min.css">
		<!-- Awesome Bootstrap checkbox -->
		<link rel="stylesheet" href="css/awesome-bootstrap-checkbox.css">
		<!-- Admin Stye -->
		<link rel="stylesheet" href="css/style.css">
		<link rel="stylesheet" href="css/w3.css">
	</head>

	<body>
		<?php include('includes/header.php'); ?>

		<div class="ts-main-content">
			<?php include('includes/leftbar.php'); ?>
			<div class="content-wrapper">
				<div class="container-fluid">

					<div class="row">
						<div class="col-md-12">

							<h2 class="page-title">Trang chủ</h2>

							<div class="row">
								<div class="col-md-12">
									<div class="row">
										<div class="col-md-3 fi-2">
											<div class="panel panel-default">
												<div class="panel-body bk-primary text-light">
													<div class="stat-panel text-center">
														<?php
														$sql = "SELECT id from users";
														$query = $dbh->prepare($sql);
														$query->execute();
														$results = $query->fetchAll(PDO::FETCH_OBJ);
														$bg = $query->rowCount();
														?>
														<div class="stat-panel-number h1 "><?php echo htmlentities($bg); ?></div>
														<div class="stat-panel-title text-uppercase">Tổng số nhân viên   <i class="fa fa-user"></i></div>
													</div>
												</div>
												<a href="userlist.php" class="block-anchor panel-footer text-center">Thông tin chi tiết &nbsp; <i class="fa fa-arrow-right"></i></a>
											</div>
										</div>
										<div class="col-md-3 fi-25">
											<div class="panel panel-default">
												<div class="panel-body bk-success text-light">
													<div class="stat-panel text-center">

														<?php
														$reciver = 'Admin';
														$sql1 = "SELECT id from feedback where reciver = (:reciver)";
														$query1 = $dbh->prepare($sql1);;
														$query1->bindParam(':reciver', $reciver, PDO::PARAM_STR);
														$query1->execute();
														$results1 = $query1->fetchAll(PDO::FETCH_OBJ);
														$regbd = $query1->rowCount();
														?>
														<div class="stat-panel-number h1 "><?php echo htmlentities($regbd); ?></div>
														<div class="stat-panel-title text-uppercase">Tin nhắn phản hồi		<i class="fa fa-envelope"></i></div>
													</div>
												</div>
												<a href="feedback.php" class="block-anchor panel-footer text-center">Thông tin chi tiết &nbsp; <i class="fa fa-arrow-right"></i></a>
											</div>
										</div>

										<div class="col-md-3 fi-3">
											<div class="panel panel-default">
												<div class="panel-body bk-danger text-light">
													<div class="stat-panel text-center">

														<?php
														$reciver = 'Admin';
														$sql12 = "SELECT id from notification where notireciver = (:reciver)";
														$query12 = $dbh->prepare($sql12);;
														$query12->bindParam(':reciver', $reciver, PDO::PARAM_STR);
														$query12->execute();
														$results12 = $query12->fetchAll(PDO::FETCH_OBJ);
														$regbd2 = $query12->rowCount();
														?>
														<div class="stat-panel-number h1 "><?php echo htmlentities($regbd2); ?></div>
														<div class="stat-panel-title text-uppercase">Thông báo		<i class="fa fa-bell"></i></div>
													</div>
												</div>
												<a href="notification.php" class="block-anchor panel-footer text-center">Thông tin chi tiết &nbsp; <i class="fa fa-arrow-right"></i></a>
											</div>
										</div>
										<div class="col-md-3 fi-35">
											<div class="panel panel-default">
												<div class="panel-body bk-info text-light">
													<div class="stat-panel text-center">
														<?php
														$sql6 = "SELECT id from deleteduser ";
														$query6 = $dbh->prepare($sql6);;
														$query6->execute();
														$results6 = $query6->fetchAll(PDO::FETCH_OBJ);
														$query = $query6->rowCount();
														?>
														<div class="stat-panel-number h1 "><?php echo htmlentities($query); ?></div>
														<div class="stat-panel-title text-uppercase">Nhân viên nghỉ việc	<i class="fa fa-user left fa-fw"></i>
														<i class="fa fa-minus left" style="font-size: 10px; margin-left: -14px; margin-right: 14px; vertical-align: center; color: #827e7e"></i></div>
													</div>
												</div>
												<a href="deleteduser.php" class="block-anchor panel-footer text-center">Thông tin chi tiết &nbsp; <i class="fa fa-arrow-right"></i></a>
											</div>
										</div>
										<div class="row">
											<div class="col-sm-6">
												<h4 class="text-center">Top 10 vị trí có nhân viên nhiều nhất</h4>
												<canvas id="positionChart"></canvas>
											</div>
											<div class="col-sm-6">
												<h4 class="text-center">Phân bổ nhân viên theo phòng ban</h4>
												<canvas id="departmentChart"></canvas>
											</div>
										</div>
									</div>
								</div>
							</div>
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
		<!-- <script src="js/chartData.js"></script> -->
		<script src="js/main.js"></script>

		<script type="text/javascript">
			window.onload = function() {
				var positions = new Array();
				var empNum = new Array();
				var departments = new Array();
				var empNumByDepartment = new Array();
				<?php
				$sql7 = "SELECT p.name as name, count(u.id) as num from users u 
					inner join position p on p.id = u.position_id group by p.id having count(u.id) > 0 order by count(u.id) desc limit 10;";
				$query7 = $dbh->prepare($sql7);
				$query7->execute();
				$results7 = $query7->fetchAll(PDO::FETCH_OBJ);
				foreach ($results7 as $var) {
					echo 'positions.push("' . $var->name . '");';
				};
				foreach ($results7 as $var) {
					echo 'empNum.push("' . $var->num . '");';
				};
				?>

				var ctx = document.getElementById('positionChart').getContext('2d');
				var myChart = new Chart(ctx, {
					type: 'bar',
					data: {
						labels: positions,
						datasets: [{
							label : 'Số lượng nhân viên',
							data: empNum,
							backgroundColor: [
								'rgba(255, 99, 132, 0.2)',
								'rgba(54, 162, 235, 0.2)',
								'rgba(255, 206, 86, 0.2)',
								'rgba(75, 192, 192, 0.2)',
								'rgba(153, 102, 255, 0.2)',
								'rgba(255, 159, 64, 0.2)'
							],
							borderColor: [
								'rgba(255, 99, 132, 1)',
								'rgba(54, 162, 235, 1)',
								'rgba(255, 206, 86, 1)',
								'rgba(75, 192, 192, 1)',
								'rgba(153, 102, 255, 1)',
								'rgba(255, 159, 64, 1)'
							],
							borderWidth: 1
						}]
					},
					options: {
						legend: {
							display: false
						},
						scales: {
							yAxes: [{
								ticks: {
									beginAtZero: true
								}
							}]
						}
					}
				});

				<?php
				$sql8 = "SELECT d.name as name, count(u.id) as num from users u 
					inner join position p on p.id = u.position_id
					inner join department d on d.id = p.department_id group by d.id having count(u.id) > 0 limit 10;";
				$query8 = $dbh->prepare($sql8);
				$query8->execute();
				$results8 = $query8->fetchAll(PDO::FETCH_OBJ);
				foreach ($results8 as $var) {
					echo 'departments.push("' . $var->name . '");';
				};
				foreach ($results8 as $var) {
					echo 'empNumByDepartment.push("' . $var->num . '");';
				};
				?>

				var ctx2 = document.getElementById("departmentChart").getContext("2d");
				var mydChart = new Chart(ctx2, {
					type: 'doughnut',
					data: {
						labels: departments,
						datasets: [{
							label: '# of Votes',
							data: empNumByDepartment,
							backgroundColor: [
								'rgba(255, 99, 132, 0.2)',
								'rgba(54, 162, 235, 0.2)',
								'rgba(255, 206, 86, 0.2)',
								'rgba(75, 192, 192, 0.2)',
								'rgba(153, 102, 255, 0.2)',
								'rgba(255, 159, 64, 0.2)'
							],
							borderColor: [
								'rgba(255, 99, 132, 1)',
								'rgba(54, 162, 235, 1)',
								'rgba(255, 206, 86, 1)',
								'rgba(75, 192, 192, 1)',
								'rgba(153, 102, 255, 1)',
								'rgba(255, 159, 64, 1)'
							],
							borderWidth: 1
						}]
					},
					options: {
						scales: {
							yAxes: [{
								ticks: {
									beginAtZero: true
								}
							}]
						}
					}
				});

			}
		</script>
	</body>

	</html>
<?php } ?>