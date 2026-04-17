<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'student') {
    header("Location: ../auth/login.php");
    exit();
}
require_once '../config/db.php';

$student_id = $_SESSION['user_id'];
$class_name = $_SESSION['class_name'];
$section = $_SESSION['section'];

$note_count = $conn->query("SELECT COUNT(*) as total FROM notes WHERE class_name = '$class_name' AND section = '$section' AND status = 'approved'")->fetch_assoc();
$teacher_count = $conn->query("SELECT COUNT(DISTINCT teacher_id) as total FROM notes WHERE class_name = '$class_name' AND section = '$section' AND status = 'approved'")->fetch_assoc();
$progress_data = $conn->query("SELECT AVG(score) as avg_score FROM student_results WHERE student_id = $student_id")->fetch_assoc();
$progress = $progress_data['avg_score'] ? round($progress_data['avg_score']) : 0;

$subjectsData = [
    "Class 6" => ["English", "Bangla", "Mathematics", "Science", "BGS", "Religion", "ICT"],
    "Class 7" => ["English", "Bangla", "Mathematics", "Science", "BGS", "Religion", "ICT"],
    "Class 8" => ["English", "Bangla", "Mathematics", "Science", "BGS", "Religion", "ICT"],
    "Class 9" => ["English", "Bangla", "Mathematics", "Physics", "Chemistry", "Biology", "BGS", "Religion", "ICT"],
    "Class 10" => ["English", "Bangla", "Mathematics", "Physics", "Chemistry", "Biology", "BGS", "Religion", "ICT"]
];

$my_subjects = isset($subjectsData[$class_name]) ? $subjectsData[$class_name] : [];

include '../includes/header.php';
?>
<style>
    .subject-card { background: #fff; border-radius: 15px; padding: 30px 20px; text-align: center; box-shadow: 0 4px 15px rgba(0,0,0,0.05); transition: all 0.3s ease; border: 2px solid #4e73df; text-decoration: none; display: block; }
    .subject-card h4 { font-weight: 700; margin: 0; color: #4e73df; transition: 0.3s; }
    .subject-card p { transition: 0.3s; color: #6c757d; }
    .subject-card:hover { background: #4e73df; box-shadow: 0 10px 25px rgba(78,115,223,0.3); }
    .subject-card:hover h4, .subject-card:hover p { color: #fff !important; }
</style>
<div class="wrapper" style="display: flex; min-height: 100vh; background-color: #f8f9fc;">
    <?php include '../includes/sidebar.php'; ?>
    <div class="main-content" style="flex: 1; margin-left: 260px; padding: 2rem;">
        
        <div class="card p-4 border-0 shadow-sm rounded-4 bg-primary text-white mb-4">
            <h3 class="fw-bold">Welcome back, <?php echo $_SESSION['name']; ?>! 👋</h3>
            <p class="mb-0 opacity-75">Select a subject below to view your detailed result progress or check new announcements.</p>
        </div>

        <div class="d-flex justify-content-between align-items-center mb-4 mt-2">
            <h4 class="fw-bold text-dark">Student Dashboard</h4>
            <span class="badge bg-primary px-3 py-2">Class: <?php echo $class_name; ?> | Sec: <?php echo $section; ?></span>
        </div>
        
        <div class="row g-4 mb-4">
            <div class="col-md-4">
                <div class="card p-4 border-0 shadow-sm rounded-4" style="border-left: 5px solid #4e73df;">
                    <h6 class="text-uppercase text-muted small fw-bold">Available Notes</h6>
                    <h3 class="fw-bold mb-0"><?php echo $note_count['total']; ?></h3>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card p-4 border-0 shadow-sm rounded-4" style="border-left: 5px solid #1cc88a;">
                    <h6 class="text-uppercase text-muted small fw-bold">Overall Progress</h6>
                    <h3 class="fw-bold mb-0"><?php echo $progress; ?>%</h3>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card p-4 border-0 shadow-sm rounded-4" style="border-left: 5px solid #f6c23e;">
                    <h6 class="text-uppercase text-muted small fw-bold">Active Teachers</h6>
                    <h3 class="fw-bold mb-0"><?php echo $teacher_count['total']; ?></h3>
                </div>
            </div>
        </div>

        <h5 class="fw-bold text-dark mb-3 mt-4">My Subjects (Result Progress)</h5>
        <div class="row g-4 mb-5">
            <?php foreach($my_subjects as $sub): ?>
            <div class="col-md-3">
                <a href="subject_result.php?subject=<?php echo urlencode($sub); ?>" class="subject-card">
                    <h4><?php echo $sub; ?></h4>
                    <p class="small mt-2 mb-0">View Progress</p>
                </a>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<?php include '../includes/footer.php'; ?>