<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit();
}
require_once '../config/db.php';

if(isset($_GET['delete_id'])) {
    $del_id = (int)$_GET['delete_id'];
    $conn->query("DELETE FROM users WHERE id = $del_id");
    $conn->query("INSERT INTO logs (user_id, action) VALUES (".$_SESSION['user_id'].", 'Deleted user ID $del_id')");
    header("Location: manage_users.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_user'])) {
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $default_password = md5('123456'); 
    $role = $conn->real_escape_string($_POST['role']);
    $class_name = isset($_POST['class_name']) ? $conn->real_escape_string($_POST['class_name']) : NULL;
    $section = isset($_POST['section']) ? $conn->real_escape_string($_POST['section']) : NULL;
    $designation = isset($_POST['designation']) ? $conn->real_escape_string($_POST['designation']) : NULL;

    $sql = "INSERT INTO users (name, email, phone, password, role, class_name, section, designation, profile_pic) VALUES ('$name', '$email', '$phone', '$default_password', '$role', '$class_name', '$section', '$designation', 'default.png')";
    $conn->query($sql);
}

$filter = isset($_GET['filter']) ? $_GET['filter'] : 'all';
$where = "";
if($filter !== 'all') {
    $role_filter = $conn->real_escape_string($filter);
    $where = "WHERE role = '$role_filter'";
}
$users = $conn->query("SELECT * FROM users $where ORDER BY created_at DESC");

include '../includes/header.php';
?>
<div class="wrapper" style="display: flex; min-height: 100vh; background-color: #f8f9fc;">
    <?php include '../includes/sidebar.php'; ?>
    <div class="main-content" style="flex: 1; margin-left: 260px; padding: 2rem;">
        <h2 class="fw-bold mb-4">Manage Users</h2>
        
        <div class="card p-4 mb-4 shadow-sm border-0 rounded-4">
            <h6 class="fw-bold mb-3">Add New User</h6>
            <form method="POST">
                <div class="row g-3">
                    <div class="col-md-2">
                        <input type="text" name="name" class="form-control" placeholder="Full Name" required>
                    </div>
                    <div class="col-md-2">
                        <input type="email" name="email" class="form-control" placeholder="Email" required>
                    </div>
                    <div class="col-md-2">
                        <input type="text" name="phone" class="form-control" placeholder="Phone" required>
                    </div>
                    <div class="col-md-2">
                        <select name="role" id="roleSelect" class="form-select" required>
                            <option value="student">Student</option>
                            <option value="teacher">Teacher</option>
                            <option value="principal">Principal</option>
                        </select>
                    </div>
                    <div class="col-md-2" id="classField">
                        <select name="class_name" class="form-select">
                            <option value="">Class</option>
                            <option value="Class 10">Class 10</option>
                        </select>
                    </div>
                    <div class="col-md-2" id="sectionField">
                        <select name="section" class="form-select">
                            <option value="">Sec</option>
                            <option value="A">A</option>
                        </select>
                    </div>
                    <div class="col-md-4" id="teacherField" style="display:none;">
                        <select name="designation" class="form-select">
                            <option value="Lecturer">Lecturer</option>
                            <option value="Senior Lecturer">Senior Lecturer</option>
                        </select>
                    </div>
                    <div class="col-md-12 text-end">
                        <button type="submit" name="add_user" class="btn btn-primary fw-bold px-4">Create Account</button>
                    </div>
                </div>
            </form>
        </div>

        <div class="d-flex gap-2 mb-3">
            <a href="?filter=all" class="btn btn-<?php echo $filter == 'all' ? 'primary' : 'light border'; ?> fw-bold">All</a>
            <a href="?filter=student" class="btn btn-<?php echo $filter == 'student' ? 'primary' : 'light border'; ?> fw-bold">Students</a>
            <a href="?filter=teacher" class="btn btn-<?php echo $filter == 'teacher' ? 'primary' : 'light border'; ?> fw-bold">Teachers</a>
        </div>

        <div class="card p-0 shadow-sm border-0 rounded-4 overflow-hidden">
            <div class="table-responsive bg-white p-3">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Profile</th>
                            <th>Name & Contact</th>
                            <th>Role / Details</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($row = $users->fetch_assoc()): ?>
                        <tr>
                            <td>
                                <img src="../uploads/profiles/<?php echo $row['profile_pic'] ? $row['profile_pic'] : 'default.png'; ?>" class="rounded-circle" style="width: 45px; height: 45px; object-fit: cover; border: 2px solid #eaecf4;">
                                <?php if($row['role']=='student') echo "<br><span class='badge bg-dark mt-1'>ID: ".$row['student_id']."</span>"; ?>
                            </td>
                            <td>
                                <strong class="text-dark"><?php echo $row['name']; ?></strong><br>
                                <span class="text-muted small"><?php echo $row['email']; ?></span><br>
                                <span class="text-muted small"><i class="fa-solid fa-phone me-1"></i><?php echo $row['phone'] ? $row['phone'] : '-'; ?></span>
                            </td>
                            <td>
                                <span class="badge bg-<?php echo $row['role']=='admin'?'danger':($row['role']=='teacher'?'success':'primary'); ?> mb-1"><?php echo ucfirst($row['role']); ?></span>
                                <br><span class="small text-muted fw-bold"><?php echo $row['role'] == 'student' ? $row['class_name'] . " - Sec " . $row['section'] : $row['designation']; ?></span>
                            </td>
                            <td>
                                <?php if($row['role'] !== 'admin'): ?>
                                <a href="manage_users.php?delete_id=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-danger fw-bold" onclick="return confirm('Delete this user permanently?');">Remove</a>
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
    document.getElementById('roleSelect').addEventListener('change', function() {
        var classF = document.getElementById('classField');
        var secF = document.getElementById('sectionField');
        var teachF = document.getElementById('teacherField');
        if(this.value === 'student') {
            classF.style.display = 'block'; secF.style.display = 'block'; teachF.style.display = 'none';
        } else if(this.value === 'teacher') {
            classF.style.display = 'none'; secF.style.display = 'none'; teachF.style.display = 'block';
        } else {
            classF.style.display = 'none'; secF.style.display = 'none'; teachF.style.display = 'none';
        }
    });
</script>
<?php include '../includes/footer.php'; ?>