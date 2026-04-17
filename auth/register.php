<?php
session_start();
if(isset($_SESSION['user_id'])){
    header("Location: ../" . $_SESSION['role'] . "/dashboard.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - EduSync</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        body { background: #f4f7fe; font-family: 'Inter', sans-serif; min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 20px 0; }
        .reg-box { background: white; padding: 40px; border-radius: 25px; box-shadow: 0 15px 35px rgba(0,0,0,0.1); width: 100%; max-width: 550px; }
    </style>
</head>
<body>
    <div class="reg-box">
        <div class="text-center mb-4">
            <a href="../index.php" class="text-decoration-none"><h2 class="fw-bold text-primary">EduSync.</h2></a>
        </div>

        <?php if(isset($_GET['error'])): ?>
            <div class="alert alert-danger border-0 small">
                <?php 
                    if($_GET['error'] == 'exists') echo "This email is already registered!";
                    elseif($_GET['error'] == 'code') echo "Invalid Teacher Security Code!";
                    elseif($_GET['error'] == 'id_exists') echo "This Student ID is already taken!";
                ?>
            </div>
        <?php endif; ?>

        <form action="register_process.php" method="POST" enctype="multipart/form-data">
            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label class="form-label fw-bold small">Full Name</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold small">Phone Number</label>
                    <input type="text" name="phone" class="form-control" required>
                </div>
            </div>
            
            <div class="mb-3">
                <label class="form-label fw-bold small">Email Address</label>
                <input type="email" name="email" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold small">Password</label>
                <div class="password-toggle-group">
                    <input type="password" name="password" id="password" class="form-control" required>
                    <i class="fa-solid fa-eye-slash toggle-password" id="togglePassword"></i>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold small">Profile Picture</label>
                <input type="file" name="profile_pic" class="form-control" accept="image/*">
            </div>

            <div class="mb-4">
                <label class="form-label fw-bold small">Register As</label>
                <select name="role" id="roleSelect" class="form-select" required>
                    <option value="student">Student</option>
                    <option value="teacher">Teacher</option>
                </select>
            </div>

            <div id="studentFields" class="row mb-4">
                <div class="col-4">
                    <label class="form-label fw-bold small">4-Digit ID</label>
                    <input type="text" name="student_id" class="form-control" pattern="\d{4}" placeholder="e.g. 1022">
                </div>
                <div class="col-4">
                    <label class="form-label fw-bold small">Class</label>
                    <select name="class_name" class="form-select">
                        <option value="">Class</option>
                        <option value="Class 6">Class 6</option>
                        <option value="Class 7">Class 7</option>
                        <option value="Class 8">Class 8</option>
                        <option value="Class 9">Class 9</option>
                        <option value="Class 10">Class 10</option>
                    </select>
                </div>
                <div class="col-4">
                    <label class="form-label fw-bold small">Section</label>
                    <select name="section" class="form-select">
                        <option value="">Sec</option>
                        <option value="A">A</option>
                        <option value="B">B</option>
                        <option value="C">C</option>
                    </select>
                </div>
            </div>

            <div id="teacherFields" class="row mb-4" style="display: none;">
                <div class="col-6">
                    <label class="form-label fw-bold small text-danger">Security Code</label>
                    <input type="password" name="secret_code" class="form-control">
                </div>
                <div class="col-6">
                    <label class="form-label fw-bold small">Designation</label>
                    <select name="designation" class="form-select">
                        <option value="Lecturer">Lecturer</option>
                        <option value="Senior Lecturer">Senior Lecturer</option>
                        <option value="Assistant Professor">Assistant Professor</option>
                    </select>
                </div>
            </div>

            <button type="submit" class="btn btn-primary w-100 fw-bold py-2 shadow-sm">REGISTER NOW</button>
        </form>
    </div>

    <script>
        const togglePassword = document.querySelector("#togglePassword");
        const password = document.querySelector("#password");
        togglePassword.addEventListener("click", function () {
            const type = password.getAttribute("type") === "password" ? "text" : "password";
            password.setAttribute("type", type);
            this.classList.toggle("fa-eye");
            this.classList.toggle("fa-eye-slash");
        });

        const roleSelect = document.getElementById('roleSelect');
        const studentFields = document.getElementById('studentFields');
        const teacherFields = document.getElementById('teacherFields');
        
        roleSelect.addEventListener('change', function() {
            if(this.value === 'student') {
                studentFields.style.display = 'flex';
                teacherFields.style.display = 'none';
            } else if(this.value === 'teacher') {
                studentFields.style.display = 'none';
                teacherFields.style.display = 'flex';
            }
        });
    </script>
</body>
</html>