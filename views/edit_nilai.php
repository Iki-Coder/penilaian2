<?php
session_start();
include '../config/database.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'guru') {
    header("Location: login.php");
    exit;
}

$id = $_GET['id'];
$query = "SELECT * FROM nilai WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$nilai = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nilai_harian = $_POST['nilai_harian'];
    $uh_1 = $_POST['uh_1'];
    $uh_2 = $_POST['uh_2'];
    $nilai_akhir = $_POST['nilai_akhir_semester'];

    $rata_rata = ($nilai_harian * 0.1) + ($uh_1 * 0.2) + ($uh_2 * 0.2) + ($nilai_akhir * 0.5);

    $query = "UPDATE nilai SET nilai_harian = ?, uh_1 = ?, uh_2 = ?, nilai_akhir_semester = ?, rata_rata = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("dddddi", $nilai_harian, $uh_1, $uh_2, $nilai_akhir, $rata_rata, $id);
    
    if ($stmt->execute()) {
        header("Location: dashboard_guru.php");
        exit;
    } else {
        echo "Gagal mengupdate nilai!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Nilai</title>
</head>
<body>
    <h2>Edit Nilai</h2>
    <form method="POST">
        <label>Nilai Harian:</label>
        <input type="number" name="nilai_harian" value="<?php echo $nilai['nilai_harian']; ?>" required><br>

        <label>UH 1:</label>
        <input type="number" name="uh_1" value="<?php echo $nilai['uh_1']; ?>" required><br>

        <label>UH 2:</label>
        <input type="number" name="uh_2" value="<?php echo $nilai['uh_2']; ?>" required><br>

        <label>Nilai Akhir Semester:</label>
        <input type="number" name="nilai_akhir_semester" value="<?php echo $nilai['nilai_akhir_semester']; ?>" required><br>

        <button type="submit">Update</button>
    </form>

    <br>
    <a href="dashboard_guru.php">Kembali ke Dashboard</a>
</body>
</html>
