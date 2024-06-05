<?php
include '../connection.php';

$nis = $_POST['nis'];
$code = $_POST['code'];

$query = "SELECT verifikasi_kode FROM siswa Where nis = '$nis'";
$result = $connectNow->query($query);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $storedCode = $row['verifikasi_kode'];

    if($storedCode == $code){
        echo json_encode(['status' => 'success', 'message' =>'Kode Verifikasi Benar']);
    }else{
        echo json_encode(['status' => 'error', 'message' =>'Kode Verifikasi Salah']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' =>'Data Tidak Ditemukan']);
}
?>
