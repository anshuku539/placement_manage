<!-- Desktop Sidebar -->
<div class="sidebar d-none d-lg-block">
    <div class="sidebar-profile">
        <?php
        $photo = !empty($student['profile_photo'])
            ? "../assets/uploads/students/" . $student['profile_photo']
            : "../assets/images/default-user.png";
        ?>
        <img src="<?php echo $photo; ?>" alt="Student">
        <h5><?php echo $student['name']; ?></h5>
        <p><?php echo $student['registration_id']; ?></p>
    </div>

    <?php include 'student-menu.php'; ?>
</div>

<!-- Mobile Sidebar -->
<div class="offcanvas offcanvas-start" tabindex="-1" id="studentSidebar">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title">Student Panel</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>

    <div class="offcanvas-body p-0">
        <div class="sidebar-profile bg-light">
            <?php
            $photo = !empty($student['profile_photo'])
                ? "../assets/uploads/students/" . $student['profile_photo']
                : "../assets/images/default-user.png";
            ?>
            <img src="<?php echo $photo; ?>" alt="Student">
            <h5><?php echo $student['name']; ?></h5>
            <p><?php echo $student['registration_id']; ?></p>
        </div>

        <?php include 'student-menu.php'; ?>
    </div>
</div>