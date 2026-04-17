<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'student') {
    header("Location: ../auth/login.php");
    exit();
}
require_once '../config/db.php';
$class_name = $_SESSION['class_name'];
$section = $_SESSION['section'];
$student_id = $_SESSION['user_id'];
include '../includes/header.php';
?>
<div class="wrapper" style="display: flex; min-height: 100vh; background-color: #f8f9fc;">
    <?php include '../includes/sidebar.php'; ?>
    <div class="main-content" style="flex: 1; margin-left: 260px; padding: 2rem;">
        <h2 class="fw-bold text-dark mb-4">Announcements</h2>

        <div class="row g-4">
            <div class="col-md-6">
                <div class="card p-4 border-0 shadow-sm rounded-4 border-top border-danger border-4 h-100">
                    <h5 class="fw-bold mb-4"><i class="fa-solid fa-bullhorn text-danger me-2"></i>From Admin</h5>
                    <?php 
                    $admin_msg = $conn->query("SELECT * FROM announcements WHERE sender_role = 'admin' AND (target_role = 'all' OR target_role = 'all_students' OR (target_role = 'specific_class' AND target_class = '$class_name') OR (target_role = 'specific_section' AND target_class = '$class_name' AND target_section = '$section') OR (target_role = 'specific_student' AND target_user_id = $student_id)) ORDER BY created_at DESC");
                    if($admin_msg->num_rows > 0):
                        while($m = $admin_msg->fetch_assoc()): ?>
                            <div class="bg-light p-3 rounded-3 mb-3 border-start border-danger border-3">
                                <p class="mb-2 fw-medium text-dark"><?php echo $m['message']; ?></p>
                                <small class="text-muted fw-bold"><?php echo date('d M Y - h:i A', strtotime($m['created_at'])); ?></small>
                            </div>
                        <?php endwhile; 
                    else: ?>
                        <div class="text-center text-muted p-4"><i class="fa-solid fa-inbox fs-3 mb-2"></i><br>No announcements from Admin.</div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card p-4 border-0 shadow-sm rounded-4 border-top border-success border-4 h-100">
                    <h5 class="fw-bold mb-4"><i class="fa-solid fa-chalkboard-user text-success me-2"></i>From Teachers</h5>
                    <?php 
                    $teacher_msg = $conn->query("SELECT announcements.*, users.name FROM announcements JOIN users ON announcements.sender_id = users.id WHERE sender_role = 'teacher' AND target_class = '$class_name' AND target_section = '$section' ORDER BY created_at DESC");
                    if($teacher_msg->num_rows > 0):
                        while($tm = $teacher_msg->fetch_assoc()): ?>
                            <div class="bg-light p-3 rounded-3 mb-3 border-start border-success border-3">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <strong class="text-success"><?php echo $tm['name']; ?></strong>
                                    <span class="badge bg-dark"><?php echo $tm['subject']; ?></span>
                                </div>
                                <p class="mb-2 fw-medium text-dark"><?php echo $tm['message']; ?></p>
                                <small class="text-muted fw-bold"><?php echo date('d M Y - h:i A', strtotime($tm['created_at'])); ?></small>
                            </div>
                        <?php endwhile;
                    else: ?>
                        <div class="text-center text-muted p-4"><i class="fa-solid fa-inbox fs-3 mb-2"></i><br>No announcements from Teachers.</div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include '../includes/footer.php'; ?>