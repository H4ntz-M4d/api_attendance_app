<?php

include '../connection.php';

$nis = $_POST['nis']; // Ambil dari sesi pengguna yang sedang login
$role = $_POST['role'];
$verification_code = $_POST['verifikasi_kode'];
$email_baru = $_POST['email_baru'];

$table = '';
$id = '';
$email = '';

if ($role == 'guru') {
  $table = 'guru';
  $id = 'nip';
  $email = 'guru_email';
} else if($role == 'siswa') {
  $table = 'siswa';
  $id = 'nis';
  $email = 'siswa_email';
}

$query = "SELECT * FROM $table WHERE $id='$nis' AND verifikasi_kode='$verification_code'";
$result = $connectNow->query($query);

if ($result->num_rows > 0) {
    $update_query = "UPDATE $table SET $email='$email_baru', verifikasi_kode=NULL WHERE $id='$nis'";
    
    if ($connectNow->query($update_query) === TRUE) {
        echo json_encode(['status' => 'success', 'message' => 'Email berhasil diperbarui.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Gagal memperbarui email.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Kode verifikasi salah atau data tidak ditemukan.']);
}
?>
