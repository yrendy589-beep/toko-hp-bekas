<?php
$conn = new mysqli('127.0.0.1', 'root', '', 'toko_hp');
if ($conn->connect_error) {
    echo 'CONNECT ERROR: ' . $conn->connect_error . PHP_EOL;
    exit(1);
}
$res = $conn->query('SHOW COLUMNS FROM products');
if (! $res) {
    echo 'QUERY ERROR: ' . $conn->error . PHP_EOL;
    exit(1);
}
while ($row = $res->fetch_assoc()) {
    echo $row['Field'] . '\t' . $row['Type'] . PHP_EOL;
}
