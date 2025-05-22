<?php
include "../connection.php";
session_start();

if (!isset($_SESSION['status'])) {
    header("Location:../index.php?message=Anda belum Login");
    exit();
}

// Check if all required fields are submitted
if (
    isset($_POST['nama_anak']) &&
    isset($_POST['jenis_kelamin']) &&
    isset($_POST['nama_ibu']) &&
    isset($_POST['tgl_sekarang']) &&
    isset($_POST['usia']) &&
    isset($_POST['imunisasi']) &&
    isset($_POST['vitamin_a']) &&
    isset($_POST['keterangan'])
) {
    // Get data from POST
    $nama_anak     = $_POST['nama_anak'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
$allowed_gender = ['Laki-laki', 'Perempuan'];

if (!in_array($jenis_kelamin, $allowed_gender)) {
    echo "Jenis kelamin tidak valid. Harus 'Laki-laki' atau 'Perempuan'.";
    exit();
}
    $nama_ibu      = $_POST['nama_ibu'];
    $tanggal       = $_POST['tgl_sekarang'];
    $usia          = $_POST['usia'];
    $imunisasi     = $_POST['imunisasi'];
    $vitamin_a     = $_POST['vitamin_a'];
    $keterangan    = $_POST['keterangan'];

    // Insert child (anak) if not already exists (optional: add check here)
    $insert_anak = "INSERT INTO anak (nama_anak, jenis_kelamin, tanggal_lahir, nama_ibu)
                    VALUES (?, ?, CURDATE(), ?)";
    $stmt_anak = mysqli_prepare($conn, $insert_anak);
    mysqli_stmt_bind_param($stmt_anak, "sss", $nama_anak, $jenis_kelamin, $nama_ibu);

    if (!mysqli_stmt_execute($stmt_anak)) {
        echo "Gagal menambahkan anak: " . mysqli_error($conn);
        exit();
    }

    $anak_id = mysqli_insert_id($conn); // Get the last inserted anak_id

    // Insert imunisasi
    $insert_imunisasi = "INSERT INTO imunisasi (anak_id, tanggal, usia, imunisasi, vitamin_a, keterangan)
                         VALUES (?, ?, ?, ?, ?, ?)";
    $stmt_imunisasi = mysqli_prepare($conn, $insert_imunisasi);
    mysqli_stmt_bind_param($stmt_imunisasi, "isisss", $anak_id, $tanggal, $usia, $imunisasi, $vitamin_a, $keterangan);

    if (mysqli_stmt_execute($stmt_imunisasi)) {
        header("Location: data_imunisasi.php?status=success");
        exit();
    } else {
        echo "Gagal menyimpan data imunisasi: " . mysqli_error($conn);
    }
} else {
    echo "Semua data wajib diisi.";
}
?>
