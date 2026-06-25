<?php
$pdo = new PDO('mysql:host=127.0.0.1;dbname=toko_hp;charset=utf8mb4','root','');
$pdo->exec('DROP TABLE IF EXISTS orders');
echo "Dropped orders table\n";
