<ul class="sidebar-menu">
    <li>
        <a href="dashboard.php" class="<?php echo ($current_page == 'dashboard.php') ? 'active' : ''; ?>">
            <i class="bi bi-grid"></i> Dashboard
        </a>
    </li>

    <li>
        <a href="profile.php" class="<?php echo ($current_page == 'profile.php') ? 'active' : ''; ?>">
            <i class="bi bi-building"></i> Company Profile
        </a>
    </li>

    <li>
        <a href="post-job.php" class="<?php echo ($current_page == 'post-job.php') ? 'active' : ''; ?>">
            <i class="bi bi-plus-circle"></i> Post a Job
        </a>
    </li>

    <li>
        <a href="jobs.php" class="<?php echo ($current_page == 'jobs.php') ? 'active' : ''; ?>">
            <i class="bi bi-briefcase"></i> Posted Jobs
        </a>
    </li>

    <li>
        <a href="applications.php" class="<?php echo ($current_page == 'applications.php') ? 'active' : ''; ?>">
            <i class="bi bi-file-earmark-text"></i> Applications
        </a>
    </li>

    <li>
        <a href="notifications.php" class="<?php echo ($current_page == 'notifications.php') ? 'active' : ''; ?>">
            <i class="bi bi-bell"></i> Notifications
        </a>
    </li>

    <li>
        <a href="settings.php" class="<?php echo ($current_page == 'settings.php') ? 'active' : ''; ?>">
            <i class="bi bi-gear"></i> Settings
        </a>
    </li>

    <li>
        <a href="logout.php">
            <i class="bi bi-box-arrow-right"></i> Logout
        </a>
    </li>
</ul>
