<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'student') {
    header("Location: ../auth/login.php");
    exit();
}
require_once '../config/db.php';

$class_name = $_SESSION['class_name'];

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
    .subject-card {
    background: #fff;
    border-radius: 15px;
    padding: 30px 20px;
    text-align: center;
    box-shadow: 0 4px 15px rgba(0,0,0,0.05);
    transition: all 0.3s ease;
    border: 2px solid #4e73df;
    text-decoration: none;
    display: block;
}
.subject-card h4 { font-weight: 700; margin: 0; color: #4e73df; transition: 0.3s; }
.subject-card p { transition: 0.3s; color: #6c757d; }

.subject-card:hover {
    background: #4e73df;
    box-shadow: 0 10px 25px rgba(78,115,223,0.3);
}
.subject-card:hover h4, .subject-card:hover p {
    color: #fff !important;
}
</style>
<div class="wrapper">
    <?php include '../includes/sidebar.php'; ?>
    <div class="main-content">
        <h2 class="fw-bold text-dark mb-4">Study Materials Collection</h2>
        
        <div class="row g-4">
            <?php foreach($my_subjects as $sub): ?>
            <div class="col-md-3">
                <a href="subject_notes.php?subject=<?php echo urlencode($sub); ?>" class="subject-card">
                    <h4><?php echo $sub; ?></h4>
                    <p class="text-muted small mt-2 mb-0">Browse Notes</p>
                </a>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<?php include '../includes/footer.php'; ?>