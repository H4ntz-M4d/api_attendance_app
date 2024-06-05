<?php
include '../connection.php';

$nis = $_POST['nis'];
$alamat = $_POST['alamat'];
$phone = $_POST['phone'];

$sqlQuery = "UPDATE siswa SET alamat = '$alamat', phone = '$phone' WHERE nis = '$nis'";

if ($connectNow->query($sqlQuery) === TRUE) {
    echo json_encode(array("success" => true));
} else {
    echo json_encode(array("success" => false));
}

$connectNow->close();
