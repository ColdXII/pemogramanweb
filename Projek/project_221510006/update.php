<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit;
}

include 'config.php';

if (isset($_POST['update'])) {
  $id = $_POST['id'];
  $brand = $_POST['brand'];
  $model = $_POST['model'];
  $price = $_POST['price'];
  $color = $_POST['color'];

  if ($_FILES['image']['name']) {
    $imageName = $_FILES['image']['name'];
    $imageTmp = $_FILES['image']['tmp_name'];
    $imagePath = "images/" . basename($imageName);
    move_uploaded_file($imageTmp, $imagePath);

    $stmt = $conn->prepare("UPDATE shoes SET brand=?, model=?, price=?, color=?, image_filename=? WHERE id=?");
    $stmt->bind_param("sssssi", $brand, $model, $price, $color, $imageName, $id);
  } else {
    $stmt = $conn->prepare("UPDATE shoes SET brand=?, model=?, price=?, color=? WHERE id=?");
    $stmt->bind_param("ssssi", $brand, $model, $price, $color, $id);
  }

  $stmt->execute();

  // Handle sizes and stock
  if (isset($_POST['sizes']) && isset($_POST['stocks']) && isset($_POST['size_ids'])) {
    $sizes = $_POST['sizes'];
    $stocks = $_POST['stocks'];
    $size_ids = $_POST['size_ids'];

    // Track which IDs are still present
    $existing_ids = [];
    foreach ($size_ids as $i => $size_id) {
      $size = trim($sizes[$i]);
      $stock = intval($stocks[$i]);
      if ($size !== '' && $stock >= 0) {
        if ($size_id) {
          // Update existing
          $stmt2 = $conn->prepare("UPDATE shoe_sizes SET size=?, stock=? WHERE id=? AND shoe_id=?");
          $stmt2->bind_param("siii", $size, $stock, $size_id, $id);
          $stmt2->execute();
          $existing_ids[] = $size_id;
        } else {
          // Insert new
          $stmt2 = $conn->prepare("INSERT INTO shoe_sizes (shoe_id, size, stock) VALUES (?, ?, ?)");
          $stmt2->bind_param("isi", $id, $size, $stock);
          $stmt2->execute();
          $existing_ids[] = $conn->insert_id;
        }
      }
    }
    // Delete removed sizes
    $ids_str = implode(',', array_map('intval', $existing_ids));
    if ($ids_str) {
      $conn->query("DELETE FROM shoe_sizes WHERE shoe_id = $id AND id NOT IN ($ids_str)");
    } else {
      $conn->query("DELETE FROM shoe_sizes WHERE shoe_id = $id");
    }
  }

  header("Location: index.php");
  exit;
} else {
    header("Location: index.php");
    exit;
}
?>
