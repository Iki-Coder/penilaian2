<?php
session_start();
include '../config/database.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'siswa') {
    header("Location: login.php");
    exit;
}

$siswa_id = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $mapel = $_POST['mapel'];
    $nilai_harian = $_POST['nilai_harian'];
    $uh_1 = $_POST['uh_1'];
    $uh_2 = $_POST['uh_2'];
    $nilai_akhir_semester = $_POST['nilai_akhir_semester'];

    $rata_rata = ($nilai_harian * 0.1) + ($uh_1 * 0.2) + ($uh_2 * 0.2) + ($nilai_akhir_semester * 0.5);

    $stmt = $conn->prepare("INSERT INTO nilai (siswa_id, mata_pelajaran, nilai_harian, uh_1, uh_2, nilai_akhir_semester, rata_rata) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("issdddd", $siswa_id, $mapel, $nilai_harian, $uh_1, $uh_2, $nilai_akhir_semester, $rata_rata);

    if ($stmt->execute()) {
        echo "Nilai berhasil disimpan!";
        header("Location: dashboard_siswa.php");
        exit;
    } else {
        echo "Gagal menyimpan nilai!";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Nilai</title>
</head>
<body>
    <h2>Input Nilai</h2>
    <form action="" method="POST">
        <label>Mata Pelajaran:</label>
        <input type="text" name="mapel" required><br>

        <label>Nilai Harian:</label>
        <input type="number" name="nilai_harian" required><br>

        <label>UH 1:</label>
        <input type="number" name="uh_1" required><br>

        <label>UH 2:</label>
        <input type="number" name="uh_2" required><br>

        <label>Nilai Akhir Semester:</label>
        <input type="number" name="nilai_akhir_semester" required><br>

        <button type="submit">Simpan Nilai</button>
    </form>

    <a href="dashboard_siswa.php">Kembali ke Dashboard</a>
</body>
</html>
