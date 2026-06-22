<?php
$conn = new mysqli('127.0.0.1', 'root', '', 'toko_hp');
if ($conn->connect_error) {
    echo 'CONNECT ERROR: ' . $conn->connect_error . PHP_EOL;
    exit(1);
}
$res = $conn->query('SELECT COUNT(*) AS cnt FROM brands');
if (!$res) {
    echo 'QUERY ERROR: ' . $conn->error . PHP_EOL;
    exit(1);
}
$row = $res->fetch_assoc();
echo 'BRANDS_COUNT=' . $row['cnt'] . PHP_EOL;
$res2 = $conn->query('SELECT brand_id, brand_name FROM brands LIMIT 10');
while ($row2 = $res2->fetch_assoc()) {
    echo $row2['brand_id'] . '\t' . $row2['brand_name'] . PHP_EOL;
}
