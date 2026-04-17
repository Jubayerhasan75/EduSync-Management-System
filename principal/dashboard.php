<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'principal') {
    header("Location: ../auth/login.php");
    exit();
}
require_once '../config/db.php';
include '../includes/header.php';
?>
<div class="wrapper">
    <?php include '../includes/sidebar.php'; ?>
    <div class="main-content">
        <h2 class="fw-bold text-dark mb-4">Principal Overview</h2>
        <div class="card p-4 border-0 shadow-sm rounded-4 bg-primary text-white">
            <h4 class="fw-bold">Welcome, <?php echo $_SESSION['name']; ?>!</h4>
            <p class="mb-0 opacity-75">You can monitor school activities from here.</p>
        </div>
    </div>
</div>
<?php include '../includes/footer.php'; ?>