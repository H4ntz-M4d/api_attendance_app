<?php
include '../connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nis = $_POST['nis'];
    $new_password = $_POST['siswa_password'];

    if(!empty($nis)&&!empty($new_password)){
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

        $query = "UPDATE siswa SET siswa_password = ? WHERE nis = ?";
        $stmt = $connectNow->prepare($query);
        $stmt->bind_param("ss",$hashed_password, $nis);

        if ($stmt->execute()){
            $response = (['status' => 'success', 'message' =>'Password Berhasil Diperbarui']);
        }else{
            $response = (['status' => 'error', 'message' =>'Password Gagal Diperbarui']);
        }

        $stmt->close();
    }else{
        $response = (['status' => 'error', 'message' =>'Data Tidak Lengkap']);
    }
    
    echo json_encode($response);
}else{
    echo json_encode(['status' => 'error', 'message' =>'Metode permintaan tidak valid']);
}

$connectNow->close();
?>