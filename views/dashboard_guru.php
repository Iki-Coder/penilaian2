<?php
session_start();
include '../config/database.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'guru') {
    header("Location: login.php");
    exit;
}

$query = "SELECT nilai.id, users.username AS nama, nilai.mapel, nilai.nilai_harian, nilai.uh_1, nilai.uh_2, nilai.nilai_akhir_semester, nilai.rata_rata 
          FROM nilai JOIN users ON nilai.siswa_id = users.id WHERE users.role = 'siswa'";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Guru</title>
</head>
<body>
    <h2>Dashboard Guru</h2>
    <a href="input_nilai.php">Tambah Nilai</a>

    <h3>Daftar Nilai Siswa</h3>
    <table border="1">
    <tr>
        <th>Nama Siswa</th>
        <th>Mata Pelajaran</th>
        <th>Nilai Harian</th>
        <th>UH 1</th>
        <th>UH 2</th>
        <th>Nilai Akhir Semester</th>
        <th>Rata-rata</th>
        <th>Hapus</th>
    </tr>

    <?php
    $query = "SELECT nilai.id, users.username AS nama, nilai.mapel, nilai.nilai_harian, nilai.uh_1, nilai.uh_2, 
                     nilai.nilai_akhir_semester, nilai.rata_rata 
              FROM nilai JOIN users ON nilai.siswa_id = users.id WHERE users.role = 'siswa'";
    $result = $conn->query($query);

    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['nama']}</td>
                <td>{$row['mapel']}</td>
                <td>{$row['nilai_harian']}</td>
                <td>{$row['uh_1']}</td>
                <td>{$row['uh_2']}</td>
                <td>{$row['nilai_akhir_semester']}</td>
                <td>{$row['rata_rata']}</td>
                <td>
                    <a href='../controllers/hapus_nilai.php?id={$row['id']}' onclick='return confirm(\"Yakin ingin menghapus nilai ini?\")'>Hapus</a>
                </td>
              </tr>";
    }
    ?>
</table>


    <a href="../controllers/logout.php">Logout</a>
</body>
</html>
