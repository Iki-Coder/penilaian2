<?php
session_start();
include '../config/database.php';

if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    // Cek apakah username sudah ada
    $cek_user = $conn->prepare("SELECT id FROM users WHERE username = ?");
    $cek_user->bind_param("s", $username);
    $cek_user->execute();
    $cek_user->store_result();

    if ($cek_user->num_rows > 0) {
        echo "Username sudah digunakan!";
        exit;
    }
    $cek_user->close();

    // Hash password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Simpan ke database
    $stmt = $conn->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $hashed_password, $role);
    if ($stmt->execute()) {
        echo "Registrasi berhasil! <a href='../views/login.php'>Login di sini</a>";
    } else {
        echo "Gagal registrasi!";
    }
    $stmt->close();
}
?>
