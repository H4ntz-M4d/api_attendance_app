<?php
include '../connection.php';

$nis = $_POST['nis'];
$role = $_POST['role'];

$table = '';
$id = '';

if ($role == 'guru') {
  $table = 'guru';
  $id = 'nip';
} else if($role == 'siswa') {
  $table = 'siswa';
  $id = 'nis';
}

$sqlQuery = "SELECT * FROM $table WHERE $id = '$nis'";
$resultOfQuery = $connectNow->query($sqlQuery);

if ($resultOfQuery->num_rows > 0) {
    $userRecord = array();
    while($rowFound = $resultOfQuery->fetch_assoc()) {
        $userRecord[] = $rowFound;
        $userRecord[0]['role'] = $role; 
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
