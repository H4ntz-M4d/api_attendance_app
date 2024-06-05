<?php
include '../connection.php';

$nis = $_GET['nis'];

$sqlQuery = "
    SELECT absen.*, k.nama_keterangan 
    FROM absensisiswa absen 
    JOIN keterangan k 
    ON absen.kode_keterangan = k.kode_keterangan 
    WHERE absen.nis = '$nis'
";

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
