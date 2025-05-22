<?php
include "../connection.php";
include "../Users.php";
session_start();

if (!isset($_SESSION['status'])) {
    header("Location:../index.php?message=Anda belum Login");
    exit();
}
$tgl = date("Y-m-d");


// Check if all required POST fields are set
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
    $nama_anak     = $_POST['nama_anak'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $nama_ibu      = $_POST['nama_ibu'];
    $tanggal       = $_POST['tgl_sekarang'];
    $usia          = $_POST['usia'];
    $imunisasi     = $_POST['imunisasi'];
    $vitamin_a     = $_POST['vitamin_a'];
    $keterangan    = $_POST['keterangan'];

    // Tambahkan anak baru
    $insert_anak = "INSERT INTO anak (nama_anak, jenis_kelamin, tanggal_lahir, nama_ibu) VALUES (?, ?, CURDATE(), ?)";
    $stmt_insert_anak = mysqli_prepare($conn, $insert_anak);
    mysqli_stmt_bind_param($stmt_insert_anak, "sss", $nama_anak, $jenis_kelamin, $nama_ibu);
    mysqli_stmt_execute($stmt_insert_anak);
    $anak_id = mysqli_insert_id($conn);

    // Insert imunisasi
    $query = "INSERT INTO imunisasi (anak_id, tanggal, usia, imunisasi, vitamin_a, keterangan)
              VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "isisss", $anak_id, $tanggal, $usia, $imunisasi, $vitamin_a, $keterangan);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: data_imunisasi.php?status=success");
        exit();
    } else {
        echo "Terjadi kesalahan saat menyimpan data imunisasi: " . mysqli_error($conn);
    }
} else {
    echo "Semua data wajib diisi.";
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Imunisasi Anak</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f4f6f9;
        }

        .sidebar {
            height: 100vh;
            background-color: #2e3b55;
            color: white;
            padding-top: 20px;
        }

        .sidebar h4 {
            margin-left: 20px;
        }

        .sidebar a {
            color: white;
            display: block;
            padding: 10px 20px;
            text-decoration: none;
        }

        .sidebar a.active, .sidebar a:hover {
            background-color: #1abc9c;
        }

        .content {
            padding: 30px;
        }

        .form-section {
            background: white;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        }

        .form-section h5 {
            margin-bottom: 20px;
            font-weight: bold;
        }

        label {
            font-weight: 500;
        }

        input[readonly] {
            background-color: #e9ecef;
        }

        .btn-proses {
            background-color: #1abc9c;
            border: none;
        }

        .btn-proses:hover {
            background-color: #17a589;
        }

        .vitamin-radio {
            margin-right: 10px;
        }
    </style>
</head>
<body>
<div class="d-flex">
    <!-- Sidebar -->
    <div class="sidebar col-2">
        <h4 class="text-center">POSYANDU</h4>
        <a href="index.php" class="active">Imunisasi Anak</a>
        <a href="penimbanganAnak.php">Penimbangan Anak</a>
        <hr class="text-light">
        <a href="data_imunisasi.php">Data Imunisasi</a>
        <a href="data_penimbangan.php">Data Penimbangan</a>
        <a href="add_user.php">Tambah Pengguna</a>

        
    </div>

    <!-- Content -->
    <div class="content col-10">
        <h3>Imunisasi Anak</h3>

        <form action="proses_imunisasi.php" method="POST" class="form-section mt-4">
            <!-- Section: Data Anak -->
            <div class="mb-3 row">
               <!-- Editable Fields -->
<div class="mb-3 row">
    <label class="col-sm-2 col-form-label">Nama Anak</label>
    <div class="col-sm-9">
        <input type="text" class="form-control" name="nama_anak" required>
    </div>
    <div class="col-sm-1">
        <button class="btn btn-outline-warning w-100" type="button">Pilih</button>
    </div>
</div>

<div class="mb-3">
                <label>Jenis Kelamin</label>
                <input type="text" class="form-control" name="jenis_kelamin">

<div class="mb-3">
    <label>Nama Ibu</label>
    <input type="text" class="form-control" name="nama_ibu" required>
</div>

            </div>

            <!-- Section: Imunisasi -->
            <hr>
            <div class="mb-3">
                <label>Tanggal Sekarang</label>
                <input type="date" class="form-control" name="tgl_sekarang" value="<?= $tgl ?>">
            </div>
            <div class="mb-3">
                <label>Usia</label>
                <div class="input-group">
                    <input type="number" class="form-control" name="usia">
                    <span class="input-group-text">bulan</span>
                </div>
            </div>
            <div class="mb-3">
                <label>Imunisasi</label>
                <input type="text" class="form-control" name="imunisasi">
            </div>
            <div class="mb-3">
                <label>Vitamin A</label><br>
                <label class="vitamin-radio"><input type="radio" name="vitamin_a" value="Merah"> Merah</label>
                <label class="vitamin-radio"><input type="radio" name="vitamin_a" value="Biru"> Biru</label>
            </div>
            <div class="mb-3">
                <label>Keterangan</label>
                <textarea class="form-control" name="keterangan" rows="3"></textarea>
            </div>

            <button type="submit" class="btn btn-proses text-white">Proses</button>
        </form>
    </div>
</div>
 
</body>
</html>
