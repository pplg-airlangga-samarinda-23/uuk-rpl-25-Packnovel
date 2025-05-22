
<?php $tgl = date('Y-m-d'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Penimbangan Anak</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f4f6f9;
        }

        .sidebar {
            height: 100vh;
            background-color:rgb(55, 77, 120);
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

        .radio-group {
            margin-right: 15px;
        }
    </style>
</head>
<body>
<div class="d-flex">
    <!-- Sidebar -->
    <div class="sidebar col-3">
        <h4 class="text-center">POSYANDU</h4>
        <a href="index.php">Imunisasi Anak</a>
        <a href="penimbanganAnak.php" class="active">Penimbangan Anak</a>
        <hr class="text-light">
        <a href="data_imunisasi.php">Data Imunisasi</a>
        <a href="data_penimbangan.php">Data Penimbangan</a>
        <a href="add_user.php">Tambah Pengguna</a>

    </div>

    <!-- Content -->
    <div class="content col-10">
        <h3>Penimbangan Anak</h3>

        <form action="proses_penimbangan.php" method="POST" class="form-section mt-4">
            <!-- Section: Data Anak -->
            <div class="mb-3 row">
                <label class="col-sm-2 col-form-label">Nama Anak</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" name="nama_anak">
                </div>
                <div class="col-sm-1">
                    <button class="btn btn-outline-warning w-100" type="button">Pilih</button>
                </div>
            </div>
            <div class="mb-3">
                <label>Jenis Kelamin</label>
                <input type="text" class="form-control" name="jenis_kelamin">
            </div>
            <div class="mb-3">
                <label>Tanggal Lahir</label>
                <input type="date" class="form-control" name="tgl_lahir">
            </div>
            <div class="mb-3">
                <label>Nama Ibu</label>
                <input type="text" class="form-control" name="nama_ibu">
            </div>

            <!-- Section: Pertumbuhan -->
            <hr>
            <div class="mb-3">
                <label>Tanggal Sekarang</label>
                <input type="date" class="form-control" name="tgl_sekarang" value="<?= $tgl ?>">
            </div>
            <div class="mb-3">
                <label>Usia</label>
                <div class="input-group">
                    <input type="number" class="form-control" name="usia" required>
                    <span class="input-group-text">bulan</span>
                </div>
            </div>
            <div class="mb-3">
                <label>Berat Badan (BB)</label>
                <div class="input-group">
                    <input type="number" step="0.1" class="form-control" name="berat_badan" required>
                    <span class="input-group-text">kg</span>
                </div>
            </div>
            <div class="mb-3">
                <label>Tinggi Badan (TB)</label>
                <div class="input-group">
                    <input type="number" step="0.1" class="form-control" name="tinggi_badan" required>
                    <span class="input-group-text">cm</span>
                </div>
            </div>
            <div class="mb-3">
                <label>Deteksi</label><br>
                <label class="radio-group"><input type="radio" name="deteksi" value="Sesuai"> Sesuai</label>
                <label class="radio-group"><input type="radio" name="deteksi" value="Tidak Sesuai"> Tidak Sesuai</label>
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
