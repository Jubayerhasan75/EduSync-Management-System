<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}
require_once '../config/db.php';
$uid = $_SESSION['user_id'];

$msg = '';
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_pass'])) {
    $new_pass = md5($_POST['new_password']);
    $conn->query("UPDATE users SET password = '$new_pass' WHERE id = $uid");
    $msg = "<div class='alert alert-success border-0'>Password updated!</div>";
}

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['profile_pic'])) {
    $target_dir = "../uploads/profiles/";
    if (!is_dir($target_dir)) mkdir($target_dir, 0777, true);
    $pic_name = time() . "_" . basename($_FILES["profile_pic"]["name"]);
    if(move_uploaded_file($_FILES["profile_pic"]["tmp_name"], $target_dir . $pic_name)) {
        $conn->query("UPDATE users SET profile_pic = '$pic_name' WHERE id = $uid");
        $msg = "<div class='alert alert-success border-0'>Profile picture updated!</div>";
    }
}

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['remove_pic'])) {
    $conn->query("UPDATE users SET profile_pic = 'default.png' WHERE id = $uid");
    $msg = "<div class='alert alert-success border-0'>Profile picture removed!</div>";
}

$user = $conn->query("SELECT * FROM users WHERE id = $uid")->fetch_assoc();
include '../includes/header.php';
?>
<div class="wrapper" style="display: flex; min-height: 100vh; background-color: #f8f9fc;">
    <?php include '../includes/sidebar.php'; ?>
    <div class="main-content" style="flex: 1; margin-left: 260px; padding: 2rem;">
        <h2 class="fw-bold text-dark mb-4">Profile Settings</h2>
        <?php echo $msg; ?>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card p-4 border-0 shadow-sm rounded-4 text-center">
                    <img src="../uploads/profiles/<?php echo $user['profile_pic']; ?>" class="rounded-circle mx-auto mb-3" style="width:120px; height:120px; object-fit:cover; border:3px solid #4e73df;">
                    <form method="POST" enctype="multipart/form-data" class="mb-2">
                        <input type="file" name="profile_pic" class="form-control form-control-sm mb-2" required>
                        <button type="submit" class="btn btn-sm btn-primary w-100 fw-bold">Update Picture</button>
                    </form>
                    <form method="POST">
                        <input type="hidden" name="remove_pic" value="1">
                        <button type="submit" class="btn btn-sm btn-outline-danger w-100 fw-bold">Remove Picture</button>
                    </form>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card p-4 border-0 shadow-sm rounded-4">
                    <h5 class="fw-bold mb-4">Change Password</h5>
                    <form method="POST">
                        <div class="mb-3">
                            <label class="form-label small fw-bold">New Password</label>
                            <input type="password" name="new_password" class="form-control" required>
                        </div>
                        <button type="submit" name="update_pass" class="btn btn-primary fw-bold px-4">Update Password</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include '../includes/footer.php'; ?>