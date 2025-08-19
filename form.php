<?php
include 'config.php';

// Check if the form was submitted using the POST method
if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and retrieve form data
    $title = $conn->real_escape_string($_POST['title']);
    $price = $conn->real_escape_string($_POST['price']);
    $location = $conn->real_escape_string($_POST['location']);
    $ptype = $conn->real_escape_string($_POST['ptype']);
    $image = $conn->real_escape_string($_POST['image']);
    $desc = $conn->real_escape_string($_POST['desc']);

    // Server-side validation
    if (empty($title) || empty($price) || empty($location) || empty($ptype)) {
        die("All required fields must be filled!");
    }
    
    if (!is_numeric($price) || $price <= 0) {
        die("Price must be a positive number!");
    }
    
    if (!empty($image) && !filter_var($image, FILTER_VALIDATE_URL)) {
        die("Image URL must be a valid URL!");
    }

    // Insert into database
    $sql = "INSERT INTO properties (title, price, location, type, image_url, description) VALUES ('$title', '$price', '$location', '$ptype', '$image', '$desc')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('New property added successfully!');</script>";
    } else {
        echo "<script>alert('Error: " . $sql . "\\n" . $conn->error . "');</script>";
    }
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Add Property - Real Estate Listing App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="index.html">Real Estate</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navContent">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navContent">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="index.html">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="form.html">Form</a></li>
                    <li class="nav-item"><a class="nav-link" href="about.html">About</a></li>
                    <li class="nav-item"><a class="nav-link" href="contact.html">Contact</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h2 class="mb-4">Add Property</h2>
        <form action="form.php" method="POST" onsubmit="return validateForm()" class="card p-4 shadow-sm bg-white">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Title</label>
                    <input type="text" id="title" name="title" class="form-control" placeholder="Ex: 2-Storey House in Jaffna">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Price (LKR)</label>
                    <input type="number" id="price" name="price" class="form-control" placeholder="Ex: 12500000">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Location</label>
                    <input type="text" id="location" name="location" class="form-control" placeholder="Ex: Jaffna">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Type</label>
                    <select id="ptype" name="ptype" class="form-select">
                        <option value="">Choose...</option>
                        <option>House</option>
                        <option>Apartment</option>
                        <option>Land</option>
                        <option>Commercial</option>
                    </select>
                </div>
                <div class="col-12">
                    <label class="form-label">Image URL</label>
                    <input type="url" id="image" name="image" class="form-control" placeholder="https://...">
                    <div class="form-text">Day 1: Paste an image URL (optional). Use https://picsum.photos/seed/house/640/360</div>
                </div>
                <div class="col-12">
                    <label class="form-label">Description</label>
                    <textarea id="desc" name="desc" class="form-control" rows="4" placeholder="Short description..."></textarea>
                </div>
            </div>
            <div class="mt-4">
                <button type="submit" class="btn btn-success">Submit</button>
                <button type="reset" class="btn btn-secondary ms-2">Clear Form</button>
            </div>
        </form>
    </div>

    <footer class="text-center mt-5">
        by Sarva Kiritharan 
    </footer>

   <script>
    function validateForm() {
        const title = document.getElementById('title').value.trim();
        const price = document.getElementById('price').value.trim();
        const location = document.getElementById('location').value.trim();
        const type = document.getElementById('ptype').value.trim();
        const image = document.getElementById('image').value.trim();

        if (!title || !price || !location || !type) {
            alert('All required fields must be filled!');
            return false;
        }
        if (isNaN(price) || Number(price) <= 0) {
            alert('Price must be a positive number!');
            return false;
        }
        if (image && !/^https?:\/\//.test(image)) {
            alert('Image URL must be a valid URL!');
            return false;
        }
        alert('Form validated. Submitting to MySQL now!');
        // return false; // This line is now commented out
    }
</script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/main.js"></script>
</body>
</html>