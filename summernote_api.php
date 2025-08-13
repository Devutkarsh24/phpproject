<?php
header('Content-Type: application/json');
require 'db.php';

$title = trim($_POST['title'] ?? '');
$content = $_POST['content'] ?? '';

if ($title==='') { echo json_encode(['status'=>'error','message'=>'Title required']); exit; }

$stmt = $pdo->prepare("INSERT INTO posts (title, content) VALUES (?,?)");
$stmt->execute([$title, $content]);

echo json_encode(['status'=>'success']);
