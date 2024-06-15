<?php
include '../connection.php';

$nis = $_GET['nis'];

$sql = "SELECT
          DATE_FORMAT(kalender_absensi, '%Y-%m') AS bulan,
          SUM(CASE WHEN nama_keterangan = 'Hadir' THEN 1 ELSE 0 END) AS hadir,
          SUM(CASE WHEN nama_keterangan = 'Sakit' THEN 1 ELSE 0 END) AS sakit,
          SUM(CASE WHEN nama_keterangan = 'Izin' THEN 1 ELSE 0 END) AS izin,
          SUM(CASE WHEN nama_keterangan = 'Alpha' THEN 1 ELSE 0 END) AS alpha
        FROM absensisiswa
        GROUP BY DATE_FORMAT(kalender_absensi, '%Y-%m')
        ORDER BY DATE_FORMAT(kalender_absensi, '%Y-%m') ASC";

$result = $conn->query($sql);

$data = array();
if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
    $data[] = $row;
  }
}

echo json_encode($data);

$conn->close();
?>