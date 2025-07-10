<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit;
}

include 'config.php';

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM shoes WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$shoe = $result->fetch_assoc();

if (!$shoe) {
    header("Location: index.php");
    exit;
}

// Fetch all sizes and stock for this shoe
$sizes_stmt = $conn->prepare("SELECT id, size, stock FROM shoe_sizes WHERE shoe_id = ? ORDER BY size ASC");
$sizes_stmt->bind_param("i", $id);
$sizes_stmt->execute();
$sizes_result = $sizes_stmt->get_result();
$sizes = $sizes_result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Shoe</title>
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
        <h2>Edit Shoe</h2>
        <form action="update.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= $shoe['id'] ?>">
            
            <label>Brand:</label>
            <input type="text" name="brand" value="<?= htmlspecialchars($shoe['brand']) ?>" required>
            
            <label>Model:</label>
            <input type="text" name="model" value="<?= htmlspecialchars($shoe['model']) ?>" required>
            
            <label>Price:</label>
            <input type="number" name="price" value="<?= htmlspecialchars($shoe['price']) ?>" required>
            
            <label>Color:</label>
            <input type="text" name="color" value="<?= htmlspecialchars($shoe['color']) ?>" required>
            
            <label>Current Image:</label>
            <p style="margin: 5px 0; color: #666;"><?= htmlspecialchars($shoe['image_filename']) ?></p>
            
            <label>New Image (optional):</label>
            <input type="file" name="image" accept="image/*">
            
            <label>Sizes & Stock:</label>
            <div id="sizes-container">
              <?php if ($sizes): foreach ($sizes as $sz): ?>
                <div class="size-stock-row">
                  <input type="hidden" name="size_ids[]" value="<?= $sz['id'] ?>">
                  <input type="text" name="sizes[]" value="<?= htmlspecialchars($sz['size']) ?>" placeholder="Size (e.g. 41)" required>
                  <input type="number" name="stocks[]" value="<?= htmlspecialchars($sz['stock']) ?>" placeholder="Stock" min="0" required>
                  <button type="button" class="remove-size-btn" onclick="removeSizeRow(this)">&times;</button>
                </div>
              <?php endforeach; else: ?>
                <div class="size-stock-row">
                  <input type="hidden" name="size_ids[]" value="">
                  <input type="text" name="sizes[]" placeholder="Size (e.g. 41)" required>
                  <input type="number" name="stocks[]" placeholder="Stock" min="0" required>
                  <button type="button" class="remove-size-btn" onclick="removeSizeRow(this)" style="display:none;">&times;</button>
                </div>
              <?php endif; ?>
            </div>
            <button type="button" class="add-size-btn" onclick="addSizeRow()">+ Add Size</button>
            
            <input type="submit" name="update" value="Update Shoe">
        </form>
        <p class="form-footer-text"><a href="index.php">Back to list</a></p>
    </div>
    <script>
      function addSizeRow() {
        var container = document.getElementById('sizes-container');
        var row = document.createElement('div');
        row.className = 'size-stock-row';
        row.innerHTML = '<input type="hidden" name="size_ids[]" value="">' +
                        '<input type="text" name="sizes[]" placeholder="Size (e.g. 41)" required> ' +
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
