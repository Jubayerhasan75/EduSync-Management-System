<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit();
}
require_once '../config/db.php';

if (isset($_GET['action']) && isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $status = $_GET['action'] == 'approve' ? 'approved' : 'rejected';
    $conn->query("UPDATE notes SET status = '$status' WHERE id = $id");
    header("Location: approve_notes.php");
    exit();
}

$notes = $conn->query("SELECT notes.*, users.name as teacher_name FROM notes JOIN users ON notes.teacher_id = users.id WHERE status = 'pending' ORDER BY created_at DESC");

include '../includes/header.php';
?>
<div class="wrapper">
    <?php include '../includes/sidebar.php'; ?>
    <div class="main-content">
        <h3 class="fw-bold mb-4">Pending Notes Approval</h3>
        
        <div class="card p-0 shadow-sm border-0 rounded-4 overflow-hidden">
            <div class="table-responsive bg-white p-3">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light"><tr><th>Teacher</th><th>Title</th><th>Subject</th><th>Class & Sec</th><th>File</th><th>Action</th></tr></thead>
                    <tbody>
                        <?php if($notes->num_rows > 0): ?>
                            <?php while($row = $notes->fetch_assoc()): ?>
                            <tr>
                                <td class="fw-bold"><?php echo $row['teacher_name']; ?></td>
                                <td><?php echo $row['title']; ?></td>
                                <td><?php echo $row['subject']; ?></td>
                                <td><?php echo $row['class_name'] . ' - ' . $row['section']; ?></td>
                                <td><a href="../uploads/<?php echo $row['file_path']; ?>" class="btn btn-sm btn-secondary" target="_blank">Review</a></td>
                                <td>
                                    <a href="approve_notes.php?action=approve&id=<?php echo $row['id']; ?>" class="btn btn-sm btn-success fw-bold">Approve</a>
                                    <a href="approve_notes.php?action=reject&id=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger fw-bold">Reject</a>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr><td colspan="6" class="text-center py-4 text-muted">No pending notes for approval.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php include '../includes/footer.php'; ?>