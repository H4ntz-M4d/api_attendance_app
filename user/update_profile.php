<?php
include '../connection.php';

$nis = $_POST['nis'];
$role = $_POST['role'];
$alamat = $_POST['alamat'];
$phone = $_POST['phone'];

$table = '';
$id = '';

if ($role == 'guru') {
  $table = 'guru';
  $id = 'nip';
} else if($role == 'siswa') {
  $table = 'siswa';
  $id = 'nis';
}

$sqlQuery = "UPDATE $table SET alamat = '$alamat', phone = '$phone' WHERE $id = '$nis'";

if ($connectNow->query($sqlQuery) === TRUE) {
    echo json_encode(array("success" => true));
} else {
    echo json_encode(array("success" => false));
}

$connectNow->close();
