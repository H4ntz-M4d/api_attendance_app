<?php

include '../connection.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';

$nis = $_POST['nis'];
$email_lama = $_POST['email_lama'];


$query = "SELECT siswa_email FROM siswa WHERE nis='$nis'";
$result = $connectNow->query($query);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    if ($row['siswa_email'] === $email_lama) {
        $verifikasi_kode = rand(1000, 9999);
        $update_query = "UPDATE siswa SET verifikasi_kode='$verifikasi_kode' WHERE nis='$nis'";

        if ($connectNow->query($update_query) === TRUE) {
            $mail = new PHPMailer(true);

            try {
                //Server settings
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'wildaninafis203@gmail.com';
                $mail->Password = 'dqayjbxwbevkkbly';
                $mail->Port = 587;

                //Recipients
                $mail->setFrom('wildaninafis203@gmail.com', 'Attendance App');
                $mail->addAddress($email_lama);

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
    }else{
        echo json_encode(['status' => 'error', 'message' => 'Email lama tidak cocok.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Data tidak ditemukan.']);
}
?>