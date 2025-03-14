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
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>
    <form action="../controllers/auth.php" method="POST">
        <label>Username:</label>
        <input type="text" name="username" required><br>

        <label>Password:</label>
        <input type="password" name="password" required><br>

        <button type="submit" name="login">Login</button><br>

    </form>
</body>
</html>
