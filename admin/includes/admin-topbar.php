<!-- Topbar -->
<div class="topbar">
    <div class="d-flex align-items-center">
        <!-- Sidebar toggle button -->
        <button class="btn btn-primary d-lg-none me-3" type="button" data-bs-toggle="offcanvas" data-bs-target="#adminSidebar" aria-controls="adminSidebar" aria-label="Toggle navigation">
            <i class="bi bi-list"></i>
        </button>

        <div>
            <h5 class="mb-1">
                <?php
                $hour = date("H");

                if ($hour >= 5 && $hour < 12) {
                    echo "Good Morning 👋";
                } elseif ($hour >= 12 && $hour < 17) {
                    echo "Good Afternoon ☀️";
                } else {
                    echo "Good Evening 🌆";
                }
                ?>
            </h5>

            <small>
                Welcome, <strong><?php echo htmlspecialchars($admin['name']); ?></strong>
            </small>
        </div>
    </div>

    <!-- Profile dropdown -->
    <div class="dropdown">
        <a href="#" class="profile-dropdown dropdown-toggle" role="button" id="adminProfileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
            <?php if (!empty($admin['profile_image']) && file_exists('../uploads/' . $admin['profile_image'])) { ?>
                <img src="../uploads/<?php echo $admin['profile_image']; ?>" style="object-fit: cover;">
            <?php } else { ?>
                <img src="../assets/images/default-user.png" style="object-fit: cover;">
            <?php } ?>
            <span><?php echo htmlspecialchars($admin['name']); ?></span>
            <i class="bi bi-chevron-down"></i>
        </a>

        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="adminProfileDropdown">
            <li>
                <a class="dropdown-item" href="profile.php">
                    <i class="bi bi-person-circle me-2"></i> Profile & Settings
                </a>
            </li>

            <li>
                <hr class="dropdown-divider">
            </li>

            <li>
                <a class="dropdown-item text-danger" href="logout.php">
                    <i class="bi bi-box-arrow-right me-2"></i> Logout
                </a>
            </li>
        </ul>
    </div>
</div>
