<?php require 'config.php'; ?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Properties</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/css/styles.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="view.php">RealEstate</a>
    <a class="btn btn-success" href="create.php">+ Add Property</a>
  </div>
</nav>

<div class="container-fluid py-3">

  <?php if (!empty($_GET['status'])):
    $map = ['created'=>'Entry created successfully!',
            'updated'=>'Entry updated successfully!',
            'deleted'=>'Entry deleted successfully!',
            'error'=>'Something went wrong.'];
    $msg = $map[$_GET['status']] ?? '';
    if ($msg): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      <?= htmlspecialchars($msg) ?>
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  <?php endif; endif; ?>

  <div class="row mb-3">
    <div class="col-md-6">
      <input id="tableFilter" class="form-control" placeholder="Search title/location/type...">
    </div>
  </div>

  <div class="table-responsive">
    <table class="table table-striped align-middle" id="entriesTable">
      <thead>
        <tr>
          <th>#</th>
          <th role="button" data-sort="1">Title ▲▼</th>
          <th role="button" data-sort="2">Location ▲▼</th>
          <th role="button" data-sort="3">Type ▲▼</th>
          <th role="button" data-sort="4">Phone ▲▼</th>
          <th role="button" data-sort="5">Price ▲▼</th>
          <th>Image</th>
          <th>Created</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
      <?php
        $res = $conn->query("SELECT id,title,location,type,phone,price,image_url,created_at FROM properties ORDER BY id DESC");
        while($row = $res->fetch_assoc()):
      ?>
        <tr>
          <td><?= (int)$row['id'] ?></td>
          <td><?= htmlspecialchars($row['title']) ?></td>
          <td><?= htmlspecialchars($row['location']) ?></td>
          <td><?= htmlspecialchars($row['type']) ?></td>
          <td><?= htmlspecialchars($row['phone']) ?></td>
          <td><?= number_format((int)$row['price']) ?></td>
          <td>
            <?php if(!empty($row['image_url'])): ?>
              <img src="<?= htmlspecialchars($row['image_url']) ?>" alt="img" style="height:40px">
            <?php endif; ?>
          </td>
          <td><?= htmlspecialchars($row['created_at']) ?></td>
          <td class="d-flex gap-2">
            <a class="btn btn-primary btn-sm" href="update.php?id=<?= (int)$row['id'] ?>">Edit</a>
            <button type="button" class="btn btn-danger btn-sm"
                    data-bs-toggle="modal" data-bs-target="#deleteModal"
                    data-id="<?= (int)$row['id'] ?>">Delete</button>
          </td>
        </tr>
      <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</div>

<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog"><div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title">Confirm Delete</h5>
      <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
    </div>
    <div class="modal-body">Are you sure you want to delete this entry?</div>
    <div class="modal-footer">
      <a id="confirmDelete" href="#" class="btn btn-danger">Yes, Delete</a>
      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
    </div>
  </div></div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/main.js"></script>
</body>
</html>