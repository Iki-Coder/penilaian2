<?php
session_start();
if (isset($_SESSION['role'])) {
    if ($_SESSION['role'] == 'guru') {
        header("Location: dashboard_guru.php");
    } else {
        header("Location: dashboard_siswa.php");
    }
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
</head>
<body>
    <h2>Register</h2>
    <form action="../controllers/register.php" method="POST">
        <label>Username:</label>
        <input type="text" name="username" required><br>

        <label>Password:</label>
        <input type="password" name="password" required><br>

        <label>Pilih Role:</label>
        <select name="role" required>
            <option value="guru">Guru</option>
            <option value="siswa">Siswa</option>
        </select><br>

        <button type="submit" name="register">Register</button>
    </form>

    <p>Sudah punya akun? <a href="login.php">Login di sini</a></p>
</body>
</html>
