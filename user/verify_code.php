<?php
include '../connection.php';

$nis = $_POST['nis'];
$code = $_POST['code'];

// Check in the "guru" table
$queryGuru = "SELECT verifikasi_kode FROM guru WHERE nip = '$nis'";
$resultGuru = $connectNow->query($queryGuru);

if ($resultGuru->num_rows > 0) {
    $rowGuru = $resultGuru->fetch_assoc();
    $storedCodeGuru = $rowGuru['verifikasi_kode'];

    if ($storedCodeGuru == $code) {
        echo json_encode(['status' => 'success', 'message' => 'Kode Verifikasi Benar (Guru)']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Kode Verifikasi Salah (Guru)']);
    }
    exit();
}

// Check in the "siswa" table if not found in "guru" table
$querySiswa = "SELECT verifikasi_kode FROM siswa WHERE nis = '$nis'";
$resultSiswa = $connectNow->query($querySiswa);

if ($resultSiswa->num_rows > 0) {
    $rowSiswa = $resultSiswa->fetch_assoc();
    $storedCodeSiswa = $rowSiswa['verifikasi_kode'];

    if ($storedCodeSiswa == $code) {
        echo json_encode(['status' => 'success', 'message' => 'Kode Verifikasi Benar (Siswa)']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Kode Verifikasi Salah (Siswa)']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Data Tidak Ditemukan']);
}
?>
