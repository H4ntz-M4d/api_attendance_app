<?php

include '../connection.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';

$nis = $_POST['nis'];
$tgl_lahir = $_POST['tgl_lahir'];
$siswa_email = $_POST['siswa_email'];

$tgl_lahir = date("Y-m-d", strtotime($tgl_lahir));

// Query to check in "guru" table
$queryGuru = "SELECT * FROM guru WHERE nip='$nis' AND tgl_lahir='$tgl_lahir' AND guru_email='$siswa_email'";
$resultGuru = $connectNow->query($queryGuru);

if ($resultGuru->num_rows > 0) {
    $userType = 'guru';
    $userIdField = 'nip';
    $update_query = "UPDATE guru SET verifikasi_kode=? WHERE nip=?";
} else {
    // Query to check in "siswa" table if not found in "guru" table
    $querySiswa = "SELECT * FROM siswa WHERE nis='$nis' AND tgl_lahir='$tgl_lahir' AND siswa_email='$siswa_email'";
    $resultSiswa = $connectNow->query($querySiswa);
    
    if ($resultSiswa->num_rows > 0) {
        $userType = 'siswa';
        $userIdField = 'nis';
        $update_query = "UPDATE siswa SET verifikasi_kode=? WHERE nis=?";
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Data tidak ditemukan.']);
        exit();
    }
}

// If user is found in either "guru" or "siswa" table, update verification code and send email
$verifikasi_kode = rand(1000, 9999);
$stmt = $connectNow->prepare($update_query);
$stmt->bind_param('si', $verifikasi_kode, $nis);

if ($stmt->execute() === TRUE) {
    $mail = new PHPMailer(true);
    
    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'wildaninafis203@gmail.com';
        $mail->Password = 'dqayjbxwbevkkbly';
        $mail->Port = 587;

        // Recipients
        $mail->setFrom('wildaninafis203@gmail.com', 'Attendance App');
        $mail->addAddress($siswa_email);

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Kode Verifikasi Anda';
        $mail->Body = "Kode verifikasi Anda adalah: $verifikasi_kode";

        $mail->send();
        echo json_encode(['status' => 'success', 'message' => 'Kode verifikasi telah dikirim ke email Anda.']);
    } catch (Exception $e) {
        echo json_encode(['status' => 'error', 'message' => "Pesan tidak dapat dikirim. Mailer Error: {$mail->ErrorInfo}"]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Gagal memperbarui kode verifikasi.']);
}

?>
