<?php
    $roomName = $_POST['roomName'];
    $roomPassword = $_POST['roomPassword'];
    $reciver = $_SESSION['alogin'];
    // $sql = "INSERT INTO `meeting`(`name`, `password`, `numOfPeople`) VALUES ($roomName,$roomPassword,1)";
    $sql = "INSERT INTO `meeting`(`name`, `password`, `numOfPeople`) VALUES ('Test', 'Test', 1)";
    $query = $dbh->prepare($sql);
    $query->execute();
?>