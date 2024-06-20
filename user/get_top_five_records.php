<?php
include '../connection.php';

$nis = $_POST['nis'];
$role = $_POST['role'];
$table = '';
$id = '';

if ($role == 'guru') {
  $table = 'absensiguru';
  $id = 'nip';
} else if($role == 'siswa') {
  $table = 'absensisiswa';
  $id = 'nis';
}

$sqlQuery = "SELECT * FROM $table WHERE $id = '$nis' ORDER BY kalender_absensi DESC LIMIT 5";

$resultOfQuery = $connectNow->query($sqlQuery);

$data = array();
if ($resultOfQuery->num_rows > 0) {
  while($row = $resultOfQuery->fetch_assoc()) {
    $data[] = $row;
  }
  echo json_encode(
    array(
        "success" => true,
        "role" => $role,
        "userData" => $data,
    )
  );
} else {
  echo json_encode(array("success" => false));
}


$connectNow->close();
?>