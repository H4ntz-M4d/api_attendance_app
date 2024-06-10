<?php
include '../connection.php';

$nis = $_POST['nis'];

$sqlQuery = "SELECT * FROM absensisiswa WHERE nis = '$nis' ORDER BY kalender_absensi DESC LIMIT 5";

$resultOfQuery = $connectNow->query($sqlQuery);

$data = array();
if ($resultOfQuery->num_rows > 0) {
  while($row = $resultOfQuery->fetch_assoc()) {
    $data[] = $row;
  }
  echo json_encode(
    array(
        "success" => true,
        "userData" => $data,
    )
  );
} else {
  echo json_encode(array("success" => false));
}


$connectNow->close();
?>