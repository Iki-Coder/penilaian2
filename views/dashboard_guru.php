<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'guru') {
    header("Location: login.php");
    exit;
}

include '../config/database.php';
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
    <a href="../controllers/logout.php">Logout</a>

    <h3>Tambah Nilai Siswa</h3>
    <form action="../controllers/nilai.php" method="POST">
        <label>Nama Siswa:</label>
        <select name="siswa_id">
            <?php
            $result = $conn->query("SELECT * FROM siswa");
            while ($row = $result->fetch_assoc()) {
                echo "<option value='{$row['id']}'>{$row['nama']}</option>";
            }
            ?>
        </select><br>

        <label>Mata Pelajaran:</label>
        <input type="text" name="mata_pelajaran" required><br>

        <label>Nilai:</label>
        <input type="number" name="nilai" required><br>

        <button type="submit" name="tambah_nilai">Tambah</button>
    </form>

    <h3>Daftar Nilai</h3>
    <table border="1">
        <tr>
            <th>Nama Siswa</th>
            <th>Mata Pelajaran</th>
            <th>Nilai</th>
            <th>Aksi</th>
        </tr>
        <?php
        $query = "SELECT nilai.id, siswa.nama, nilai.mata_pelajaran, nilai.nilai 
                  FROM nilai JOIN siswa ON nilai.siswa_id = siswa.id";
        $result = $conn->query($query);
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['nama']}</td>
                    <td>{$row['mata_pelajaran']}</td>
                    <td>{$row['nilai']}</td>
                    <td>
                        <a href='../controllers/nilai.php?hapus={$row['id']}'>Hapus</a>
                    </td>
                  </tr>";
        }
        ?>
    </table>
</body>
</html>

