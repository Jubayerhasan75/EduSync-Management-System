<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit();
}
require_once '../config/db.php';

$msg = '';
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $target_role = $conn->real_escape_string($_POST['target_role']);
    $message = $conn->real_escape_string($_POST['message']);
    $sender_id = $_SESSION['user_id'];
    
    $target_class = isset($_POST['target_class']) ? $conn->real_escape_string($_POST['target_class']) : NULL;
    $target_section = isset($_POST['target_section']) ? $conn->real_escape_string($_POST['target_section']) : NULL;
    $target_user_id = isset($_POST['target_user_id']) ? $conn->real_escape_string($_POST['target_user_id']) : NULL;

    $conn->query("INSERT INTO announcements (sender_id, sender_role, target_role, target_class, target_section, target_user_id, message) VALUES ($sender_id, 'admin', '$target_role', '$target_class', '$target_section', '$target_user_id', '$message')");
    $msg = "<div class='alert alert-success border-0'>Announcement sent successfully!</div>";
}

$students = $conn->query("SELECT id, student_id, name, class_name, section FROM users WHERE role='student'");
$teachers = $conn->query("SELECT id, name, designation FROM users WHERE role='teacher'");

include '../includes/header.php';
?>
<div class="wrapper" style="display: flex; min-height: 100vh; background-color: #f8f9fc;">
    <?php include '../includes/sidebar.php'; ?>
    <div class="main-content" style="flex: 1; margin-left: 260px; padding: 2rem;">
        <h2 class="fw-bold text-dark mb-4">Post Announcement</h2>
        <?php echo $msg; ?>
        <div class="card p-4 border-0 shadow-sm rounded-4">
            <form method="POST">
                <div class="row g-3 mb-3">
                    <div class="col-md-3">
                        <label class="form-label small fw-bold">Target Audience</label>
                        <select name="target_role" id="targetRole" class="form-select" required>
                            <option value="all">Entire School</option>
                            <option value="all_students">All Students</option>
                            <option value="all_teachers">All Teachers</option>
                            <option value="specific_class">Specific Class</option>
                            <option value="specific_section">Specific Section</option>
                            <option value="specific_student">Specific Student</option>
                            <option value="specific_teacher">Specific Teacher</option>
                        </select>
                    </div>
                    
                    <div class="col-md-3" id="classBox" style="display:none;">
                        <label class="form-label small fw-bold">Class</label>
                        <select name="target_class" class="form-select">
                            <option value="Class 6">Class 6</option>
                            <option value="Class 7">Class 7</option>
                            <option value="Class 8">Class 8</option>
                            <option value="Class 9">Class 9</option>
                            <option value="Class 10">Class 10</option>
                        </select>
                    </div>

                    <div class="col-md-3" id="sectionBox" style="display:none;">
                        <label class="form-label small fw-bold">Section</label>
                        <select name="target_section" class="form-select">
                            <option value="A">A</option>
                            <option value="B">B</option>
                            <option value="C">C</option>
                        </select>
                    </div>

                    <div class="col-md-6" id="userBox" style="display:none;">
                        <label class="form-label small fw-bold">Select User</label>
                        <select name="target_user_id" id="userSelect" class="form-select">
                            <option value="">Choose...</option>
                        </select>
                    </div>
                </div>
                
                <div class="mb-3">
                    <label class="form-label small fw-bold">Message</label>
                    <textarea name="message" class="form-control" rows="4" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary fw-bold px-4">Send Announcement</button>
            </form>
        </div>
    </div>
</div>

<script>
    const targetRole = document.getElementById('targetRole');
    const classBox = document.getElementById('classBox');
    const sectionBox = document.getElementById('sectionBox');
    const userBox = document.getElementById('userBox');
    const userSelect = document.getElementById('userSelect');

    const students = [
        <?php while($s = $students->fetch_assoc()) echo "{id: ".$s['id'].", text: '".$s['name']." (ID: ".$s['student_id']." - ".$s['class_name']." Sec ".$s['section'].")'},"; ?>
    ];
    const teachers = [
        <?php while($t = $teachers->fetch_assoc()) echo "{id: ".$t['id'].", text: '".$t['name']." (".$t['designation'].")'},"; ?>
    ];

    targetRole.addEventListener('change', function() {
        classBox.style.display = 'none';
        sectionBox.style.display = 'none';
        userBox.style.display = 'none';
        userSelect.innerHTML = '<option value="">Choose...</option>';

        if(this.value === 'specific_class') {
            classBox.style.display = 'block';
        } else if(this.value === 'specific_section') {
            classBox.style.display = 'block';
            sectionBox.style.display = 'block';
        } else if(this.value === 'specific_student') {
            userBox.style.display = 'block';
            students.forEach(s => userSelect.innerHTML += `<option value="${s.id}">${s.text}</option>`);
        } else if(this.value === 'specific_teacher') {
            userBox.style.display = 'block';
            teachers.forEach(t => userSelect.innerHTML += `<option value="${t.id}">${t.text}</option>`);
        }
    });
</script>
<?php include '../includes/footer.php'; ?>