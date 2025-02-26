<?php
session_start();
include '../config/database.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'guru') {
    header("Location: login.php");
    exit;
}

$query = "SELECT nilai.id, users.username AS nama, nilai.mata_pelajaran, nilai.nilai_harian, nilai.uh_1, nilai.uh_2, nilai.nilai_akhir_semester, nilai.rata_rata 
          FROM nilai JOIN users ON nilai.siswa_id = users.id WHERE users.role = 'siswa'";
$result = $conn->query($query);

if (!$result) {
    die("Query error: " . $conn->error);
}

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
    
    <table border="1">
        <tr>
            <th>Nama Siswa</th>
            <th>Mata Pelajaran</th>
            <th>Nilai Harian</th>
            <th>UH 1</th>
            <th>UH 2</th>
            <th>Nilai Akhir Semester</th>
            <th>Rata-rata</th>
            <th>Aksi</th>
        </tr>
        
        <?php while ($row = $result->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $row['nama']; ?></td>
            <td><?php echo $row['mata_pelajaran']; ?></td>
            <td><?php echo $row['nilai_harian']; ?></td>
            <td><?php echo $row['uh_1']; ?></td>
            <td><?php echo $row['uh_2']; ?></td>
            <td><?php echo $row['nilai_akhir_semester']; ?></td>
            <td><?php echo $row['rata_rata']; ?></td>
            <td>
                <a href="edit_nilai.php?id=<?php echo $row['id']; ?>">Edit</a>
            </td>
        </tr>
        <?php } ?>
    </table>

    <br>
    <a href="../controllers/logout.php">Logout</a>
</body>
</html>
