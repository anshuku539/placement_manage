<!-- Desktop Sidebar -->
<div class="sidebar d-none d-lg-block">
    <div class="sidebar-profile">
        <?php if (!empty($admin['profile_image']) && file_exists('../uploads/' . $admin['profile_image'])) { ?>
            <img src="../uploads/<?php echo $admin['profile_image']; ?>" alt="Admin" style="object-fit: cover;">
        <?php } else { ?>
            <img src="../assets/images/default-user.png" alt="Admin" style="object-fit: cover;">
        <?php } ?>
        <h5><?php echo htmlspecialchars($admin['name']); ?></h5>
        <p>Administrator</p>
    </div>

    <?php include 'admin-menu.php'; ?>
</div>

<!-- Mobile Sidebar -->
<div class="offcanvas offcanvas-start" tabindex="-1" id="adminSidebar" aria-labelledby="adminSidebarLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="adminSidebarLabel">Admin Panel</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>

    <div class="offcanvas-body p-0">
        <div class="sidebar-profile bg-light">
            <?php if (!empty($admin['profile_image']) && file_exists('../uploads/' . $admin['profile_image'])) { ?>
                <img src="../uploads/<?php echo $admin['profile_image']; ?>" alt="Admin" style="object-fit: cover;">
            <?php } else { ?>
                <img src="../assets/images/default-user.png" alt="Admin" style="object-fit: cover;">
            <?php } ?>
            <h5><?php echo htmlspecialchars($admin['name']); ?></h5>
            <p>Administrator</p>
        </div>

        <?php include 'admin-menu.php'; ?>
    </div>
</div>
