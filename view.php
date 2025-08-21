<?php
include 'config.php';

/* -------- Settings -------- */
$limit  = isset($_GET['limit']) ? max(1, min(50, (int)$_GET['limit'])) : 10; // 5–10 is fine
$page   = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$offset = ($page - 1) * $limit;

$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$where  = '';
if ($search !== '') {
  $s = $conn->real_escape_string($search);
  // Search by title, location, or type
  $where = "WHERE title LIKE '%$s%' OR location LIKE '%$s%' OR `type` LIKE '%$s%'";
}

/* -------- Count for pagination -------- */
$countSql  = "SELECT COUNT(*) AS total FROM properties $where";
$countRes  = $conn->query($countSql);
$totalRows = $countRes ? (int)$countRes->fetch_assoc()['total'] : 0;
$totalPages = max(1, (int)ceil($totalRows / $limit));

/* -------- Fetch rows -------- */
$sql = "SELECT id, title, price, location, `type`, image_url, description, created_at
        FROM properties
        $where
        ORDER BY id DESC
        LIMIT $limit OFFSET $offset";
$result = $conn->query($sql);

/* Safe output */
function h($v){ return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8'); }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>View Properties - Real Estate Listing App</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">

  <div class="d-flex justify-content-between align-items-center mb-3">
    <h2 class="m-0">All Properties</h2>
    <span class="badge text-bg-secondary">
      <?php
        $from = $totalRows ? ($offset + 1) : 0;
        $to   = min($offset + $limit, $totalRows);
       echo "Showing {$from}-{$to} of {$totalRows}";

      ?>
    </span>
  </div>

  <!-- Search -->
  <form method="GET" class="mb-3">
    <div class="row g-2">
      <div class="col-sm-8 col-md-9">
        <input type="text" name="search" class="form-control"
               placeholder="Search by Title, Location, or Type"
               value="<?php echo h($search); ?>">
      </div>
      <div class="col-sm-2 col-6">
        <select name="limit" class="form-select">
          <?php foreach([5,10,15,20] as $opt):
            $sel = $limit == $opt ? 'selected' : ''; ?>
            <option value="<?php echo $opt; ?>" <?php echo $sel; ?>>
              <?php echo $opt; ?> / page
            </option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="col-sm-2 col-6 d-grid">
        <button class="btn btn-primary">Search</button>
      </div>
    </div>
    <?php if ($search !== ''): ?>
      <a href="view.php" class="small d-inline-block mt-2">Reset filters</a>
    <?php endif; ?>
  </form>

  <!-- Table -->
  <div class="table-responsive">
    <table class="table table-bordered table-striped table-hover align-middle">
      <thead class="table-light">
        <tr>
          <th style="width:70px;">ID</th>
          <th>Title</th>
          <th style="width:140px;">Price (LKR)</th>
          <th style="width:160px;">Location</th>
          <th style="width:140px;">Type</th>
          <th style="width:130px;">Image</th>
          <th style="width:180px;">Created At</th>
        </tr>
      </thead>
      <tbody>
      <?php if ($result && $result->num_rows > 0): ?>
        <?php while($row = $result->fetch_assoc()): ?>
          <tr>
            <td><?php echo (int)$row['id']; ?></td>
            <td>
              <div class="fw-semibold"><?php echo h($row['title']); ?></div>
              <?php if (!empty($row['description'])): ?>
                <div class="text-muted small"><?php echo h($row['description']); ?></div>
              <?php endif; ?>
            </td>
            <td><?php echo number_format((int)$row['price']); ?></td>
            <td><?php echo h($row['location']); ?></td>
            <td><?php echo h($row['type']); ?></td>
            <td>
              <?php if (!empty($row['image_url'])): ?>
                <img src="<?php echo h($row['image_url']); ?>" alt="property" class="img-thumbnail" style="max-width:120px; max-height:80px;">
              <?php else: ?>
                <span class="text-muted">—</span>
              <?php endif; ?>
            </td>
            <td><?php echo h($row['created_at']); ?></td>
          </tr>
        <?php endwhile; ?>
      <?php else: ?>
        <tr><td colspan="7" class="text-center text-muted">No entries found</td></tr>
      <?php endif; ?>
      </tbody>
    </table>
  </div>

  <!-- Pagination -->
  <?php if ($totalPages > 1): ?>
    <nav aria-label="Page navigation">
      <ul class="pagination">
        <?php
          $qs = function($p) use ($search, $limit) {
            return '?search=' . urlencode($search) . "&limit=$limit&page=$p";
          };
        ?>
        <li class="page-item <?php echo $page <= 1 ? 'disabled' : ''; ?>">
          <a class="page-link" href="<?php echo $qs($page-1); ?>">Previous</a>
        </li>

        <?php
          $start = max(1, $page - 2);
          $end   = min($totalPages, $page + 2);
          for ($p = $start; $p <= $end; $p++):
        ?>
          <li class="page-item <?php echo $p == $page ? 'active' : ''; ?>">
            <a class="page-link" href="<?php echo $qs($p); ?>"><?php echo $p; ?></a>
          </li>
        <?php endfor; ?>

        <li class="page-item <?php echo $page >= $totalPages ? 'disabled' : ''; ?>">
          <a class="page-link" href="<?php echo $qs($page+1); ?>">Next</a>
        </li>
      </ul>
    </nav>
  <?php endif; ?>

</div>
</body>
</html>
