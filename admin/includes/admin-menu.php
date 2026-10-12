<ul class="sidebar-menu">
    <li>
        <a href="dashboard.php" class="<?php echo ($current_page == 'dashboard.php') ? 'active' : ''; ?>">
            <i class="bi bi-grid"></i> Dashboard
        </a>
    </li>

    <li>
        <a href="students.php" class="<?php echo ($current_page == 'students.php') ? 'active' : ''; ?>">
            <i class="bi bi-people"></i> Manage Students
        </a>
    </li>

    <li>
        <a href="companies.php" class="<?php echo ($current_page == 'companies.php') ? 'active' : ''; ?>">
            <i class="bi bi-buildings"></i> Manage Companies
        </a>
    </li>

    <li>
        <a href="jobs.php" class="<?php echo ($current_page == 'jobs.php') ? 'active' : ''; ?>">
            <i class="bi bi-briefcase"></i> Manage Jobs
        </a>
    </li>

    <li>
        <a href="applications.php" class="<?php echo ($current_page == 'applications.php') ? 'active' : ''; ?>">
            <i class="bi bi-file-earmark-text"></i> All Applications
        </a>
    </li>

    <li>
        <a href="selected_students.php" class="<?php echo ($current_page == 'selected_students.php') ? 'active' : ''; ?>">
            <i class="bi bi-person-check"></i> Selected Students
        </a>
    </li>

    <li>
        <a href="website-management.php" class="<?php echo ($current_page == 'website-management.php') ? 'active' : ''; ?>">
            <i class="bi bi-globe"></i> Website Management
        </a>
    </li>

    <li>
        <a href="profile.php" class="<?php echo ($current_page == 'profile.php') ? 'active' : ''; ?>">
            <i class="bi bi-person-circle"></i> Profile & Settings
        </a>
    </li>

    <li>
        <a href="logout.php">
            <i class="bi bi-box-arrow-right"></i> Logout
        </a>
    </li>
</ul>
