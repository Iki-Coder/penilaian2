<?php
session_start();
include '../config/database.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'guru') {
    header("Location: ../login.php");
    exit;
}

$siswaQuery = "SELECT id, username FROM users WHERE role = 'siswa'";
$siswaResult = $conn->query($siswaQuery);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $siswa_id = $_POST['siswa_id'];
    $mapel = $_POST['mapel'];
    $nilai_harian = $_POST['nilai_harian'];
    $uh_1 = $_POST['uh_1'];
    $uh_2 = $_POST['uh_2'];
    $nilai_akhir_semester = $_POST['nilai_akhir_semester'];

    $bobot_harian = $nilai_harian * 0.1;
    $bobot_uh1 = $uh_1 * 0.2;
    $bobot_uh2 = $uh_2 * 0.2;
    $bobot_nilai_akhir = $nilai_akhir_semester * 0.5;

    $rata_rata = $bobot_harian + $bobot_uh1 + $bobot_uh2 + $bobot_nilai_akhir;

    $query = "INSERT INTO nilai (siswa_id, mapel, nilai_harian, uh_1, uh_2, nilai_akhir_semester, rata_rata) 
              VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("isiiidd", $siswa_id, $mapel, $nilai_harian, $uh_1, $uh_2, $nilai_akhir_semester, $rata_rata);

    if ($stmt->execute()) {
        header("Location: ../views/dashboard_guru.php?pesan=sukses");
        exit;
    } else {
        die("Gagal menyimpan nilai! Error: " . $stmt->error);
    }
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
    <h2>Input Nilai Siswa</h2>
    <form method="POST">
        <label>Pilih Siswa:</label>
        <select name="siswa_id" required>
            <?php while ($siswa = $siswaResult->fetch_assoc()) { ?>
                <option value="<?php echo $siswa['id']; ?>"><?php echo $siswa['username']; ?></option>
            <?php } ?>
        </select><br>

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

    <p><a href="dashboard_guru.php">Kembali ke Dashboard Guru</a></p>
</body>
</html>
