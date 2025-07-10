<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit;
}

include 'config.php';

$error = '';

if (isset($_POST['submit'])) {
  $brand = $_POST['brand'];
  $model = $_POST['model'];
  $price = $_POST['price'];
  $color = $_POST['color'];

  $imageName = $_FILES['image']['name'];
  $imageTmp = $_FILES['image']['tmp_name'];
  $imagePath = "images/" . basename($imageName);

  move_uploaded_file($imageTmp, $imagePath);

  $stmt = $conn->prepare("INSERT INTO shoes (brand, model, price, color, image_filename) VALUES (?, ?, ?, ?, ?)");
  $stmt->bind_param("ssiss", $brand, $model, $price, $color, $imageName);
  $stmt->execute();
  $shoe_id = $conn->insert_id;

  // Insert sizes and stock
  if (isset($_POST['sizes']) && isset($_POST['stocks'])) {
    $sizes = $_POST['sizes'];
    $stocks = $_POST['stocks'];
    for ($i = 0; $i < count($sizes); $i++) {
      $size = trim($sizes[$i]);
      $stock = intval($stocks[$i]);
      if ($size !== '' && $stock >= 0) {
        $stmt2 = $conn->prepare("INSERT INTO shoe_sizes (shoe_id, size, stock) VALUES (?, ?, ?)");
        $stmt2->bind_param("isi", $shoe_id, $size, $stock);
        $stmt2->execute();
      }
    }
  }

  header("Location: index.php");
  exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Shoe</title>
    <link rel="stylesheet" href="style.css">
    <style>
      .size-stock-row { display: flex; gap: 10px; margin-bottom: 8px; }
      .size-stock-row input { width: 100px; }
      .remove-size-btn { background: #e74c3c; color: #fff; border: none; border-radius: 4px; padding: 0 8px; cursor: pointer; }
      .remove-size-btn:hover { background: #c0392b; }
      .add-size-btn { background: #229FCC; color: #fff; border: none; border-radius: 4px; padding: 4px 12px; cursor: pointer; margin-top: 8px; }
      .add-size-btn:hover { background: #1F7EA1; }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Add New Shoe</h2>
        <?php if ($error): ?>
            <p style="color:red"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>
        <form action="add.php" method="POST" enctype="multipart/form-data">
            <label>Brand:</label>
            <input type="text" name="brand" placeholder="Enter brand name" required>
            
            <label>Model:</label>
            <input type="text" name="model" placeholder="Enter model name" required>
            
            <label>Price:</label>
            <input type="number" name="price" placeholder="Enter price" required>
            
            <label>Color:</label>
            <input type="text" name="color" placeholder="Enter color" required>
            
            <label>Image:</label>
            <input type="file" name="image" accept="image/*" required>
            
            <label>Sizes & Stock:</label>
            <div id="sizes-container">
              <div class="size-stock-row">
                <input type="text" name="sizes[]" placeholder="Size (e.g. 41)" required>
                <input type="number" name="stocks[]" placeholder="Stock" min="0" required>
                <button type="button" class="remove-size-btn" onclick="removeSizeRow(this)" style="display:none;">&times;</button>
              </div>
            </div>
            <button type="button" class="add-size-btn" onclick="addSizeRow()">+ Add Size</button>
            
            <input type="submit" name="submit" value="Add Shoe">
        </form>
        <p class="form-footer-text"><a href="index.php">Back to list</a></p>
    </div>
    <script>
      function addSizeRow() {
        var container = document.getElementById('sizes-container');
        var row = document.createElement('div');
        row.className = 'size-stock-row';
        row.innerHTML = '<input type="text" name="sizes[]" placeholder="Size (e.g. 41)" required> ' +
                        '<input type="number" name="stocks[]" placeholder="Stock" min="0" required> ' +
                        '<button type="button" class="remove-size-btn" onclick="removeSizeRow(this)">&times;</button>';
        container.appendChild(row);
        updateRemoveButtons();
      }
      function removeSizeRow(btn) {
        var row = btn.parentNode;
        row.parentNode.removeChild(row);
        updateRemoveButtons();
      }
      function updateRemoveButtons() {
        var rows = document.querySelectorAll('.size-stock-row');
        rows.forEach(function(row, idx) {
          var btn = row.querySelector('.remove-size-btn');
          btn.style.display = (rows.length > 1) ? '' : 'none';
        });
      }
      window.onload = updateRemoveButtons;
    </script>
</body>
</html>
