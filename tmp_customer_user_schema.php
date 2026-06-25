<?php
$pdo = new PDO('mysql:host=127.0.0.1;dbname=toko_hp;charset=utf8mb4','root','');
foreach (['customers','users'] as $table) {
    echo "--- $table ---\n";
    foreach ($pdo->query("SHOW CREATE TABLE $table") as $row) {
        echo $row['Create Table'] . "\n";
    }
}
