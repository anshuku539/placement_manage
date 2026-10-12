<div class="topbar">
    <div class="d-flex align-items-center">
        <button class="btn btn-primary d-lg-none me-3" data-bs-toggle="offcanvas" data-bs-target="#companySidebar">
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
                Welcome, <strong><?php echo $company['company_name']; ?></strong>
            </small>
        </div>
    </div>

    <div class="dropdown">
        <a href="#" class="profile-dropdown" data-bs-toggle="dropdown">
            <img src="<?php echo $logo; ?>">
            <span><?php echo $company['company_name']; ?></span>
            <i class="bi bi-chevron-down"></i>
        </a>

        <ul class="dropdown-menu dropdown-menu-end">
            <li>
                <a class="dropdown-item" href="profile.php">
                    <i class="bi bi-person me-2"></i> Company Profile
                </a>
            </li>

            <li>
                <a class="dropdown-item" href="settings.php">
                    <i class="bi bi-gear me-2"></i> Settings
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
