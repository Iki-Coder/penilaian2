<?php
$password = "password123";
$hashed_password = password_hash($password, PASSWORD_DEFAULT);
echo "Password yang sudah di-hash: " . $hashed_password;
?>
