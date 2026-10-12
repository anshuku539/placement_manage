<?php
include_once 'includes/config.php';
include_once 'includes/functions.php';

$pageTitle = "Contact Us | AGC Placement Management System";
$metaDescription = "Get in touch with the AGC Training & Placement Cell. Contact us for any placement-related queries, recruitment drives, or campus hiring.";
$metaKeywords = "Contact AGC, Placement Cell Contact, Campus Recruitment, Recruiters, Students";

// Fetch CMS Contact Details & Social Links
$contact_query = mysqli_query($conn, "SELECT * FROM cms_settings LIMIT 1");
$contact = ($contact_query && mysqli_num_rows($contact_query) > 0) ? mysqli_fetch_assoc($contact_query) : [];

$phone = !empty($contact['phone']) ? $contact['phone'] : '+91 98765 43210';
$email = !empty($contact['email']) ? $contact['email'] : 'placement@agc.ac.in';
$address = !empty($contact['address']) ? $contact['address'] : "Amritsar Group of Colleges,\nAmritsar, Punjab";
$google_map = !empty($contact['google_map']) ? $contact['google_map'] : 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3366.0223254704633!2d74.99064137872298!3d31.578766301911664!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x391bd7be1ad9dad7%3A0x49b928cd50a5cbb3!2sAmritsar%20College%20of%20Engineering%20and%20Technology!5e0!3m2!1sen!2sin!4v1788272553789!5m2!1sen!2sin';
$facebook = $contact['facebook'] ?? '';
$instagram = $contact['instagram'] ?? '';
$linkedin = $contact['linkedin'] ?? '';
$youtube = $contact['youtube'] ?? '';

include 'includes/header.php';
include 'includes/navbar.php';
?>

<main>

<!-- Contact Banner -->
<section class="page-banner">
    <div class="container">
        <div class="text-center">
            <h1>Contact Us</h1>
            <p>
                We'd love to hear from you. Get in touch with the Training & Placement Cell for any placement-related queries.
            </p>
        </div>
    </div>
</section>

<!-- Contact Information -->
<section class="contact-info">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">Get In Touch</h2>
            <p class="section-subtitle">
                Feel free to contact us using the information below.
            </p>
        </div>

        <div class="row g-4">
            <div class="col-lg-3 col-md-6">
                <div class="contact-card">
                    <i class="bi bi-geo-alt-fill"></i>
                    <h5>Address</h5>
                    <p><?php echo nl2br(htmlspecialchars($address)); ?></p>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="contact-card">
                    <i class="bi bi-telephone-fill"></i>
                    <h5>Phone</h5>
                    <p><a href="tel:<?php echo preg_replace('/[^0-9+]/', '', $phone); ?>" class="text-secondary"><?php echo htmlspecialchars($phone); ?></a></p>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="contact-card">
                    <i class="bi bi-envelope-fill"></i>
                    <h5>Email</h5>
                    <p><a href="mailto:<?php echo htmlspecialchars($email); ?>" class="text-secondary"><?php echo htmlspecialchars($email); ?></a></p>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="contact-card">
                    <i class="bi bi-clock-fill"></i>
                    <h5>Office Hours</h5>
                    <p>
                        Monday - Friday<br>
                        9:00 AM - 5:00 PM
                    </p>
                </div>
            </div>
        </div>

        <!-- Social Media Links -->
        <?php
        $has_socials = (!empty($facebook) || !empty($instagram) || !empty($linkedin) || !empty($youtube));
        if ($has_socials) {
        ?>
            <div class="text-center mt-5">
                <h6 class="text-muted text-uppercase mb-3" style="letter-spacing: 1px; font-size: 0.85rem;">Connect With Us</h6>
                <div class="d-flex justify-content-center gap-3">
                    <?php if (!empty($facebook)) { ?>
                        <a href="<?php echo htmlspecialchars($facebook); ?>" target="_blank" rel="noopener noreferrer" class="btn btn-outline-primary rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 44px; height: 44px;" title="Facebook">
                            <i class="bi bi-facebook fs-5"></i>
                        </a>
                    <?php } ?>
                    <?php if (!empty($instagram)) { ?>
                        <a href="<?php echo htmlspecialchars($instagram); ?>" target="_blank" rel="noopener noreferrer" class="btn btn-outline-danger rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 44px; height: 44px;" title="Instagram">
                            <i class="bi bi-instagram fs-5"></i>
                        </a>
                    <?php } ?>
                    <?php if (!empty($linkedin)) { ?>
                        <a href="<?php echo htmlspecialchars($linkedin); ?>" target="_blank" rel="noopener noreferrer" class="btn btn-outline-primary rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 44px; height: 44px;" title="LinkedIn">
                            <i class="bi bi-linkedin fs-5"></i>
                        </a>
                    <?php } ?>
                    <?php if (!empty($youtube)) { ?>
                        <a href="<?php echo htmlspecialchars($youtube); ?>" target="_blank" rel="noopener noreferrer" class="btn btn-outline-danger rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 44px; height: 44px;" title="YouTube">
                            <i class="bi bi-youtube fs-5"></i>
                        </a>
                    <?php } ?>
                </div>
            </div>
        <?php } ?>
    </div>
</section>

<!-- Contact Form -->
<section class="contact-form-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="contact-form-box">
                    <div class="text-center mb-4">
                        <h2 class="section-title">Send Us a Message</h2>
                        <p class="section-subtitle">
                            Fill out the form below and we'll get back to you as soon as possible.
                        </p>
                    </div>

                    <form action="#" method="post">
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Full Name</label>
                                <input type="text" class="form-control" placeholder="Enter your full name">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Email Address</label>
                                <input type="email" class="form-control" placeholder="Enter your email">
                            </div>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Phone Number</label>
                                <input type="text" class="form-control" placeholder="Enter your phone number">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Subject</label>
                                <input type="text" class="form-control" placeholder="Enter subject">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Message</label>
                            <textarea class="form-control" rows="5" placeholder="Write your message here"></textarea>
                        </div>

                        <div class="text-center text-md-start">
                            <button type="submit" class="btn btn-primary">
                                Send Message
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Our Location -->
<section class="map-section">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">Our Location</h2>
            <p class="section-subtitle">
                Visit the Training & Placement Cell or locate us using the map below.
            </p>
        </div>

        <div class="map-card">
            <?php 
            if (!empty($google_map)) {
                if (strpos($google_map, '<iframe') !== false) {
                    echo $google_map;
                } else {
                    echo '<iframe src="' . htmlspecialchars($google_map) . '" loading="lazy" allowfullscreen referrerpolicy="no-referrer-when-downgrade"></iframe>';
                }
            } else {
                echo '<p class="text-center text-muted py-5">Map location is not available.</p>';
            }
            ?>
        </div>
    </div>
</section>

<!-- Contact CTA -->
<section class="contact-cta">
    <div class="container">
        <div class="contact-cta-box">
            <h2>Ready to Start Your Career?</h2>
            <p>
                Join our Placement Management System to explore exciting career opportunities, connect with top recruiters and take the next step towards your professional journey.
            </p>
            <div class="cta-buttons mt-4">
                <a href="student-register.php" class="btn btn-light">
                    Student Registration
                </a>
                <a href="jobs.php" class="btn btn-outline-light">
                    Browse Jobs
                </a>
            </div>
        </div>
    </div>
</section>
</main>

<!-- Organization Schema -->
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Organization",
  "name": "AGC Training & Placement Cell",
  "url": "http://localhost/Placement_manage/",
  "logo": "http://localhost/Placement_manage/assets/images/logo.png",
  "contactPoint": {
    "@type": "ContactPoint",
    "telephone": "<?php echo htmlspecialchars($phone); ?>",
    "contactType": "Customer Service",
    "email": "<?php echo htmlspecialchars($email); ?>",
    "areaServed": "IN",
    "availableLanguage": ["en", "hi"]
  }
}
</script>

<?php include 'includes/footer.php'; ?>