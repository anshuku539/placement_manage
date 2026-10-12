<!-- Desktop Sidebar -->
<div class="sidebar d-none d-lg-block">
    <div class="sidebar-profile">
        <?php
        $logo = !empty($company['logo'])
            ? "../assets/uploads/companies/" . $company['logo']
            : "../assets/images/default-user.png";
        ?>
        <img src="<?php echo $logo; ?>" alt="Company">
        <h5><?php echo $company['company_name']; ?></h5>
        <p><?php echo $company['company_code']; ?></p>
    </div>

    <?php include 'company-menu.php'; ?>
</div>

<!-- Mobile Sidebar -->
<div class="offcanvas offcanvas-start" tabindex="-1" id="companySidebar">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title">Company Panel</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>

    <div class="offcanvas-body p-0">
        <div class="sidebar-profile bg-light">
            <?php
            $logo = !empty($company['logo'])
                ? "../assets/uploads/companies/" . $company['logo']
                : "../assets/images/default-user.png";
            ?>
            <img src="<?php echo $logo; ?>" alt="Company">
            <h5><?php echo $company['company_name']; ?></h5>
            <p><?php echo $company['company_code']; ?></p>
        </div>

        <?php include 'company-menu.php'; ?>
    </div>
</div>
