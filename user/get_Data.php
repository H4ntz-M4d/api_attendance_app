<?php
include '../connection.php';

$nis = $_GET['nis'];

$sqlQuery = "SELECT * FROM siswa WHERE nis = '$nis'";
$resultOfQuery = $connectNow->query($sqlQuery);

if ($resultOfQuery->num_rows > 0) {
    $userRecord = array();
    while($rowFound = $resultOfQuery->fetch_assoc()) {
        $userRecord[] = $rowFound;
    }
    echo json_encode(
        array(
            "success" => true,
            "userData" => $userRecord[0],
        )
    );
} else {
    echo json_encode(array("success" => false));
}
