<?php

include '../connection.php';

$nis_nip = $_POST['nis'];
$role = $_POST['role'];
$verification_code = $_POST['verifikasi_kode'];
$email_baru = $_POST['email_baru'];

$table = '';
$table_email = '';
$id = '';

if ($role == 'guru') {
    $table = 'guru';
    $id = 'nip';
    $table_email = 'guru_email';
  } else if($role == 'siswa') {
    $table = 'siswa';
    $id = 'nis';
    $table_email = 'siswa_email';
  }



$query = "SELECT * FROM $table WHERE $id='$nis_nip' AND verifikasi_kode='$verification_code'";
$result = $connectNow->query($query);

if ($result->num_rows > 0) {
    $update_query = "UPDATE $table SET $table_email = '$email_baru', verifikasi_kode=NULL WHERE $id = '$nis_nip'";
    
    if ($connectNow->query($update_query) === TRUE) {
        echo json_encode(['status' => 'success', 'message' => 'Email berhasil diperbarui.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Gagal memperbarui email.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Kode verifikasi salah atau data tidak ditemukan.']);
}
?>
