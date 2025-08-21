<?php
include 'config.php';

if (isset($_GET['id'])) {
    $id = (int) $_GET['id'];  // cast to int for safety

    $sql = "DELETE FROM properties WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        header("Location: view.php"); // redirect back after delete
        exit();
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}
?>
