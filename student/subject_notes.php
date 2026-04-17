<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'student' || !isset($_GET['subject'])) {
    header("Location: view_notes.php");
    exit();
}
require_once '../config/db.php';

$student_class = $_SESSION['class_name'];
$student_section = $_SESSION['section'];
$subject = $conn->real_escape_string($_GET['subject']);

$sql = "SELECT notes.*, users.name as teacher_name FROM notes JOIN users ON notes.teacher_id = users.id WHERE status = 'approved' AND notes.class_name = '$student_class' AND notes.section = '$student_section' AND notes.subject = '$subject' ORDER BY notes.created_at DESC";
$notes = $conn->query($sql);

include '../includes/header.php';
?>
<div class="wrapper">
    <?php include '../includes/sidebar.php'; ?>
    <div class="main-content">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold text-dark"><?php echo htmlspecialchars($subject); ?> Notes</h3>
            <a href="view_notes.php" class="btn btn-outline-secondary fw-bold">← Back</a>
        </div>
        
        <div class="row g-4">
            <?php if($notes && $notes->num_rows > 0): ?>
                <?php while($row = $notes->fetch_assoc()): ?>
                <div class="col-md-4">
                    <div class="card shadow-sm border-0 p-4 h-100 rounded-4 border-top border-success border-4">
                        <span class="badge bg-success mb-2" style="width: fit-content;"><?php echo htmlspecialchars($subject); ?></span>
                        <h5 class="fw-bold text-dark mt-2"><?php echo $row['title']; ?></h5>
                        <p class="text-muted small mb-1">Teacher: <b class="text-dark"><?php echo $row['teacher_name']; ?></b></p>
                        <p class="text-muted small mb-4">Date: <?php echo date('M d, Y', strtotime($row['created_at'])); ?></p>
                        <a href="../uploads/<?php echo $row['file_path']; ?>" class="btn btn-light border w-100 fw-bold" download>DOWNLOAD NOTE</a>
                    </div>
                </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="col-12"><div class="alert alert-info border-0 shadow-sm rounded-4">No approved materials available for this subject yet.</div></div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php include '../includes/footer.php'; ?>