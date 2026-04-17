<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'teacher') {
    header("Location: ../auth/login.php");
    exit();
}
require_once '../config/db.php';
$teacher_id = $_SESSION['user_id'];
$my_notes = $conn->query("SELECT COUNT(*) as total FROM notes WHERE teacher_id = $teacher_id")->fetch_assoc();
include '../includes/header.php';
?>
<div class="wrapper" style="display: flex; min-height: 100vh; background-color: #f8f9fc;">
    <?php include '../includes/sidebar.php'; ?>
    <div class="main-content" style="flex: 1; margin-left: 260px; padding: 2rem;">
        <h2 class="fw-bold text-dark mb-4">Teacher Dashboard</h2>
        
        <div class="row g-4 mb-5">
            <div class="col-md-6">
                <div class="card p-4 border-0 shadow-sm rounded-4" style="border-left: 5px solid #4e73df;">
                    <h6 class="text-uppercase text-muted small fw-bold">My Uploaded Notes</h6>
                    <h3 class="fw-bold mb-0"><?php echo $my_notes['total']; ?></h3>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card p-4 border-0 shadow-sm rounded-4" style="border-left: 5px solid #36b9cc;">
                    <h6 class="text-uppercase text-muted small fw-bold">Quick Actions</h6>
                    <div class="mt-2">
                        <a href="upload_notes.php" class="btn btn-sm btn-primary me-2 px-3 fw-bold">Upload Note</a>
                        <a href="announcements.php" class="btn btn-sm btn-info text-white px-3 fw-bold">Post Announcement</a>
                    </div>
                </div>
            </div>
        </div>

        <h5 class="fw-bold text-dark mb-3 mt-5"><i class="fa-solid fa-bullhorn text-danger me-2"></i>Admin Announcements</h5>
        <div class="row">
            <div class="col-12">
                <div class="card p-4 border-0 shadow-sm rounded-4 border-top border-danger border-4">
                    <?php 
                    $admin_msg = $conn->query("SELECT * FROM announcements WHERE sender_role = 'admin' AND (target_role = 'all' OR target_role = 'all_teachers' OR (target_role = 'specific_teacher' AND target_user_id = $teacher_id)) ORDER BY created_at DESC LIMIT 5");
                    if($admin_msg->num_rows > 0):
                        while($m = $admin_msg->fetch_assoc()): ?>
                            <div class="bg-light p-3 rounded-3 mb-3">
                                <p class="mb-2 fw-medium text-dark"><?php echo $m['message']; ?></p>
                                <small class="text-muted fw-bold"><?php echo date('d M Y - h:i A', strtotime($m['created_at'])); ?></small>
                            </div>
                        <?php endwhile; 
                    else: ?>
                        <p class="text-muted mb-0">No recent announcements from Admin.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include '../includes/footer.php'; ?>