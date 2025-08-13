<?php
header('Content-Type: application/json');
require 'db.php';

$action = $_REQUEST['action'] ?? 'list';

try {
  if ($action==='list') {
    echo json_encode($pdo->query("SELECT * FROM items ORDER BY id DESC")->fetchAll());
  }
  elseif ($action==='get') {
    $id = (int)($_GET['id'] ?? 0);
    $st = $pdo->prepare("SELECT * FROM items WHERE id=?"); $st->execute([$id]);
    echo json_encode($st->fetch() ?: []);
  }
  elseif ($action==='create') {
    $st = $pdo->prepare("INSERT INTO items(name,price,category) VALUES (?,?,?)");
    $st->execute([$_POST['name']??'', $_POST['price']??0, $_POST['category']??null]);
    echo json_encode(['status'=>'success']);
  }
  elseif ($action==='update') {
    $st = $pdo->prepare("UPDATE items SET name=?, price=?, category=? WHERE id=?");
    $st->execute([$_POST['name']??'', $_POST['price']??0, $_POST['category']??null, (int)$_POST['id']]);
    echo json_encode(['status'=>'success']);
  }
  elseif ($action==='delete') {
    $st = $pdo->prepare("DELETE FROM items WHERE id=?"); $st->execute([(int)$_POST['id']]);
    echo json_encode(['status'=>'success']);
  }
} catch (Throwable $e) {
  echo json_encode(['status'=>'error','message'=>$e->getMessage()]);
}
