<?php
require 'db.php';

$q = trim($_GET['q'] ?? '');
$cat = trim($_GET['cat'] ?? '');
$price = $_GET['price'] ?? '';

$where = []; $params = [];
if ($q !== '') { $where[] = "name LIKE ?"; $params[] = "%$q%"; }
if ($cat !== '') { $where[] = "category = ?"; $params[] = $cat; }
if ($price !== '') {
  [$min,$max] = array_map('floatval', explode('-', $price));
  $where[] = "price BETWEEN ? AND ?"; $params[] = $min; $params[] = $max;
}
$sql = "SELECT * FROM items";
if ($where) $sql .= " WHERE ".implode(' AND ', $where);
$sql .= " ORDER BY id DESC";

$st = $pdo->prepare($sql); $st->execute($params);
foreach ($st as $r) {
  echo "<tr><td>{$r['id']}</td><td>".htmlspecialchars($r['name'])."</td><td>{$r['price']}</td><td>{$r['category']}</td></tr>";
}
if ($st->rowCount()===0) echo "<tr><td colspan='4'>No results</td></tr>";
