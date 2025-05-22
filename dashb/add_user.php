<?php
include "../connection.php";
session_start();

// Only allow if logged in and role is admin
if (!isset($_SESSION['status']) || $_SESSION['role'] != 'admin') {
    header("Location:../index.php?message=Akses ditolak");
    exit();
}

$message = "";

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fullname = $_POST['fullname'];
    $username = $_POST['username'];
    $password = md5($_POST['password']); // NOTE: replace with password_hash() for production
    $role = $_POST['role'];
    $employee_id = $_POST['employee_id'];

    // Check if username already exists
    $check = mysqli_query($conn, "SELECT * FROM users WHERE username='$username'");
    if (mysqli_num_rows($check) > 0) {
        $message = "Username sudah digunakan.";
    } else {
        $insert = mysqli_query($conn, "INSERT INTO users (fullname, username, password, role, employee_id)
                                       VALUES ('$fullname', '$username', '$password', '$role', '$employee_id')");
        if ($insert) {
            $message = "User berhasil ditambahkan.";
        } else {
            $message = "Terjadi kesalahan saat menambahkan user.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tambah User - POSYANDU</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f6f9;
        }
        .container {
            max-width: 600px;
            margin-top: 60px;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .btn-primary {
            background-color: #1abc9c;
            border: none;
        }
        .btn-primary:hover {
            background-color: #17a589;
        }
    </style>
</head>
<body>
<div class="container">
    <h3 class="mb-4">Tambah User Baru</h3>

    <?php if ($message): ?>
        <div class="alert alert-info"><?= $message ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3">
            <label>Nama Lengkap</label>
            <input type="text" class="form-control" name="fullname" required>
        </div>
        <div class="mb-3">
            <label>Username</label>
            <input type="text" class="form-control" name="username" required>
        </div>
        <div class="mb-3">
            <label>Password</label>
            <input type="password" class="form-control" name="password" required>
        </div>
        <div class="mb-3">
            <label>Role</label>
            <select name="role" class="form-select" required>
                <option value="bidan">Bidan</option>
                <option value="admin">Admin</option>
            </select>
        </div>
        <div class="mb-3">
            <label>ID Pegawai</label>
            <input type="text" class="form-control" name="employee_id" required>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>
</body>
</html>
