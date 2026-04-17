<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'student') {
    header("Location: ../auth/login.php");
    exit();
}
require_once '../config/db.php';
$teachers = $conn->query("SELECT name, email, phone, designation FROM users WHERE role = 'teacher' ORDER BY name ASC");
include '../includes/header.php';
?>
<div class="wrapper">
    <?php include '../includes/sidebar.php'; ?>
    <div class="main-content">
        <h2 class="fw-bold text-dark mb-4">Teacher Directory</h2>
        <div class="row g-4">
            <?php while($row = $teachers->fetch_assoc()): ?>
            <div class="col-md-4">
                <div class="card p-4 border-0 shadow-sm rounded-4 text-center">
                    <div class="bg-light rounded-circle mx-auto d-flex align-items-center justify-content-center mb-3" style="width: 70px; height: 70px;">
                        <i class="fa-solid fa-user-tie fs-2 text-primary"></i>
                    </div>
                    <h5 class="fw-bold mb-1"><?php echo $row['name']; ?></h5>
                    <p class="text-primary small fw-bold mb-3"><?php echo $row['designation'] ? $row['designation'] : 'Teacher'; ?></p>
                    <div class="text-start bg-light p-3 rounded-3 small">
                        <div class="mb-2"><i class="fa-solid fa-envelope text-muted me-2"></i> <?php echo $row['email']; ?></div>
                        <div><i class="fa-solid fa-phone text-muted me-2"></i> <?php echo $row['phone'] ? $row['phone'] : 'N/A'; ?></div>
                    </div>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
    </div>
</div>
<?php include '../includes/footer.php'; ?>