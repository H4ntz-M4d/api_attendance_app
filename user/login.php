<?php
include '../connection.php';

$siswaNis = $_POST['nis'];
$siswaPassword = $_POST['siswa_password'];

$sqlQuery = "SELECT * FROM siswa WHERE nis = '$siswaNis'";

$resultOfQuery = $connectNow->query($sqlQuery);

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
} else //Do NOT allow user to login 
{
    echo json_encode(['status' => 'success', 'message' => 'NIS Tidak Ditemukan']);
}
