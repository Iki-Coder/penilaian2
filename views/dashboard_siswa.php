<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'siswa') {
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
    <title>Dashboard Siswa</title>
</head>
<body>
    <h2>Dashboard Siswa</h2>
    <a href="../controllers/logout.php">Logout</a>

    <h3>Daftar Nilai</h3>
    <table border="1">
        <tr>
            <th>Mata Pelajaran</th>
            <th>Nilai</th>
        </tr>
        <?php
        $user_id = $_SESSION['user_id'];
        $query = "SELECT nilai.mata_pelajaran, nilai.nilai 
                  FROM nilai 
                  JOIN siswa ON nilai.siswa_id = siswa.id 
                  WHERE siswa.id = '$user_id'";
        $result = $conn->query($query);
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['mata_pelajaran']}</td>
                    <td>{$row['nilai']}</td>
                  </tr>";
        }
        ?>
    </table>
</body>
</html>
