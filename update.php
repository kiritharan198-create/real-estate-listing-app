<?php
require 'config.php';

$id = (int)($_GET['id'] ?? 0);
if ($id <= 0) { header('Location: view.php'); exit; }

// Load existing
$stmt = $conn->prepare("SELECT title,price,location,type,phone,image_url,description FROM properties WHERE id=?");
$stmt->bind_param('i', $id);
$stmt->execute();
$stmt->bind_result($title,$price,$location,$type,$phone,$image_url,$description);
$stmt->fetch();
$stmt->close();


$err = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $title         = trim($_POST['title'] ?? '');
  $price         = (int)($_POST['price'] ?? 0);
  $location      = trim($_POST['location'] ?? '');
  $type          = trim($_POST['type'] ?? '');
  $image_url     = trim($_POST['image_url'] ?? '');
  $description   = trim($_POST['description'] ?? '');
  $phone         = trim($_POST['phone'] ?? '');

  $sql = "UPDATE properties SET title=?, price=?, location=?, type=?, phone=?, image_url=?, description=? WHERE id=?";
  $up = $conn->prepare($sql);
  $up->bind_param('sisssssi', $title, $price, $location, $type, $phone, $image_url, $description, $id);

  if ($up->execute()) {
    header('Location: view.php?status=updated'); exit;
  } else { $err = $conn->error; }
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8"><title>Edit Property</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-4">
  <h3>Edit #<?= $id ?></h3>
  <?php if(!empty($err)): ?><div class="alert alert-danger"><?= htmlspecialchars($err) ?></div><?php endif; ?>

  <form method="POST" class="row g-3">
  <div class="col-md-6">
    <label class="form-label">Title</label>
    <input id="title" name="title" class="form-control" required value="<?= htmlspecialchars($title) ?>">
  </div>
  <div class="col-md-3">
    <label class="form-label">Price (LKR)</label>
    <input id="price" name="price" type="number" min="0" class="form-control" required value="<?= (int)$price ?>">
  </div>
  <div class="col-md-3">
    <label class="form-label">Location</label>
    <input id="location" name="location" class="form-control" required
           oninput="this.value=this.value.toUpperCase()" value="<?= htmlspecialchars($location) ?>">
  </div>
  <div class="col-md-4">
    <label class="form-label">Type</label>
    <input id="type" name="type" class="form-control" required
           oninput="this.value=this.value.toUpperCase()" value="<?= htmlspecialchars($type) ?>">
  </div>
  <div class="col-md-8">
    <label class="form-label">Image URL</label>
    <input id="image_url" name="image_url" class="form-control" value="<?= htmlspecialchars($image_url) ?>">
  </div>
  <div class="col-12">
    <label class="form-label">Description</label>
    <textarea id="description" name="description" class="form-control" rows="3"><?= htmlspecialchars($description) ?></textarea>
  </div>
  <div class="col-12">
    <label class="form-label">Phone</label>
    <input type="text" id="phone" name="phone" class="form-control" value="<?= htmlspecialchars($phone) ?>" oninput="this.value=this.value.replace(/[^0-9]/g,'')">
  </div>
  <div class="col-12">
    <button class="btn btn-primary">Update</button>
    <a href="view.php" class="btn btn-secondary">Back</a>
  </div>
</form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/main.js"></script>
</body>
</html>