<?php
$password = 'jobportal123';  // Your password
$hashed_password = password_hash($password, PASSWORD_DEFAULT);
echo $hashed_password;  // This will display the hashed password
?>