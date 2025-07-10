<?php
session_start();
include 'config.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Check if user is admin
$is_admin = ($_SESSION['role'] === 'admin');

// Fetch inventory data
$result = $conn->query("SELECT * FROM shoes ORDER BY id DESC");

// Helper: get total stock for a shoe
function get_total_stock($conn, $shoe_id) {
    $stmt = $conn->prepare("SELECT SUM(stock) as total FROM shoe_sizes WHERE shoe_id = ?");
    $stmt->bind_param("i", $shoe_id);
    $stmt->execute();
    $res = $stmt->get_result();
    $row = $res->fetch_assoc();
    return $row['total'] ? $row['total'] : 0;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Shoe Inventory</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <div class="top-bar">
        <div class="header-center">
            <h2>Welcome, <?= htmlspecialchars($_SESSION['username']) ?></h2>
            <h3>Shoe Inventory</h3>
        </div>
        <a href="logout.php" class="logout-btn">Logout</a>
    </div>

    <?php if ($is_admin): ?>
        <a href="add.php" class="top-action-btn">Add New Shoe</a>
    <?php endif; ?>
    
    <div class="card-container">
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="card">
                <img src="images/<?= htmlspecialchars($row['image_filename']) ?>" alt="<?= htmlspecialchars($row['model']) ?>">
                <h3><?= htmlspecialchars($row['brand']) ?> <?= htmlspecialchars($row['model']) ?></h3>
                <p>Rp <?= number_format($row['price'], 0, ',', '.') ?></p>
                <p>Color: <?= htmlspecialchars($row['color']) ?></p>
                <p>Total Stock: <?= get_total_stock($conn, $row['id']) ?></p>
                <a href="#" class="view-btn" onclick="showDetails(<?= $row['id'] ?>); return false;">View Details</a>
            </div>
        <?php endwhile; ?>
    </div>
</div>

<!-- Modal Overlay for Details -->
<div id="detailsModal" class="modal-overlay" style="display:none;">
  <div class="modal-content">
    <span class="close-modal" onclick="closeModal()">&times;</span>
    <div id="modalDetailsContent">
      <!-- AJAX-loaded details will appear here -->
    </div>
  </div>
</div>
<script>
function showDetails(id) {
  var modal = document.getElementById('detailsModal');
  var content = document.getElementById('modalDetailsContent');
  content.innerHTML = '<p style="text-align:center;">Loading...</p>';
  modal.style.display = 'block';
  // AJAX fetch
  var xhr = new XMLHttpRequest();
  xhr.open('GET', 'detail.php?id=' + id, true);
  xhr.onload = function() {
    if (xhr.status === 200) {
      content.innerHTML = xhr.responseText;
    } else {
      content.innerHTML = '<p style="color:red;">Failed to load details.</p>';
    }
  };
  xhr.send();
}
function closeModal() {
  document.getElementById('detailsModal').style.display = 'none';
}
// Close modal when clicking outside content
window.onclick = function(event) {
  var modal = document.getElementById('detailsModal');
  if (event.target === modal) {
    closeModal();
  }
}
</script>
</body>
</html>
