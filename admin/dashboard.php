<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit();
}
require_once '../config/db.php';
$total_users = $conn->query("SELECT COUNT(*) as total FROM users")->fetch_assoc();
$total_notes = $conn->query("SELECT COUNT(*) as total FROM notes")->fetch_assoc();
include '../includes/header.php';
?>
<div class="wrapper" style="display: flex; min-height: 100vh; background-color: #f8f9fc;">
    <?php include '../includes/sidebar.php'; ?>
    <div class="main-content" style="flex: 1; margin-left: 260px; padding: 2rem;">
        <h2 class="fw-bold text-dark mb-4">System Overview (Admin)</h2>
        
        <div class="row g-4 mb-4">
            <div class="col-md-6">
                <div class="card border-0 shadow-sm rounded-4 p-4" style="border-left: 5px solid #4e73df;">
                    <h6 class="text-uppercase text-muted small fw-bold">Total Users Registered</h6>
                    <h3 class="fw-bold mb-0"><?php echo $total_users['total']; ?></h3>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card border-0 shadow-sm rounded-4 p-4" style="border-left: 5px solid #1cc88a;">
                    <h6 class="text-uppercase text-muted small fw-bold">Files in System</h6>
                    <h3 class="fw-bold mb-0"><?php echo $total_notes['total']; ?></h3>
                </div>
            </div>
        </div>

        <div class="card p-4 border-0 shadow-sm rounded-4">
            <h5 class="fw-bold mb-4">Admin Management</h5>
            <div class="row g-3">
                <div class="col-md-4">
                    <a href="manage_users.php" class="btn btn-dark w-100 py-3 fw-bold">Manage Accounts</a>
                </div>
                <div class="col-md-4">
                    <a href="settings.php" class="btn btn-light border w-100 py-3 fw-bold">System Settings</a>
                </div>
                <div class="col-md-4">
                    <a href="logs.php" class="btn btn-light border w-100 py-3 fw-bold">Activity Logs</a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include '../includes/footer.php'; ?>