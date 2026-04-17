<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'teacher') {
    header("Location: ../auth/login.php");
    exit();
}
require_once '../config/db.php';

$msg = '';
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $message = $conn->real_escape_string($_POST['message']);
    $sender_id = $_SESSION['user_id'];
    $target_class = $conn->real_escape_string($_POST['target_class']);
    $target_section = $conn->real_escape_string($_POST['target_section']);
    $subject = $conn->real_escape_string($_POST['subject']);

    $sql = "INSERT INTO announcements (sender_id, sender_role, target_role, target_class, target_section, subject, message) VALUES ($sender_id, 'teacher', 'specific_section', '$target_class', '$target_section', '$subject', '$message')";
    if($conn->query($sql)) {
        $msg = "<div class='alert alert-success border-0'>Announcement posted successfully!</div>";
    }
}
include '../includes/header.php';
?>
<div class="wrapper" style="display: flex; min-height: 100vh; background-color: #f8f9fc;">
    <?php include '../includes/sidebar.php'; ?>
    <div class="main-content" style="flex: 1; margin-left: 260px; padding: 2rem;">
        <h2 class="fw-bold text-dark mb-4">Post Class Announcement</h2>
        <?php echo $msg; ?>
        <div class="card p-4 border-0 shadow-sm rounded-4">
            <form method="POST">
                <div class="row g-3 mb-3">
                    <div class="col-md-4">
                        <label class="form-label small fw-bold">Target Class</label>
                        <select name="target_class" id="classSelect" class="form-select" required>
                            <option value="">Choose Class</option>
                            <option value="Class 6">Class 6</option>
                            <option value="Class 7">Class 7</option>
                            <option value="Class 8">Class 8</option>
                            <option value="Class 9">Class 9</option>
                            <option value="Class 10">Class 10</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label small fw-bold">Target Section</label>
                        <select name="target_section" class="form-select" required>
                            <option value="A">A</option>
                            <option value="B">B</option>
                            <option value="C">C</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label small fw-bold">Subject</label>
                        <select name="subject" id="subjectSelect" class="form-select" required>
                            <option value="">Choose Subject</option>
                        </select>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-bold">Message</label>
                    <textarea name="message" class="form-control" rows="4" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary fw-bold px-4">Post Announcement</button>
            </form>
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
    subSelect.innerHTML = '<option value="">Choose Subject</option>';
    
    if(subjectsData[classVal]) {
        subjectsData[classVal].forEach(sub => {
            subSelect.innerHTML += `<option value="${sub}">${sub}</option>`;
        });
    }
});
</script>
<?php include '../includes/footer.php'; ?>