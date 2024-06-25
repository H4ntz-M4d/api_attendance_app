<?php
include '../connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nis = $_POST['nis'];
    $new_password = $_POST['password']; 

    if (!empty($nis) && !empty($new_password)) {
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

        // First, check and update the "guru" table
        $queryGuru = "UPDATE guru SET guru_password = ? WHERE nip = ?";
        $stmtGuru = $connectNow->prepare($queryGuru);
        $stmtGuru->bind_param("ss", $hashed_password, $nis);

        if ($stmtGuru->execute() && $stmtGuru->affected_rows > 0) {
            $response = ['status' => 'success', 'message' => 'Password Berhasil Diperbarui (Guru)'];
            $stmtGuru->close();
        } else {
            $stmtGuru->close();

            // If not updated in "guru", check and update the "siswa" table
            $querySiswa = "UPDATE siswa SET siswa_password = ? WHERE nis = ?";
            $stmtSiswa = $connectNow->prepare($querySiswa);
            $stmtSiswa->bind_param("ss", $hashed_password, $nis);

            if ($stmtSiswa->execute() && $stmtSiswa->affected_rows > 0) {
                $response = ['status' => 'success', 'message' => 'Password Berhasil Diperbarui (Siswa)'];
            } else {
                $response = ['status' => 'error', 'message' => 'Password Gagal Diperbarui'];
            }

            $stmtSiswa->close();
        }
    } else {
        $response = ['status' => 'error', 'message' => 'Data Tidak Lengkap'];
    }

    echo json_encode($response);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Metode permintaan tidak valid']);
}

$connectNow->close();
?>
