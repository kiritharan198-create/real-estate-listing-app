<?php
require 'config.php';

$err = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title       = trim($_POST['title'] ?? '');
    $price       = (int)($_POST['price'] ?? 0);
    $location    = trim($_POST['location'] ?? '');
    // accept both old 'ptype' and new 'type'
    $type        = trim($_POST['type'] ?? $_POST['ptype'] ?? '');
    $phone       = trim($_POST['phone'] ?? '');
    // accept both 'image_url' and old 'image'
    $image_url   = trim($_POST['image_url'] ?? $_POST['image'] ?? '');
    $description = trim($_POST['description'] ?? $_POST['desc'] ?? '');

    // server-side validation
    if ($title === '' || $price <= 0 || $location === '' || $type === '') {
        $err = "Title, price (>0), location and type are required.";
    } elseif (!empty($image_url) && !filter_var($image_url, FILTER_VALIDATE_URL)) {
        $err = "Image URL must be a valid URL.";
    } elseif (!empty($phone) && !preg_match('/^[0-9]{7,20}$/', $phone)) {
        $err = "Phone must contain only digits (7 to 20 characters).";
    } else {
        $sql = "INSERT INTO properties (title, price, location, type, phone, image_url, description)
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sisssss", $title, $price, $location, $type, $phone, $image_url, $description);

        if ($stmt->execute()) {
            header("Location: view.php?status=created");
            exit;
        } else {
            $err = "DB error: " . $conn->error;
        }
    }
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Add Property</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body class="bg-light">
<div class="container mt-5">
  <h2>Add Property</h2>
  <?php if (!empty($err)): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($err) ?></div>
  <?php endif; ?>

  <form method="POST" class="card p-4 shadow-sm bg-white">
    <div class="row g-3">
      <div class="col-md-6">
        <label class="form-label">Title</label>
        <input type="text" id="title" name="title" class="form-control" required>
      </div>
      <div class="col-md-3">
        <label class="form-label">Price (LKR)</label>
        <input type="number" id="price" name="price" class="form-control" min="0" required>
      </div>
      <div class="col-md-3">
        <label class="form-label">Location</label>
        <input type="text" id="location" name="location" class="form-control" oninput="this.value=this.value.toUpperCase()" required>
      </div>

      <div class="col-md-4">
        <label class="form-label">Type</label>
        <select id="type" name="type" class="form-select" required>
          <option value="">Choose...</option>
          <option>HOUSE</option>
          <option>APARTMENT</option>
          <option>LAND</option>
          <option>COMMERCIAL</option>
        </select>
      </div>

      <div class="col-md-4">
        <label class="form-label">Phone</label>
        <input type="text" id="phone" name="phone" class="form-control" placeholder="0771234567"
               oninput="this.value=this.value.replace(/[^0-9]/g,'')">
        <div class="form-text">Digits only, 7–20 chars (optional)</div>
      </div>

      <div class="col-md-4">
        <label class="form-label">Image URL</label>
        <input type="url" name="image_url" class="form-control" placeholder="https://...">
      </div>

      <div class="col-12">
        <label class="form-label">Description</label>
        <textarea name="description" class="form-control" rows="3"></textarea>
      </div>
    </div>

    <div class="mt-4">
      <button class="btn btn-success">Save</button>
      <a href="view.php" class="btn btn-secondary ms-2">Cancel</a>
    </div>
  </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/main.js"></script>
</body>
</html>
