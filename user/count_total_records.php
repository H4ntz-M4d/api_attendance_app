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

$sqlQuery = "SELECT 
SUM(CASE WHEN nama_keterangan = 'Hadir' THEN 1 ELSE 0 END) AS jumlah_hadir,
SUM(CASE WHEN nama_keterangan = 'Sakit' THEN 1 ELSE 0 END) AS jumlah_sakit,
SUM(CASE WHEN nama_keterangan = 'Izin' THEN 1 ELSE 0 END) AS jumlah_izin,
SUM(CASE WHEN nama_keterangan = 'Alpha' THEN 1 ELSE 0 END) AS jumlah_alpha
FROM 
$table WHERE $id = '$nis'";

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
        "userData" => $data[0],
    )
  );
} else {
  echo json_encode(array("success" => false));
}


$connectNow->close();

?>