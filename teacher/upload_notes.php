<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'teacher') {
    header("Location: ../auth/login.php");
    exit();
}
require_once '../config/db.php';

$msg = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $conn->real_escape_string($_POST['title']);
    $class_name = $conn->real_escape_string($_POST['class_name']);
    $section = $conn->real_escape_string($_POST['section']);
    $subject = $conn->real_escape_string($_POST['subject']);
    $teacher_id = $_SESSION['user_id'];
    
    $target_dir = "../uploads/";
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    $file_name = time() . "_" . basename($_FILES["fileToUpload"]["name"]);
    $target_file = $target_dir . $file_name;

    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        $conn->query("INSERT INTO notes (teacher_id, title, class_name, section, subject, file_path, status) VALUES ('$teacher_id', '$title', '$class_name', '$section', '$subject', '$file_name', 'pending')");
        $msg = "<div class='alert alert-success small'>Note uploaded and sent to Admin for approval!</div>";
    } else {
        $msg = "<div class='alert alert-danger small'>Failed to upload file.</div>";
    }
}

$notes = $conn->query("SELECT * FROM notes WHERE teacher_id = " . $_SESSION['user_id'] . " ORDER BY created_at DESC");

include '../includes/header.php';
?>
<div class="wrapper">
    <?php include '../includes/sidebar.php'; ?>
    <div class="main-content">
        <h3 class="fw-bold mb-4">Upload Study Notes</h3>
        <?php echo $msg; ?>
        
        <div class="card p-4 mb-4 shadow-sm border-0 rounded-4">
            <form method="POST" enctype="multipart/form-data">
                <div class="row g-3">
                    <div class="col-md-3">
                        <input type="text" name="title" class="form-control" placeholder="Note Title" required>
                    </div>
                    <div class="col-md-2">
                        <select name="class_name" id="classSelect" class="form-select" required>
                            <option value="">Select Class</option>
                            <option value="Class 6">Class 6</option>
                            <option value="Class 7">Class 7</option>
                            <option value="Class 8">Class 8</option>
                            <option value="Class 9">Class 9</option>
                            <option value="Class 10">Class 10</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select name="section" class="form-select" required>
                            <option value="">Section</option>
                            <option value="A">A</option>
                            <option value="B">B</option>
                            <option value="C">C</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select name="subject" id="subjectSelect" class="form-select" required>
                            <option value="">Subject</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <input type="file" name="fileToUpload" class="form-control" required>
                    </div>
                    <div class="col-md-12 text-end mt-3">
                        <button type="submit" class="btn btn-primary fw-bold px-5">UPLOAD</button>
                    </div>
                </div>
            </form>
        </div>

        <div class="card p-0 shadow-sm border-0 rounded-4 overflow-hidden">
            <div class="table-responsive bg-white p-3">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light"><tr><th>Title</th><th>Subject</th><th>Class & Section</th><th>Status</th><th>Action</th></tr></thead>
                    <tbody>
                        <?php while($row = $notes->fetch_assoc()): ?>
                        <tr>
                            <td class="fw-bold"><?php echo $row['title']; ?></td>
                            <td><?php echo $row['subject']; ?></td>
                            <td><?php echo $row['class_name'] . ' - ' . $row['section']; ?></td>
                            <td>
                                <?php if($row['status'] == 'approved'): ?>
                                    <span class="badge bg-success">Approved</span>
                                <?php elseif($row['status'] == 'rejected'): ?>
                                    <span class="badge bg-danger">Rejected</span>
                                <?php else: ?>
                                    <span class="badge bg-warning text-dark">Pending</span>
                                <?php endif; ?>
                            </td>
                            <td><a href="../uploads/<?php echo $row['file_path']; ?>" class="btn btn-sm btn-info text-white" target="_blank">View</a></td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
const subjectsData = {
    "Class 6": ["English", "Bangla", "Mathematics", "Science", "BGS", "Religion", "ICT"],
    "Class 7": ["English", "Bangla", "Mathematics", "Science", "BGS", "Religion", "ICT"],
    "Class 8": ["English", "Bangla", "Mathematics", "Science", "BGS", "Religion", "ICT"],
    "Class 9": ["English", "Bangla", "Mathematics", "Physics", "Chemistry", "Biology", "BGS", "Religion", "ICT"],
    "Class 10": ["English", "Bangla", "Mathematics", "Physics", "Chemistry", "Biology", "BGS", "Religion", "ICT"]
};

document.getElementById('classSelect').addEventListener('change', function() {
    const classVal = this.value;
    const subSelect = document.getElementById('subjectSelect');
    subSelect.innerHTML = '<option value="">Subject</option>';
    
    if(subjectsData[classVal]) {
        subjectsData[classVal].forEach(sub => {
            subSelect.innerHTML += `<option value="${sub}">${sub}</option>`;
        });
    }
});
</script>
<?php include '../includes/footer.php'; ?>