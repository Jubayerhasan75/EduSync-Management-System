<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit();
}
require_once '../config/db.php';

$msg = '';
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $new_pass = md5($_POST['new_password']);
    $uid = $_SESSION['user_id'];
    $conn->query("UPDATE users SET password = '$new_pass' WHERE id = $uid");
    $msg = "<div class='alert alert-success border-0'>Password updated successfully!</div>";
}
include '../includes/header.php';
?>
<div class="wrapper">
    <?php include '../includes/sidebar.php'; ?>
    <div class="main-content">
        <h2 class="fw-bold text-dark mb-4">Profile Settings</h2>
        <div class="row">
            <div class="col-md-6">
                <div class="card p-4 border-0 shadow-sm rounded-4">
                    <h5 class="fw-bold mb-4">Change Password</h5>
                    <?php echo $msg; ?>
                    <form method="POST">
                        <div class="mb-3">
                            <label class="form-label small fw-bold">New Password</label>
                            <input type="password" name="new_password" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary fw-bold px-4">Update Password</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include '../includes/footer.php'; ?>