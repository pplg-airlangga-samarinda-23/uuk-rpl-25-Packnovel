<?php
include "../connection.php";
session_start();

if (!isset($_SESSION['status'])) {
    header("Location:../index.php?message=Anda belum Login");
    exit();
}

// Check if all required POST fields are present
if (
    isset($_POST['nama_anak']) &&
    isset($_POST['jenis_kelamin']) &&
    isset($_POST['nama_ibu']) &&
    isset($_POST['tgl_sekarang']) &&
    isset($_POST['usia']) &&
    isset($_POST['berat_badan']) &&
    isset($_POST['tinggi_badan']) &&
    isset($_POST['deteksi']) &&
    isset($_POST['keterangan'])
) {
    // Get POST data
    $nama_anak     = $_POST['nama_anak'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $nama_ibu      = $_POST['nama_ibu'];
    $tanggal       = $_POST['tgl_sekarang'];
    $usia          = $_POST['usia'];
    $berat_badan   = $_POST['berat_badan'];
    $tinggi_badan  = $_POST['tinggi_badan'];
    $deteksi       = $_POST['deteksi'];
    $keterangan    = $_POST['keterangan'];

    // Insert into anak
    $insert_anak = "INSERT INTO anak (nama_anak, jenis_kelamin, tanggal_lahir, nama_ibu)
                    VALUES (?, ?, CURDATE(), ?)";
    $stmt_anak = mysqli_prepare($conn, $insert_anak);
    mysqli_stmt_bind_param($stmt_anak, "sss", $nama_anak, $jenis_kelamin, $nama_ibu);

    if (!mysqli_stmt_execute($stmt_anak)) {
        echo "Gagal menambahkan anak: " . mysqli_error($conn);
        exit();
    }

    $anak_id = mysqli_insert_id($conn);

    // Insert into penimbangan
    $insert_penimbangan = "INSERT INTO penimbangan 
        (anak_id, tanggal, usia, berat_badan, tinggi_badan, deteksi, keterangan)
        VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt_penimbangan = mysqli_prepare($conn, $insert_penimbangan);
    mysqli_stmt_bind_param($stmt_penimbangan, "isiddss", 
        $anak_id, $tanggal, $usia, $berat_badan, $tinggi_badan, $deteksi, $keterangan);

    if (mysqli_stmt_execute($stmt_penimbangan)) {
        header("Location: data_penimbangan.php?status=success");
        exit();
    } else {
        echo "Gagal menyimpan data penimbangan: " . mysqli_error($conn);
    }
} else {
    echo "Semua data wajib diisi.";
}
?>
