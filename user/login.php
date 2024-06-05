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
    
        $sqlQuery2 = "SELECT * FROM absensisiswa WHERE nis = '$siswaNis'";

        $resultOfQuery2 = $connectNow->query($sqlQuery2);
        $userRecord2 = array(); // Inisialisasi array kosong

        if($resultOfQuery2->num_rows > 0) { // Periksa hasil kueri yang benar
            while($rowFound2 = $resultOfQuery2->fetch_assoc()) {
                $userRecord2[] = $rowFound2;
            }
        }

        echo json_encode(
            array(
                "success" => true,
                "userData" => $userRecord[0],
                "userHistory" => $userRecord2,
            )
        );

    } else {
        echo json_encode(['status' => 'success', 'message' => 'Password Salah']);
    }
} else //Do NOT allow user to login 
{
    echo json_encode(['status' => 'success', 'message' => 'NIS Tidak Ditemukan']);
}
