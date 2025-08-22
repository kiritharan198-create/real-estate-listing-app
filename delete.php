<?php
require 'config.php';
$id = (int)($_GET['id'] ?? 0);
if ($id > 0) {
  $stmt = $conn->prepare("DELETE FROM properties WHERE id=?");
  $stmt->bind_param('i', $id);
  if ($stmt->execute()) {
    header('Location: view.php?status=deleted'); exit;
  }
}
header('Location: view.php?status=error');
