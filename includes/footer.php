<?php
// Ensure CMS settings are loaded for footer
if (isset($conn) && !isset($footer_settings)) {
    $f_query = mysqli_query($conn, "SELECT * FROM cms_settings LIMIT 1");
    $footer_settings = ($f_query && mysqli_num_rows($f_query) > 0) ? mysqli_fetch_assoc($f_query) : [];
}

$site_name = !empty($footer_settings['website_name']) ? $footer_settings['website_name'] : 'Placement Management System';
$footer_about = !empty($footer_settings['footer_about']) ? $footer_settings['footer_about'] : 'A simple Placement Management System that connects students with leading companies for better career opportunities.';
$f_email = !empty($footer_settings['email']) ? $footer_settings['email'] : 'placement@agc.ac.in';
$f_phone = !empty($footer_settings['phone']) ? $footer_settings['phone'] : '+91 98765 43210';
$f_address = !empty($footer_settings['address']) ? $footer_settings['address'] : "Amritsar Group of Colleges,\nAmritsar, Punjab";
$f_facebook = !empty($footer_settings['facebook']) ? $footer_settings['facebook'] : 'https://www.facebook.com';
$f_instagram = !empty($footer_settings['instagram']) ? $footer_settings['instagram'] : 'https://www.instagram.com';
$f_linkedin = !empty($footer_settings['linkedin']) ? $footer_settings['linkedin'] : 'https://www.linkedin.com';
$f_youtube = !empty($footer_settings['youtube']) ? $footer_settings['youtube'] : 'https://www.youtube.com';
$f_twitter = !empty($footer_settings['twitter']) ? $footer_settings['twitter'] : '';
?>
<!-- Footer -->
<footer>
    <div class="container">
        <div class="row g-4">
            <!-- 1. LOGO + About -->
            <div class="col-lg-4 col-md-6 mb-2">
                <a class="navbar-brand text-white fw-bold fs-3 d-inline-flex align-items-center mb-2" href="index.php">
                    AGC T&P
                </a>
                <h6 class="text-white small fw-semibold mb-2">
                    <?php echo htmlspecialchars($site_name); ?>
                </h6>
                <p class="text-white-50 small mb-0 pe-lg-4">
                    <?php echo htmlspecialchars($footer_about); ?>
                </p>
            </div>

            <!-- 2. Quick Links -->
            <div class="col-lg-2 col-md-6 col-sm-6 mb-2">
                <h5 class="text-white fw-semibold mb-3">Quick Links</h5>
                <ul class="list-unstyled footer-quick-links d-flex flex-column gap-2 small mb-0">
                    <li><a href="index.php">Home</a></li>
                    <li><a href="about.php">About</a></li>
                    <li><a href="companies.php">Companies</a></li>
                    <li><a href="jobs.php">Jobs</a></li>
                    <li><a href="contact.php">Contact</a></li>
                </ul>
            </div>

            <!-- 3. Contact -->
            <div class="col-lg-3 col-md-6 col-sm-6 mb-2">
                <h5 class="text-white fw-semibold mb-3">Contact</h5>
                <ul class="list-unstyled d-flex flex-column gap-2 small text-white-50 mb-0">
                    <li class="d-flex align-items-start gap-2">
                        <i class="bi bi-telephone-fill text-primary mt-1"></i>
                        <div>
                            <span class="d-block text-white fw-medium">Phone</span>
                            <a href="tel:<?php echo preg_replace('/[^0-9+]/', '', $f_phone); ?>" class="footer-contact-link"><?php echo htmlspecialchars($f_phone); ?></a>
                        </div>
                    </li>
                    <li class="d-flex align-items-start gap-2">
                        <i class="bi bi-envelope-fill text-primary mt-1"></i>
                        <div>
                            <span class="d-block text-white fw-medium">Email</span>
                            <a href="mailto:<?php echo htmlspecialchars($f_email); ?>" class="footer-contact-link"><?php echo htmlspecialchars($f_email); ?></a>
                        </div>
                    </li>
                    <li class="d-flex align-items-start gap-2">
                        <i class="bi bi-geo-alt-fill text-primary mt-1"></i>
                        <div>
                            <span class="d-block text-white fw-medium">Address</span>
                            <span><?php echo nl2br(htmlspecialchars($f_address)); ?></span>
                        </div>
                    </li>
                </ul>
            </div>

            <!-- 4. Follow Us -->
            <div class="col-lg-3 col-md-6 mb-2">
                <h5 class="text-white fw-semibold mb-3">Follow Us</h5>
                <ul class="list-unstyled d-flex flex-column gap-2 small mb-0">
                    <?php if (!empty($f_facebook)) { ?>
                        <li>
                            <a href="<?php echo htmlspecialchars($f_facebook); ?>" target="_blank" rel="noopener noreferrer" class="footer-social-link">
                                <span class="footer-social-btn"><i class="bi bi-facebook"></i></span>
                                <span class="footer-social-text">Facebook</span>
                            </a>
                        </li>
                    <?php } ?>
                    <?php if (!empty($f_instagram)) { ?>
                        <li>
                            <a href="<?php echo htmlspecialchars($f_instagram); ?>" target="_blank" rel="noopener noreferrer" class="footer-social-link">
                                <span class="footer-social-btn"><i class="bi bi-instagram"></i></span>
                                <span class="footer-social-text">Instagram</span>
                            </a>
                        </li>
                    <?php } ?>
                    <?php if (!empty($f_linkedin)) { ?>
                        <li>
                            <a href="<?php echo htmlspecialchars($f_linkedin); ?>" target="_blank" rel="noopener noreferrer" class="footer-social-link">
                                <span class="footer-social-btn"><i class="bi bi-linkedin"></i></span>
                                <span class="footer-social-text">LinkedIn</span>
                            </a>
                        </li>
                    <?php } ?>
                    <?php if (!empty($f_youtube)) { ?>
                        <li>
                            <a href="<?php echo htmlspecialchars($f_youtube); ?>" target="_blank" rel="noopener noreferrer" class="footer-social-link">
                                <span class="footer-social-btn"><i class="bi bi-youtube"></i></span>
                                <span class="footer-social-text">YouTube</span>
                            </a>
                        </li>
                    <?php } ?>
                    <?php if (!empty($f_twitter)) { ?>
                        <li>
                            <a href="<?php echo htmlspecialchars($f_twitter); ?>" target="_blank" rel="noopener noreferrer" class="footer-social-link">
                                <span class="footer-social-btn"><i class="bi bi-twitter-x"></i></span>
                                <span class="footer-social-text">X (Twitter)</span>
                            </a>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        </div>

        <hr class="border-secondary my-4">

        <!-- Copyright & Legal -->
        <div class="text-center">
            <p class="mb-0 text-white-50 small">
                © <?php echo date('Y'); ?> AGC Training & Placement | 
                <a href="privacy.php" class="footer-bottom-link">Privacy</a> | 
                <a href="terms.php" class="footer-bottom-link">Terms</a>
            </p>
        </div>
    </div>
</footer>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>