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

$sqlQuery = "SELECT * FROM $table WHERE $id = '$nis'";

$resultOfQuery = $connectNow->query($sqlQuery);

if ($resultOfQuery->num_rows > 0) {
    $events = array();
    while ($row = $resultOfQuery->fetch_assoc()) {
        $events[] = $row;
    }
    echo json_encode(array("success" => true, "events" => $events));
} else {
    echo json_encode(array("success" => false));
}
?>
