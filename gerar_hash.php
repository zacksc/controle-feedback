<?php
$senha = "admin";
$hash = password_hash($senha, PASSWORD_DEFAULT);
echo "Hash gerado: " . $hash;
?>