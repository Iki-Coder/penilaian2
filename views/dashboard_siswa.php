<?php
session_start();
include '../config/database.php';

// Cek apakah user login sebagai siswa
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'siswa') {
    header("Location: login.php");
    exit;
}

$siswa_id = $_SESSION['user_id'];

// Ambil nilai siswa dari database
$query = "SELECT mapel, nilai_harian, uh_1, uh_2, nilai_akhir_semester, rata_rata FROM nilai WHERE siswa_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $siswa_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Siswa</title>
</head>
<body>
    <h2>Dashboard Siswa</h2>

    <h3>Nilai Kamu</h3>
    <table border="1">
        <tr>
            <th>Mata Pelajaran</th>
            <th>Nilai Harian</th>
            <th>UH 1</th>
            <th>UH 2</th>
            <th>Nilai Akhir Semester</th>
            <th>Rata-rata</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) { ?>
        <tr>
            <td><?= $row['mapel'] ?></td>
            <td><?= $row['nilai_harian'] ?></td>
            <td><?= $row['uh_1'] ?></td>
            <td><?= $row['uh_2'] ?></td>
            <td><?= $row['nilai_akhir_semester'] ?></td>
            <td><?= number_format($row['rata_rata'], 2) ?></td>
        </tr>
        <?php } ?>
    </table>

    <a href="../controllers/logout.php">Logout</a>
</body>
</html>
