<?php
$currentPage = basename($_SERVER['PHP_SELF']);
?>
<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
    <div class="container">
        <!-- Logo -->
        <a class="navbar-brand fw-bold fs-3" href="index.php">
            AGC T&P
        </a>

        <!-- Mobile Toggle -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navbar Menu -->
        <div class="collapse navbar-collapse" id="mainNavbar">
            <!-- Left Menu -->
            <ul class="navbar-nav mx-auto">
                <li class="nav-item">
                    <a class="nav-link <?php if ($currentPage == 'index.php') echo 'active'; ?>" href="index.php">
                        Home
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php if ($currentPage == 'about.php') echo 'active'; ?>" href="about.php">
                        About
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php if ($currentPage == 'companies.php') echo 'active'; ?>" href="companies.php">
                        Companies
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php if ($currentPage == 'jobs.php') echo 'active'; ?>" href="jobs.php">
                        Jobs
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php if ($currentPage == 'contact.php') echo 'active'; ?>" href="contact.php">
                        Contact
                    </a>
                </li>
            </ul>

            <!-- Login dropdown -->
            <div class="dropdown">
                <button class="btn btn-primary dropdown-toggle" type="button" id="loginDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    Login
                </button>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="loginDropdown">
                    <!-- Student Login -->
                    <li>
                        <a class="dropdown-item <?php if ($currentPage == 'student-login.php') echo 'active'; ?>" href="student-login.php">
                            <i class="bi bi-mortarboard me-2 text-primary"></i> Student Login
                        </a>
                    </li>
                    <!-- Company Login -->
                    <li>
                        <a class="dropdown-item <?php if ($currentPage == 'company-login.php') echo 'active'; ?>" href="company-login.php">
                            <i class="bi bi-building me-2 text-primary"></i> Company Login
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>