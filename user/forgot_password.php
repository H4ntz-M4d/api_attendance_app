<?php

include '../connection.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';

$nis = $_POST['nis'];
$tgl_lahir = $_POST['tgl_lahir'];
$siswa_email = $_POST['siswa_email'];

$tgl_lahir = date("Y-m-d", strtotime($tgl_lahir));

$query = "SELECT * FROM siswa WHERE nis='$nis' AND tgl_lahir='$tgl_lahir' AND siswa_email='$siswa_email'";
$result = $connectNow->query($query);

if ($result->num_rows > 0) {
    $verifikasi_kode = rand(1000, 9999);
    $update_query = "UPDATE siswa SET verifikasi_kode='$verifikasi_kode' WHERE nis='$nis'";
    
    if ($connectNow->query($update_query) === TRUE) {
        $mail = new PHPMailer(true);
        
        try {
            //Server settings
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'gunakudo01@gmail.com';
            $mail->Password = 'axdpxvvfpgorhtim';
            $mail->Port = 587;

            //Recipients
            $mail->setFrom('gunakudo01@gmail.com', 'Attendance App');
            $mail->addAddress($siswa_email);

            //Content
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
} else {
    echo json_encode(['status' => 'error', 'message' => 'Data tidak ditemukan.']);
}
?>
