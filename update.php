<?php
include 'config.php';

if (isset($_GET['id'])) {
    $id = (int) $_GET['id'];
    $sql = "SELECT * FROM properties WHERE id=$id";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
}

// Handle update form submission
if (isset($_POST['update'])) {
    $title = $_POST['title'];
    $price = $_POST['price'];
    $location = $_POST['location'];
    $type = $_POST['type'];
    $image_url = $_POST['image_url'];
    $description = $_POST['description'];

    if (empty($title) || empty($price) || empty($location) || empty($type)) {
        die("All required fields must be filled!");
    }

    $sql = "UPDATE properties 
            SET title='$title', price='$price', location='$location', 
                `type`='$type', image_url='$image_url', description='$description' 
            WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        header("Location: view.php");
        exit();
    } else {
        echo "Error updating record: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Edit Property</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
  <h2>Edit Property</h2>
  <form method="POST" action="">
    <div class="mb-3">
      <label>Title</label>
      <input type="text" name="title" value="<?php echo htmlspecialchars($row['title']); ?>" class="form-control" required>
    </div>
    <div class="mb-3">
      <label>Price (LKR)</label>
      <input type="number" name="price" value="<?php echo htmlspecialchars($row['price']); ?>" class="form-control" required>
    </div>
    <div class="mb-3">
      <label>Location</label>
      <input type="text" name="location" value="<?php echo htmlspecialchars($row['location']); ?>" class="form-control" required>
    </div>
    <div class="mb-3">
      <label>Type</label>
      <input type="text" name="type" value="<?php echo htmlspecialchars($row['type']); ?>" class="form-control" required>
    </div>
    <div class="mb-3">
      <label>Image URL</label>
      <input type="text" name="image_url" value="<?php echo htmlspecialchars($row['image_url']); ?>" class="form-control">
    </div>
    <div class="mb-3">
      <label>Description</label>
      <textarea name="description" class="form-control"><?php echo htmlspecialchars($row['description']); ?></textarea>
    </div>
    <button type="submit" name="update" class="btn btn-success">Update</button>
    <a href="view.php" class="btn btn-secondary">Cancel</a>
  </form>
</div>
</body>
</html>
