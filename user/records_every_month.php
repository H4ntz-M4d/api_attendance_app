<?php
include '../connection.php';

$nis = $_POST['nis'];
$year = $_POST['year'];
$month = $_POST['month'];
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


$sqlQuery = "SELECT * FROM $table WHERE $id = '$nis' AND DATE_FORMAT(kalender_absensi, '%m-%Y') = '$month-$year'";

$resultOfQuery = $connectNow->query($sqlQuery);

$data = array();
if ($resultOfQuery->num_rows > 0) {
  while($row = $resultOfQuery->fetch_assoc()) {
    $data[] = $row;
  }
  echo json_encode(
    array(
        "success" => true,
        "events" => $data,
    )
  );
} else {
  echo json_encode(array("success" => false));
}


$connectNow->close();
?>