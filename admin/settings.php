<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit();
}
include '../includes/header.php';
?>
<div class="wrapper">
    <?php include '../includes/sidebar.php'; ?>
    <div class="main-content">
        <h2 class="fw-bold text-dark mb-4">System Settings</h2>
        <div class="alert alert-info border-0 shadow-sm rounded-4">Settings module is currently active and ready for configuration.</div>
    </div>
</div>
<?php include '../includes/footer.php'; ?>