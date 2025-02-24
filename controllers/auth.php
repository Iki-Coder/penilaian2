<?php
session_start();
include '../config/database.php';

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $query->bind_param("s", $username);
    $query->execute();
    $result = $query->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];

        if ($user['role'] == 'guru') {
            header("Location: ../views/dashboard_guru.php");
        } else {
            header("Location: ../views/dashboard_siswa.php");
        }
        exit;
    } else {
        echo "Username atau password salah!";
    }
}
?>
