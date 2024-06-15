<?php
include '../connection.php';

$siswaNis = $_POST['nis'];
$siswaPassword = $_POST['siswa_password'];

$sqlQuery = "SELECT * FROM siswa WHERE nis = '$siswaNis'";
$sqlGuru = "SELECT * FROM guru WHERE nip = '$siswaNis'";

$resultOfQuery = $connectNow->query($sqlQuery);
$resultOfQueryGuru = $connectNow->query($sqlGuru);

if ($resultOfQuery->num_rows > 0) //allow user to login 
{
    $rowFound = $resultOfQuery->fetch_assoc();
    $hashedPassword = $rowFound['siswa_password'];

    if (password_verify($siswaPassword, $hashedPassword)) {

        $userRecord = array();
        $userRecord[] = $rowFound;

        echo json_encode(
            array(
                "success" => true,
                "userData" => $userRecord[0],
            )
        );

    } else {
        echo json_encode(['status' => 'success', 'message' => 'Password Salah']);
    }
} else if($resultOfQueryGuru->num_rows > 0){
    $rowFound = $resultOfQueryGuru->fetch_assoc();
    $hashedPassword = $rowFound['guru_password'];

    if (password_verify($siswaPassword, $hashedPassword)) {

        $userRecord = array();
        $userRecord[] = $rowFound;

        echo json_encode(
            array(
                "success" => true,
                "userData" => $userRecord[0],
            )
        );

    } else {
        echo json_encode(['status' => 'success', 'message' => 'Password Salah']);
    }
}else {
    echo json_encode(['status' => 'success', 'message' => 'NIS/NIP Tidak Ditemukan']);
}

