<?php
$pdo = new PDO('mysql:host=127.0.0.1;dbname=toko_hp;charset=utf8mb4','root','');
foreach ($pdo->query('SHOW COLUMNS FROM orders') as $row) {
    echo implode(' | ', $row) . PHP_EOL;
}
