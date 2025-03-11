<?php
session_start();
include '../config/database.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'guru') {
    header("Location: ../login.php");
    exit;
}

if (isset($_GET['id'])) {
    $id_nilai = $_GET['id'];

    $query = "DELETE FROM nilai WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id_nilai);

    if ($stmt->execute()) {
        header("Location: ../views/dashboard_guru.php?pesan=sukses_hapus");
        exit;
    } else {
        die("Gagal menghapus nilai! Error: " . $stmt->error);
    }
} else {
    header("Location: ../views/dashboard_guru.php?pesan=gagal_hapus");
    exit;
}
?>
