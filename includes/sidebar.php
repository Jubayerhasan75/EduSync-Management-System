<?php
$current_page = basename($_SERVER['PHP_SELF']);
$role = $_SESSION['role'];
$user_name = $_SESSION['name'];
?>
<div class="sidebar-custom d-flex flex-column" style="width: 260px; background: #1a1c23; color: #fff; padding: 2rem 1.5rem; position: fixed; height: 100vh; overflow-y: auto;">
    <a href="../index.php" class="text-decoration-none mb-4 d-block" style="font-family: 'Inter', sans-serif; font-size: 1.8rem; font-weight: 800; color: #4e73df;">
        EduSync<span style="color: #f6c23e;">.</span>
    </a>
    <ul class="nav nav-pills flex-column mb-auto">
        <?php if($role == 'admin'): ?>
            <li><a href="dashboard.php" class="nav-link text-white <?php echo ($current_page == 'dashboard.php') ? 'active bg-primary' : ''; ?>">Dashboard</a></li>
            <li><a href="manage_users.php" class="nav-link text-white <?php echo ($current_page == 'manage_users.php') ? 'active bg-primary' : ''; ?>">Manage Users</a></li>
            <li><a href="approve_notes.php" class="nav-link text-white <?php echo ($current_page == 'approve_notes.php') ? 'active bg-primary' : ''; ?>">Approve Notes</a></li>
            <li><a href="announcements.php" class="nav-link text-white <?php echo ($current_page == 'announcements.php') ? 'active bg-primary' : ''; ?>">Announcements</a></li>
        <?php elseif($role == 'teacher'): ?>
            <li><a href="dashboard.php" class="nav-link text-white <?php echo ($current_page == 'dashboard.php') ? 'active bg-primary' : ''; ?>">Dashboard</a></li>
            <li><a href="upload_notes.php" class="nav-link text-white <?php echo ($current_page == 'upload_notes.php') ? 'active bg-primary' : ''; ?>">Study Notes</a></li>
            <li><a href="announcements.php" class="nav-link text-white <?php echo ($current_page == 'announcements.php') ? 'active bg-primary' : ''; ?>">Announcements</a></li>
        <?php elseif($role == 'student'): ?>
            <li><a href="dashboard.php" class="nav-link text-white <?php echo ($current_page == 'dashboard.php') ? 'active bg-primary' : ''; ?>">Student Panel</a></li>
            <li><a href="view_notes.php" class="nav-link text-white <?php echo ($current_page == 'view_notes.php' || $current_page == 'subject_notes.php') ? 'active bg-primary' : ''; ?>">Study Material</a></li>
            <li><a href="announcements.php" class="nav-link text-white <?php echo ($current_page == 'announcements.php') ? 'active bg-primary' : ''; ?>">Announcements</a></li>
            <li><a href="teachers.php" class="nav-link text-white <?php echo ($current_page == 'teachers.php') ? 'active bg-primary' : ''; ?>">Teacher Directory</a></li>
        <?php endif; ?>
        
        <li class="mt-4"><a href="profile.php" class="nav-link text-white <?php echo ($current_page == 'profile.php') ? 'active bg-primary' : ''; ?>">Profile Settings</a></li>
    </ul>
    <div class="pt-4 border-top border-secondary mt-auto">
        <div class="text-white mb-3 small fw-bold">Signed in as: <br><?php echo $user_name; ?></div>
        <a href="../auth/logout.php" class="btn btn-outline-danger w-100 fw-bold">Sign Out</a>
    </div>
</div>