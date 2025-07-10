<?php
session_start();
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
$sizes_stmt = $conn->prepare("SELECT size, stock FROM shoe_sizes WHERE shoe_id = ? ORDER BY size ASC");
$sizes_stmt->bind_param("i", $id);
$sizes_stmt->execute();
$sizes_result = $sizes_stmt->get_result();
$sizes = $sizes_result->fetch_all(MYSQLI_ASSOC);
?>

<div class="modal-detail-content">
    <h2><?= htmlspecialchars($shoe['brand']) ?> <?= htmlspecialchars($shoe['model']) ?></h2>
    <img src="images/<?= htmlspecialchars($shoe['image_filename']) ?>" alt="<?= htmlspecialchars($shoe['brand']) ?> <?= htmlspecialchars($shoe['model']) ?>" style="width: 300px; height: auto; border-radius: 8px; margin-bottom: 20px;">
    <div class="detail-info">
        <p><strong>Price:</strong> Rp<?= number_format($shoe['price'], 0, ',', '.') ?></p>
        <p><strong>Color:</strong> <?= htmlspecialchars($shoe['color']) ?></p>
        <?php if ($sizes): ?>
        <div style="margin-top: 15px;">
            <strong>Available Sizes & Stock:</strong>
            <table style="width:100%; margin-top:8px; background: #f8f9fa; border-radius: 8px;">
                <tr><th style="text-align:left; padding: 4px 8px;">Size</th><th style="text-align:left; padding: 4px 8px;">Stock</th></tr>
                <?php foreach ($sizes as $sz): ?>
                <tr>
                    <td style="padding: 4px 8px;"><?= htmlspecialchars($sz['size']) ?></td>
                    <td style="padding: 4px 8px;"><?= htmlspecialchars($sz['stock']) ?></td>
                </tr>
                <?php endforeach; ?>
            </table>
        </div>
        <?php else: ?>
        <p style="color:#e74c3c;">No sizes available.</p>
        <?php endif; ?>
    </div>
    <div class="detail-actions">
        <a href="#" onclick="closeModal(); return false;" class="view-btn">&larr; Back to List</a>
        <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
            <a href="edit.php?id=<?= $shoe['id'] ?>" class="edit-btn">Edit</a>
            <a href="delete.php?id=<?= $shoe['id'] ?>" class="delete-btn" onclick="return confirm('Are you sure you want to delete this shoe?')">Delete</a>
        <?php endif; ?>
    </div>
</div>
