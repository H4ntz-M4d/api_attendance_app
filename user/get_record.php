<?php
include '../connection.php';

$nis = $_POST['nis'];

$sqlQuery = "SELECT * FROM absensisiswa WHERE nis = $nis";

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
