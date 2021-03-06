<?php
include('includes/config.php');
if (isset($_POST['submit'])) {

    $file = $_FILES['image']['name'];
    $file_loc = $_FILES['image']['tmp_name'];
    $folder = "images/";
    $new_file_name = strtolower($file);
    $final_file = str_replace(' ', '-', $new_file_name);

    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = md5($_POST['password']);
    $gender = $_POST['gender'];
    $mobileno = $_POST['mobileno'];
    $position = $_POST['position'];

    if (move_uploaded_file($file_loc, $folder . $final_file)) {
        $image = $final_file;
    }
    $notitype = 'Tạo tài khoản';
    $reciver = 'Admin';
    $sender = $email;

    $sqlnoti = "insert into notification (notiuser,notireciver,notitype) values (:notiuser,:notireciver,:notitype)";
    $querynoti = $dbh->prepare($sqlnoti);
    $querynoti->bindParam(':notiuser', $sender, PDO::PARAM_STR);
    $querynoti->bindParam(':notireciver', $reciver, PDO::PARAM_STR);
    $querynoti->bindParam(':notitype', $notitype, PDO::PARAM_STR);
    $querynoti->execute();

    $sql = "INSERT INTO users(name, email, password, gender, mobile, position, image, status) VALUES(:name, :email, :password, :gender, :mobileno, :position, :image, 1)";
    $query = $dbh->prepare($sql);
    $query->bindParam(':name', $name, PDO::PARAM_STR);
    $query->bindParam(':email', $email, PDO::PARAM_STR);
    $query->bindParam(':password', $password, PDO::PARAM_STR);
    $query->bindParam(':gender', $gender, PDO::PARAM_STR);
    $query->bindParam(':mobileno', $mobileno, PDO::PARAM_STR);
    $query->bindParam(':position', $position, PDO::PARAM_STR);
    $query->bindParam(':image', $image, PDO::PARAM_STR);
    $query->execute();
    $lastInsertId = $dbh->lastInsertId();
    if ($lastInsertId) {
        echo "<script type='text/javascript'>alert('Đăng kí thành công!');</script>";
        echo "<script type='text/javascript'> document.location = 'index.php'; </script>";
    } else {
        $error = "Có lỗi xảy ra, vui lòng thử lại.";
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


    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-social.css">
    <link rel="stylesheet" href="css/bootstrap-select.css">
    <link rel="stylesheet" href="css/fileinput.min.css">
    <link rel="stylesheet" href="css/awesome-bootstrap-checkbox.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/css/login.css">
    <script type="text/javascript">
        function validate() {
            var extensions = new Array("jpg", "jpeg");
            var image_file = document.regform.image.value;
            var image_length = document.regform.image.value.length;
            var pos = image_file.lastIndexOf('.') + 1;
            var ext = image_file.substring(pos, image_length);
            var final_ext = ext.toLowerCase();
            for (i = 0; i < extensions.length; i++) {
                if (extensions[i] == final_ext) {
                    return true;

                }
            }
            alert("Định dạng ảnh ko hợp lệ (chỉ dùng Jpg,jpeg)");
            return false;
        }
    </script>
</head>

<body>
    <div class="login-page bk-img">
        <div class="form-content">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="text-center text-bold text-white mt-5x">Đăng kí</h1>
                        <div class="row pt-2x pb-3x mt-3x text-center">
                            <form method="post" class="form-horizontal" enctype="multipart/form-data" name="regform" onSubmit="return validate();">
                                <div class="form-group">
                                    <label class="col-sm-1 control-label">Họ Tên<span style="color:red">*</span></label>
                                    <div class="col-sm-5">
                                        <input type="text" name="name" class="form-control" required>
                                    </div>
                                    <label class="col-sm-1 control-label">Email<span style="color:red">*</span></label>
                                    <div class="col-sm-5">
                                        <input type="text" name="email" class="form-control" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-1 control-label">Mật khẩu<span style="color:red">*</span></label>
                                    <div class="col-sm-5">
                                        <input type="password" name="password" class="form-control" id="password" required>
                                    </div>

                                    <label class="col-sm-1 control-label">Chức vụ<span style="color:red">*</span></label>
                                    <div class="col-sm-5">
                                        <select name="position" class="form-control" required>
                                            <option value="">Chọn</option>
                                            <?php
                                            $reciver = $_SESSION['alogin'];
                                            $sql = "SELECT id, name from  position";
                                            $query = $dbh->prepare($sql);
                                            $query->bindParam(':reciver', $reciver, PDO::PARAM_STR);
                                            $query->execute();
                                            $results = $query->fetchAll(PDO::FETCH_OBJ);
                                            if ($query->rowCount() > 0) {
                                                foreach ($results as $result) {                ?>
                                                    <option value="<?php echo htmlentities($result->id); ?>">
                                                        <?php echo htmlentities($result->name); ?>
                                                    </option>
                                            <?php
                                                }
                                            } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-1 control-label">Giới tính<span style="color:red">*</span></label>
                                    <div class="col-sm-5">
                                        <select name="gender" class="form-control" required>
                                            <option value="">Chọn</option>
                                            <option value="Male">Nam</option>
                                            <option value="Female">Nữ</option>
                                        </select>
                                    </div>

                                    <label class="col-sm-1 control-label">Số điên thoại<span style="color:red">*</span></label>
                                    <div class="col-sm-5">
                                        <input type="text" name="mobileno" class="form-control" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-1 control-label">Avtar<span style="color:red">*</span></label>
                                    <div class="col-sm-5">
                                        <div><input type="file" name="image" class="form-control"></div>
                                    </div>
                                </div>

                                <br>
                                <button class="btn btn-primary" name="submit" type="submit">Đăng kí</button>
                            </form>
                            <br>
                            <br>
                            <p class="text-white">Đã có tài khoản? <a href="index.php">Đăng nhập</a></p>
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
    <script src="js/chartData.js"></script>
    <script src="js/main.js"></script>

</body>

</html>