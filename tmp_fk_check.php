<?php
$pdo = new PDO('mysql:host=127.0.0.1;dbname=toko_hp;charset=utf8mb4','root','');
$stmt = $pdo->query("SELECT TABLE_NAME, COLUMN_NAME, CONSTRAINT_NAME, REFERENCED_TABLE_NAME, REFERENCED_COLUMN_NAME FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE WHERE REFERENCED_TABLE_NAME='orders' AND TABLE_SCHEMA='toko_hp'");
foreach($stmt->fetchAll(PDO::FETCH_ASSOC) as $row){ echo implode(' | ', $row) . PHP_EOL; }
