<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit();
}
require_once '../config/db.php';
$logs = $conn->query("SELECT logs.*, users.name FROM logs LEFT JOIN users ON logs.user_id = users.id ORDER BY logs.created_at DESC LIMIT 50");
include '../includes/header.php';
?>
<div class="wrapper" style="display: flex; min-height: 100vh; background-color: #f8f9fc;">
    <?php include '../includes/sidebar.php'; ?>
    <div class="main-content" style="flex: 1; margin-left: 260px; padding: 2rem;">
        <h2 class="fw-bold text-dark mb-4">Activity Logs</h2>
        <div class="card p-0 border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="table-responsive bg-white p-3">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light"><tr><th>Time</th><th>User</th><th>Action</th></tr></thead>
                    <tbody>
                        <?php while($row = $logs->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo date('d M Y, h:i A', strtotime($row['created_at'])); ?></td>
                            <td class="fw-bold"><?php echo $row['name'] ? $row['name'] : 'System'; ?></td>
                            <td><?php echo $row['action']; ?></td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php include '../includes/footer.php'; ?>