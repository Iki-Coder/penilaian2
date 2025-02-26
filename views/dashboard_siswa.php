<?php
session_start();
include '../config/database.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'siswa') {
    header("Location: login.php");
    exit;
}

$siswa_id = $_SESSION['user_id'];

$query = "SELECT mata_pelajaran, nilai_harian, uh_1, uh_2, nilai_akhir_semester, rata_rata FROM nilai WHERE siswa_id = ?";
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
    <h2>Selamat datang, Siswa!</h2>

    <p><a href="input_nilai.php">Masukkan Nilai</a></p> 

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
            <td><?php echo $row['mata_pelajaran']; ?></td>
            <td><?php echo $row['nilai_harian']; ?></td>
            <td><?php echo $row['uh_1']; ?></td>
            <td><?php echo $row['uh_2']; ?></td>
            <td><?php echo $row['nilai_akhir_semester']; ?></td>
            <td><?php echo isset($row['rata_rata']) ? $row['rata_rata'] : 'Belum Ada'; ?></td>
        </tr>
        <?php } ?>
    </table>

    <p><a href="../controllers/logout.php">Logout</a></p>
</body>
</html>
