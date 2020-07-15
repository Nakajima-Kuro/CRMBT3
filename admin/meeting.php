<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
} else {

    if ($_GET["endName"] != '') {
        $sql = "DELETE FROM meeting WHERE name = (:endName)";
        $query = $dbh->prepare($sql);
        $query->bindParam(':endName', $_GET["endName"], PDO::PARAM_STR);
        $query->execute();
    }

    if (isset($_POST['createRoom'])) {

        $roomName = $_POST['roomName'];
        $roomDes = $_POST['roomDes'];

        // $sql = "insert into notification (notiuser,notireciver,notitype) values (:notiuser,:notireciver,:notitype)";
        $sql = "insert into meeting (name,description) values (:name,:des)";
        $query = $dbh->prepare($sql);
        $query->bindParam(':name', $roomName, PDO::PARAM_STR);
        $query->bindParam(':des', $roomDes, PDO::PARAM_STR);
        $query->execute();
        $_SESSION['roomName'] = $roomName;
        header("Location: jitsi.php");
        exit();
    }

    if (isset($_POST['joinRoom'])) {
        $_SESSION['roomName'] = $_POST['roomName'];
        header("Location: jitsi.php");
        exit();
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
        <meta name="theme-color" content="#3e454c">

        <title>Messages</title>

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
        <style>
            .errorWrap {
                padding: 10px;
                margin: 0 0 20px 0;
                background: #dd3d36;
                color: #fff;
                -webkit-box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
                box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
            }

            .succWrap {
                padding: 10px;
                margin: 0 0 20px 0;
                background: #5cb85c;
                color: #fff;
                -webkit-box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
                box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
            }

            .roomName {
                border: none;
            }

            .roomName:hover {
                cursor: default;
            }

            .roomName:focus {
                border: none;
                outline: none;
            }
        </style>

    </head>

    <body>
        <?php include('includes/header.php'); ?>

        <div class="ts-main-content">
            <?php
            include('includes/leftbar.php');
            ?>
            <div class="content-wrapper">
                <div class="container-fluid">

                    <div class="row">
                        <div class="col-md-12">

                            <h2 class="page-title">Họp Online</h2>

                            <!-- Zero Configuration Table -->
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <button id="newRoomButton" class="btn btn-primary" data-toggle="modal" data-target="#newRoom">Tạo phòng họp</button>
                                </div>
                                <div class="panel-body">
                                    <?php if ($error) { ?><div class="errorWrap" id="msgshow"><?php echo htmlentities($error); ?> </div><?php } else if ($msg) { ?><div class="succWrap" id="msgshow"><?php echo htmlentities($msg); ?> </div><?php } ?>
                                    <table id="zctb" class="display table table-bordered table-hover" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Tên</th>
                                                <th>Mô tả</th>
                                                <th></th>
                                            </tr>
                                        </thead>

                                        <tbody>

                                            <?php
                                            $reciver = $_SESSION['alogin'];
                                            $sql = "SELECT id, name, description from  meeting";
                                            $query = $dbh->prepare($sql);
                                            $query->bindParam(':reciver', $reciver, PDO::PARAM_STR);
                                            $query->execute();
                                            $results = $query->fetchAll(PDO::FETCH_OBJ);
                                            $cnt = 1;
                                            if ($query->rowCount() > 0) {
                                                foreach ($results as $result) {                ?>
                                                    <tr>
                                                        <form method="post">
                                                            <td><?php echo htmlentities($cnt); ?></td>
                                                            <td><input class="roomName" type="text" name="roomName" value="<?php echo htmlentities($result->name); ?>" readonly></input></td>
                                                            <td><?php echo htmlentities($result->description); ?></td>
                                                            <td><button type="submit" name="joinRoom">Vào phòng</button></td>
                                                        </form>
                                                    </tr>
                                            <?php $cnt = $cnt + 1;
                                                }
                                            } ?>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="modal fade" id="newRoom" tabindex="-1" role="dialog" aria-labelledby="New Room" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <form method="post">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="New Room">Tạo phòng họp</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="roomName">Tên phòng</label>
                                <input type="text" class="form-control" name="roomName" aria-describedby="roomName" placeholder="Tên phòng">
                                <small class="form-text text-warning">Tên phòng không được chứa dấu cách</small>
                            </div>
                            <div class="form-group">
                                <label for="description">Mô tả</label>
                                <input type="text" class="form-control" name="roomDes" placeholder="Mô tả">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                            <button name="createRoom" type="submit" class="btn btn-primary">Tạo</button>
                        </div>
                    </div>
                </form>
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
        <script type="text/javascript">
            $(document).ready(function() {
                setTimeout(function() {
                    $('.succWrap').slideUp("slow");
                }, 3000);
            });
        </script>
    </body>

    </html>
<?php } ?>