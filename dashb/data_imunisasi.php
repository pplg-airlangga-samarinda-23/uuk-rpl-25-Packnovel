<?php
include "../connection.php";
session_start();

if (!isset($_SESSION['status'])) {
    header("Location:../index.php?message=Anda belum Login");
    exit();
}

$query = "
    SELECT 
        i.id,
        a.nama_anak,
        a.jenis_kelamin,
        a.nama_ibu,
        i.tanggal,
        i.usia,
        i.imunisasi,
        i.vitamin_a,
        i.keterangan
    FROM imunisasi i
    JOIN anak a ON i.anak_id = a.id
    ORDER BY i.tanggal DESC
";

$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Data Imunisasi</title>
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

        .table th {
            background-color: #1abc9c;
            color: white;
        }
    </style>
</head>
<body>
<div class="d-flex">
    <!-- Sidebar -->
    <div class="sidebar col-2">
        <h4 class="text-center">POSYANDU</h4>
        <a href="index.php">Imunisasi Anak</a>
        <a href="penimbanganAnak.php">Penimbangan Anak</a>
        <hr class="text-light">
        <a href="data_imunisasi.php" class="active">Data Imunisasi</a>
        <a href="data_penimbangan.php">Data Penimbangan</a>
        <a href="add_user.php">Tambah Pengguna</a>
    </div>

    <!-- Content -->
    <div class="content col-10">
        <h3>Data Imunisasi Anak</h3>

        <table class="table table-bordered table-striped mt-4">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Anak</th>
                    <th>Jenis Kelamin</th>
                    <th>Nama Ibu</th>
                    <th>Tanggal</th>
                    <th>Usia (bln)</th>
                    <th>Jenis Imunisasi</th>
                    <th>Vitamin A</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>
                            <td>{$no}</td>
                            <td>{$row['nama_anak']}</td>
                            <td>{$row['jenis_kelamin']}</td>
                            <td>{$row['nama_ibu']}</td>
                            <td>{$row['tanggal']}</td>
                            <td>{$row['usia']}</td>
                            <td>{$row['imunisasi']}</td>
                            <td>{$row['vitamin_a']}</td>
                            <td>{$row['keterangan']}</td>
                          </tr>";
                    $no++;
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>
