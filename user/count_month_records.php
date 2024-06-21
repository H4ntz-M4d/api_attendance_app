<?php
include '../connection.php';

$nis = $_POST['nis'];
$date = $_POST['date'];
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

// Array to map month names to numbers
$months = [
    "Januari" => "01",
    "Februari" => "02",
    "Maret" => "03",
    "April" => "04",
    "Mei" => "05",
    "Juni" => "06",
    "Juli" => "07",
    "Agustus" => "08",
    "September" => "09",
    "Oktober" => "10",
    "November" => "11",
    "Desember" => "12"
];

// Split input into month and year
list($monthName, $year) = explode(' ', $date);

// Get the month number
$month = $months[$monthName];

// Format the date as "YYYY-MM"
$formattedDate = $month . '-' . $year;

$sqlQuery = "SELECT 
SUM(CASE WHEN nama_keterangan = 'Hadir' THEN 1 ELSE 0 END) AS jumlah_hadir,
SUM(CASE WHEN nama_keterangan = 'Sakit' THEN 1 ELSE 0 END) AS jumlah_sakit,
SUM(CASE WHEN nama_keterangan = 'Izin' THEN 1 ELSE 0 END) AS jumlah_izin,
SUM(CASE WHEN nama_keterangan = 'Alpha' THEN 1 ELSE 0 END) AS jumlah_alpha
FROM 
$table WHERE $id = '$nis' AND DATE_FORMAT(kalender_absensi, '%m-%Y') = '$formattedDate'";

$resultOfQuery = $connectNow->query($sqlQuery);

$data = array();
if ($resultOfQuery->num_rows > 0) {
  while($row = $resultOfQuery->fetch_assoc()) {
    $data[] = $row;
  }
  echo json_encode(
    array(
        "success" => true,
        "userData" => $data[0],
    )
  );
} else {
  echo json_encode(array("success" => false));
}


$connectNow->close();
?>