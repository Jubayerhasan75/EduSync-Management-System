<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'student' || !isset($_GET['subject'])) {
    header("Location: dashboard.php");
    exit();
}
require_once '../config/db.php';

$student_id = $_SESSION['user_id'];
$subject = $conn->real_escape_string($_GET['subject']);

$check_res = $conn->query("SELECT * FROM student_results WHERE student_id = $student_id AND subject = '$subject'");
if($check_res->num_rows == 0) {
    $exams = ['Class Test 1', 'Mid Term', 'Class Test 2', 'Final Exam'];
    foreach($exams as $exam) {
        $score = rand(60, 98);
        $conn->query("INSERT INTO student_results (student_id, subject, exam_name, score) VALUES ($student_id, '$subject', '$exam', $score)");
    }
}

$results_data = $conn->query("SELECT exam_name, score FROM student_results WHERE student_id = $student_id AND subject = '$subject' ORDER BY id ASC");
$exam_labels = [];
$exam_scores = [];

while($row = $results_data->fetch_assoc()) {
    $exam_labels[] = $row['exam_name'];
    $exam_scores[] = $row['score'];
}

include '../includes/header.php';
?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<div class="wrapper">
    <?php include '../includes/sidebar.php'; ?>
    <div class="main-content">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold text-dark"><?php echo htmlspecialchars($subject); ?> Results</h2>
            <a href="dashboard.php" class="btn btn-outline-secondary fw-bold">← Back to Subjects</a>
        </div>
        
        <div class="card p-4 border-0 shadow-sm rounded-4 bg-white mb-4">
            <canvas id="progressChart" height="80"></canvas>
        </div>

        <div class="card p-0 shadow-sm border-0 rounded-4 overflow-hidden">
            <div class="table-responsive bg-white p-3">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light"><tr><th>Exam Name</th><th>Score</th><th>Status</th></tr></thead>
                    <tbody>
                        <?php 
                        $res_table = $conn->query("SELECT exam_name, score FROM student_results WHERE student_id = $student_id AND subject = '$subject' ORDER BY id ASC");
                        while($r = $res_table->fetch_assoc()): 
                        ?>
                        <tr>
                            <td class="fw-bold"><?php echo $r['exam_name']; ?></td>
                            <td><?php echo $r['score']; ?>%</td>
                            <td>
                                <?php if($r['score'] >= 80): ?>
                                    <span class="badge bg-success">Excellent</span>
                                <?php elseif($r['score'] >= 65): ?>
                                    <span class="badge bg-primary">Good</span>
                                <?php else: ?>
                                    <span class="badge bg-warning text-dark">Needs Improvement</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
const ctx = document.getElementById('progressChart').getContext('2d');
new Chart(ctx, {
    type: 'line',
    data: {
        labels: <?php echo json_encode($exam_labels); ?>,
        datasets: [{
            label: '<?php echo htmlspecialchars($subject); ?> Scores (%)',
            data: <?php echo json_encode($exam_scores); ?>,
            borderColor: '#4e73df',
            backgroundColor: 'rgba(78, 115, 223, 0.1)',
            borderWidth: 3,
            fill: true,
            tension: 0.4,
            pointBackgroundColor: '#4e73df',
            pointRadius: 5
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: {
                beginAtZero: true,
                max: 100
            }
        }
    }
});
</script>
<?php include '../includes/footer.php'; ?>