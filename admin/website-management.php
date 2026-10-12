<?php
include 'includes/admin-header.php';
include 'includes/admin-sidebar.php';

// Upload folder
$upload_dir = __DIR__ . '/../assets/uploads/cms/';
if (!is_dir($upload_dir)) {
    mkdir($upload_dir, 0777, true);
}

// Helper to get image path for preview
if (!function_exists('getCmsImage')) {
    function getCmsImage($filename, $subfolder = '', $default = '') {
        if (empty($filename)) {
            return $default;
        }
        if (file_exists('../assets/uploads/cms/' . $filename)) {
            return '../assets/uploads/cms/' . $filename;
        }
        if (!empty($subfolder) && file_exists('../assets/images/' . $subfolder . '/' . $filename)) {
            return '../assets/images/' . $subfolder . '/' . $filename;
        }
        if (file_exists('../assets/images/' . $filename)) {
            return '../assets/images/' . $filename;
        }
        return $default;
    }
}

// Ensure initial rows exist
$check_hero = mysqli_query($conn, "SELECT id FROM cms_hero LIMIT 1");
if (mysqli_num_rows($check_hero) == 0) {
    mysqli_query($conn, "INSERT INTO cms_hero (title, subtitle, image) VALUES ('Build Your Career with Top Companies', 'Connect with leading companies, explore exciting job opportunities, and begin your professional journey.', 'hero.png')");
}

$check_about = mysqli_query($conn, "SELECT id FROM cms_about LIMIT 1");
if (mysqli_num_rows($check_about) == 0) {
    mysqli_query($conn, "INSERT INTO cms_about (heading, description, image) VALUES ('About Our Placement Cell', 'The Training and Placement Cell acts as a bridge between students and recruiters by organizing campus placement drives, career guidance sessions, aptitude training and interview preparation activities.', 'hero.png')");
}

$check_settings = mysqli_query($conn, "SELECT id FROM cms_settings LIMIT 1");
if (mysqli_num_rows($check_settings) == 0) {
    mysqli_query($conn, "INSERT INTO cms_settings (website_name, phone, email, address) VALUES ('Placement Management System', '+91 98765 43210', 'placement@agc.ac.in', 'Amritsar Group of Colleges, Amritsar, Punjab')");
}

// Hero update
if (isset($_POST['update_hero'])) {
    $title = clean($conn, $_POST['title']);
    $subtitle = clean($conn, $_POST['subtitle']);

    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $uploaded = uploadImage($_FILES['image'], '../assets/uploads/cms');
        if ($uploaded) {
            $row = mysqli_fetch_assoc(mysqli_query($conn, "SELECT image FROM cms_hero LIMIT 1"));
            if (!empty($row['image']) && file_exists('../assets/uploads/cms/' . $row['image'])) {
                unlink('../assets/uploads/cms/' . $row['image']);
            }
            mysqli_query($conn, "UPDATE cms_hero SET title='$title', subtitle='$subtitle', image='$uploaded'");
        }
    } else {
        mysqli_query($conn, "UPDATE cms_hero SET title='$title', subtitle='$subtitle'");
    }

    $_SESSION['success'] = "Hero section updated successfully.";
    redirect("website-management.php?tab=home");
}

// Add statistic
if (isset($_POST['add_stat'])) {
    $title = clean($conn, $_POST['title']);
    $number = clean($conn, $_POST['number']);
    $sort_order = (int)$_POST['sort_order'];

    mysqli_query($conn, "INSERT INTO cms_statistics (title, number, sort_order) VALUES ('$title', '$number', '$sort_order')");
    $_SESSION['success'] = "Statistic added successfully.";
    redirect("website-management.php?tab=home");
}

// Update statistic
if (isset($_POST['update_stat'])) {
    $id = (int)$_POST['stat_id'];
    $title = clean($conn, $_POST['title']);
    $number = clean($conn, $_POST['number']);
    $sort_order = (int)$_POST['sort_order'];

    mysqli_query($conn, "UPDATE cms_statistics SET title='$title', number='$number', sort_order='$sort_order' WHERE id='$id'");
    $_SESSION['success'] = "Statistic updated successfully.";
    redirect("website-management.php?tab=home");
}

// Delete statistic
if (isset($_GET['delete_stat'])) {
    $id = (int)$_GET['delete_stat'];
    mysqli_query($conn, "DELETE FROM cms_statistics WHERE id='$id'");
    $_SESSION['success'] = "Statistic deleted successfully.";
    redirect("website-management.php?tab=home");
}

// Add recruiter
if (isset($_POST['add_recruiter'])) {
    $company_name = clean($conn, $_POST['company_name']);
    $sort_order = (int)$_POST['sort_order'];
    $logo = '';

    if (isset($_FILES['logo']) && $_FILES['logo']['error'] == 0) {
        $logo = uploadImage($_FILES['logo'], '../assets/uploads/cms');
    }

    mysqli_query($conn, "INSERT INTO cms_recruiters (company_name, logo, sort_order) VALUES ('$company_name', '$logo', '$sort_order')");
    $_SESSION['success'] = "Recruiter added successfully.";
    redirect("website-management.php?tab=home");
}

// Update recruiter
if (isset($_POST['update_recruiter'])) {
    $id = (int)$_POST['recruiter_id'];
    $company_name = clean($conn, $_POST['company_name']);
    $sort_order = (int)$_POST['sort_order'];

    if (isset($_FILES['logo']) && $_FILES['logo']['error'] == 0) {
        $logo = uploadImage($_FILES['logo'], '../assets/uploads/cms');
        if ($logo) {
            $row = mysqli_fetch_assoc(mysqli_query($conn, "SELECT logo FROM cms_recruiters WHERE id='$id'"));
            if (!empty($row['logo']) && file_exists('../assets/uploads/cms/' . $row['logo'])) {
                unlink('../assets/uploads/cms/' . $row['logo']);
            }
            mysqli_query($conn, "UPDATE cms_recruiters SET company_name='$company_name', logo='$logo', sort_order='$sort_order' WHERE id='$id'");
        }
    } else {
        mysqli_query($conn, "UPDATE cms_recruiters SET company_name='$company_name', sort_order='$sort_order' WHERE id='$id'");
    }

    $_SESSION['success'] = "Recruiter updated successfully.";
    redirect("website-management.php?tab=home");
}

// Delete recruiter
if (isset($_GET['delete_recruiter'])) {
    $id = (int)$_GET['delete_recruiter'];
    $row = mysqli_fetch_assoc(mysqli_query($conn, "SELECT logo FROM cms_recruiters WHERE id='$id'"));
    if (!empty($row['logo']) && file_exists('../assets/uploads/cms/' . $row['logo'])) {
        unlink('../assets/uploads/cms/' . $row['logo']);
    }

    mysqli_query($conn, "DELETE FROM cms_recruiters WHERE id='$id'");
    $_SESSION['success'] = "Recruiter deleted successfully.";
    redirect("website-management.php?tab=home");
}

// Add testimonial
if (isset($_POST['add_testimonial'])) {
    $student_name = clean($conn, $_POST['student_name']);
    $course = clean($conn, $_POST['course']);
    $company = clean($conn, $_POST['company']);
    $rating = (int)$_POST['rating'];
    $message = clean($conn, $_POST['message']);
    $sort_order = (int)$_POST['sort_order'];
    $photo = '';

    if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
        $photo = uploadImage($_FILES['photo'], '../assets/uploads/cms');
    }

    mysqli_query($conn, "INSERT INTO cms_testimonials (student_name, course, company, rating, message, photo, sort_order) VALUES ('$student_name', '$course', '$company', '$rating', '$message', '$photo', '$sort_order')");
    $_SESSION['success'] = "Testimonial added successfully.";
    redirect("website-management.php?tab=home");
}

// Update testimonial
if (isset($_POST['update_testimonial'])) {
    $id = (int)$_POST['testimonial_id'];
    $student_name = clean($conn, $_POST['student_name']);
    $course = clean($conn, $_POST['course']);
    $company = clean($conn, $_POST['company']);
    $rating = (int)$_POST['rating'];
    $message = clean($conn, $_POST['message']);
    $sort_order = (int)$_POST['sort_order'];

    if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
        $photo = uploadImage($_FILES['photo'], '../assets/uploads/cms');
        if ($photo) {
            $row = mysqli_fetch_assoc(mysqli_query($conn, "SELECT photo FROM cms_testimonials WHERE id='$id'"));
            if (!empty($row['photo']) && file_exists('../assets/uploads/cms/' . $row['photo'])) {
                unlink('../assets/uploads/cms/' . $row['photo']);
            }
            mysqli_query($conn, "UPDATE cms_testimonials SET student_name='$student_name', course='$course', company='$company', rating='$rating', message='$message', photo='$photo', sort_order='$sort_order' WHERE id='$id'");
        }
    } else {
        mysqli_query($conn, "UPDATE cms_testimonials SET student_name='$student_name', course='$course', company='$company', rating='$rating', message='$message', sort_order='$sort_order' WHERE id='$id'");
    }

    $_SESSION['success'] = "Testimonial updated successfully.";
    redirect("website-management.php?tab=home");
}

// Delete testimonial
if (isset($_GET['delete_testimonial'])) {
    $id = (int)$_GET['delete_testimonial'];
    $row = mysqli_fetch_assoc(mysqli_query($conn, "SELECT photo FROM cms_testimonials WHERE id='$id'"));
    if (!empty($row['photo']) && file_exists('../assets/uploads/cms/' . $row['photo'])) {
        unlink('../assets/uploads/cms/' . $row['photo']);
    }

    mysqli_query($conn, "DELETE FROM cms_testimonials WHERE id='$id'");
    $_SESSION['success'] = "Testimonial deleted successfully.";
    redirect("website-management.php?tab=home");
}

// Update about content
if (isset($_POST['update_about'])) {
    $heading = clean($conn, $_POST['heading']);
    $description = clean($conn, $_POST['description']);

    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $uploaded = uploadImage($_FILES['image'], '../assets/uploads/cms');
        if ($uploaded) {
            $row = mysqli_fetch_assoc(mysqli_query($conn, "SELECT image FROM cms_about LIMIT 1"));
            if (!empty($row['image']) && file_exists('../assets/uploads/cms/' . $row['image'])) {
                unlink('../assets/uploads/cms/' . $row['image']);
            }
            mysqli_query($conn, "UPDATE cms_about SET heading='$heading', description='$description', image='$uploaded'");
        }
    } else {
        mysqli_query($conn, "UPDATE cms_about SET heading='$heading', description='$description'");
    }

    $_SESSION['success'] = "About content updated successfully.";
    redirect("website-management.php?tab=about");
}

// Add team member
if (isset($_POST['add_team_member'])) {
    $name = clean($conn, $_POST['name']);
    $designation = clean($conn, $_POST['designation']);
    $sort_order = (int)$_POST['sort_order'];
    $image = '';

    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $image = uploadImage($_FILES['image'], '../assets/uploads/cms');
    }

    mysqli_query($conn, "INSERT INTO cms_team (name, designation, image, sort_order) VALUES ('$name', '$designation', '$image', '$sort_order')");
    $_SESSION['success'] = "Team member added successfully.";
    redirect("website-management.php?tab=about");
}

// Update team member
if (isset($_POST['update_team_member'])) {
    $id = (int)$_POST['team_id'];
    $name = clean($conn, $_POST['name']);
    $designation = clean($conn, $_POST['designation']);
    $sort_order = (int)$_POST['sort_order'];

    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $image = uploadImage($_FILES['image'], '../assets/uploads/cms');
        if ($image) {
            $row = mysqli_fetch_assoc(mysqli_query($conn, "SELECT image FROM cms_team WHERE id='$id'"));
            if (!empty($row['image']) && file_exists('../assets/uploads/cms/' . $row['image'])) {
                unlink('../assets/uploads/cms/' . $row['image']);
            }
            mysqli_query($conn, "UPDATE cms_team SET name='$name', designation='$designation', image='$image', sort_order='$sort_order' WHERE id='$id'");
        }
    } else {
        mysqli_query($conn, "UPDATE cms_team SET name='$name', designation='$designation', sort_order='$sort_order' WHERE id='$id'");
    }

    $_SESSION['success'] = "Team member updated successfully.";
    redirect("website-management.php?tab=about");
}

// Delete team member
if (isset($_GET['delete_team_member'])) {
    $id = (int)$_GET['delete_team_member'];
    $row = mysqli_fetch_assoc(mysqli_query($conn, "SELECT image FROM cms_team WHERE id='$id'"));
    if (!empty($row['image']) && file_exists('../assets/uploads/cms/' . $row['image'])) {
        unlink('../assets/uploads/cms/' . $row['image']);
    }

    mysqli_query($conn, "DELETE FROM cms_team WHERE id='$id'");
    $_SESSION['success'] = "Team member deleted successfully.";
    redirect("website-management.php?tab=about");
}

// Update contact details
if (isset($_POST['update_contact'])) {
    $phone = clean($conn, $_POST['phone']);
    $email = clean($conn, $_POST['email']);
    $address = clean($conn, $_POST['address']);
    $google_map = clean($conn, $_POST['google_map']);
    $facebook = clean($conn, $_POST['facebook']);
    $instagram = clean($conn, $_POST['instagram']);
    $linkedin = clean($conn, $_POST['linkedin']);
    $youtube = clean($conn, $_POST['youtube']);

    mysqli_query($conn, "
        UPDATE cms_settings 
        SET phone='$phone', 
            email='$email', 
            address='$address', 
            google_map='$google_map',
            facebook='$facebook', 
            instagram='$instagram', 
            linkedin='$linkedin', 
            youtube='$youtube'
    ");

    $_SESSION['success'] = "Contact details updated successfully.";
    redirect("website-management.php?tab=contact");
}

// Active tab
$active_tab = isset($_GET['tab']) ? $_GET['tab'] : 'home';

// Fetch single-row records
$hero = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM cms_hero LIMIT 1"));
$about = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM cms_about LIMIT 1"));
$contact = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM cms_settings LIMIT 1"));

// Check server-side edit modes (fallback)
$edit_stat = null;
if (isset($_GET['edit_stat'])) {
    $edit_id = (int)$_GET['edit_stat'];
    $res = mysqli_query($conn, "SELECT * FROM cms_statistics WHERE id='$edit_id'");
    if (mysqli_num_rows($res) > 0) {
        $edit_stat = mysqli_fetch_assoc($res);
    }
}

$edit_recruiter = null;
if (isset($_GET['edit_recruiter'])) {
    $edit_id = (int)$_GET['edit_recruiter'];
    $res = mysqli_query($conn, "SELECT * FROM cms_recruiters WHERE id='$edit_id'");
    if (mysqli_num_rows($res) > 0) {
        $edit_recruiter = mysqli_fetch_assoc($res);
    }
}

$edit_testimonial = null;
if (isset($_GET['edit_testimonial'])) {
    $edit_id = (int)$_GET['edit_testimonial'];
    $res = mysqli_query($conn, "SELECT * FROM cms_testimonials WHERE id='$edit_id'");
    if (mysqli_num_rows($res) > 0) {
        $edit_testimonial = mysqli_fetch_assoc($res);
    }
}

$edit_team = null;
if (isset($_GET['edit_team_member'])) {
    $edit_id = (int)$_GET['edit_team_member'];
    $res = mysqli_query($conn, "SELECT * FROM cms_team WHERE id='$edit_id'");
    if (mysqli_num_rows($res) > 0) {
        $edit_team = mysqli_fetch_assoc($res);
    }
}
?>

<div class="main-content">
    <?php include 'includes/admin-topbar.php'; ?>

    <div class="container-fluid py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="mb-1">Website Management</h4>
                <p class="text-muted mb-0">Manage content for Home, About, and Contact pages</p>
            </div>
        </div>

        <?php showMessage(); ?>

        <!-- Tabs Navigation -->
        <ul class="nav nav-tabs mb-4" id="websiteTabs">
            <li class="nav-item">
                <a class="nav-link <?php echo ($active_tab == 'home') ? 'active fw-bold' : 'text-secondary'; ?>" href="website-management.php?tab=home">
                    🏠 Home
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo ($active_tab == 'about') ? 'active fw-bold' : 'text-secondary'; ?>" href="website-management.php?tab=about">
                    ℹ️ About
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo ($active_tab == 'contact') ? 'active fw-bold' : 'text-secondary'; ?>" href="website-management.php?tab=contact">
                    📞 Contact
                </a>
            </li>
        </ul>

        <!-- Tab 1: Home -->
        <?php if ($active_tab == 'home') { ?>

            <!-- Hero Section -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title mb-0">Hero Section</h5>
                </div>
                <div class="card-body">
                    <form method="POST" enctype="multipart/form-data">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Hero Title</label>
                                <input type="text" name="title" class="form-control" value="<?php echo htmlspecialchars($hero['title'] ?? ''); ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Hero Subtitle</label>
                                <input type="text" name="subtitle" class="form-control" value="<?php echo htmlspecialchars($hero['subtitle'] ?? ''); ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Hero Image</label>
                                <input type="file" name="image" class="form-control" accept="image/*">
                                <small class="text-muted">Allowed: JPG, PNG, WEBP</small>
                            </div>
                            <div class="col-md-6">
                                <?php 
                                $hero_img_src = getCmsImage($hero['image'] ?? '');
                                if ($hero_img_src) { 
                                ?>
                                    <label class="form-label d-block">Current Hero Image</label>
                                    <img src="<?php echo $hero_img_src; ?>" alt="Hero Image" class="rounded border p-1" style="height: 60px; max-width: 150px; object-fit: contain;">
                                <?php } ?>
                            </div>
                            <div class="col-12 mt-3">
                                <button type="submit" name="update_hero" class="btn btn-primary">Save Hero Section</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Statistics -->
            <div class="card shadow-sm border-0 mb-4" id="stat-card">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Statistics</h5>
                </div>
                <div class="card-body">
                    <!-- Statistic Form (Add / Edit) -->
                    <form method="POST" class="row g-3 mb-4" id="form-stat">
                        <input type="hidden" name="stat_id" id="stat_id" value="<?php echo htmlspecialchars($edit_stat['id'] ?? ''); ?>">
                        
                        <div class="col-md-4">
                            <label class="form-label small text-muted">Title</label>
                            <input type="text" name="title" id="stat_title" class="form-control" placeholder="Statistic Title (e.g. Students Placed)" value="<?php echo htmlspecialchars($edit_stat['title'] ?? ''); ?>" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small text-muted">Number</label>
                            <input type="text" name="number" id="stat_number" class="form-control" placeholder="Number (e.g. 500+)" value="<?php echo htmlspecialchars($edit_stat['number'] ?? ''); ?>" required>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label small text-muted">Position</label>
                            <input type="number" name="sort_order" id="stat_position" class="form-control" placeholder="1" value="<?php echo htmlspecialchars($edit_stat['sort_order'] ?? '1'); ?>" min="0">
                        </div>
                        <div class="col-md-2 d-flex align-items-end">
                            <button type="submit" name="<?php echo $edit_stat ? 'update_stat' : 'add_stat'; ?>" id="stat_submit_btn" class="btn <?php echo $edit_stat ? 'btn-primary' : 'btn-success'; ?> w-100">
                                <?php echo $edit_stat ? 'Update' : 'Add Stat'; ?>
                            </button>
                            <button type="button" id="stat_cancel_btn" class="btn btn-outline-secondary ms-2 <?php echo $edit_stat ? '' : 'd-none'; ?>" onclick="resetStatForm()">
                                Cancel
                            </button>
                        </div>
                    </form>

                    <!-- Statistics List -->
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Title</th>
                                    <th>Number</th>
                                    <th width="100" class="text-center">Position</th>
                                    <th width="120" class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $stats_res = mysqli_query($conn, "SELECT * FROM cms_statistics ORDER BY sort_order ASC, id ASC");
                                if (mysqli_num_rows($stats_res) > 0) {
                                    while ($st = mysqli_fetch_assoc($stats_res)) {
                                ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($st['title']); ?></td>
                                        <td><span class="badge bg-primary fs-6"><?php echo htmlspecialchars($st['number']); ?></span></td>
                                        <td class="text-center"><?php echo htmlspecialchars($st['sort_order']); ?></td>
                                        <td class="text-center">
                                            <button type="button" 
                                                    class="btn btn-sm btn-outline-primary me-1 edit-stat-btn" 
                                                    data-bs-toggle="tooltip" 
                                                    data-bs-placement="top" 
                                                    title="Edit"
                                                    data-id="<?php echo $st['id']; ?>"
                                                    data-title="<?php echo htmlspecialchars($st['title'], ENT_QUOTES); ?>"
                                                    data-number="<?php echo htmlspecialchars($st['number'], ENT_QUOTES); ?>"
                                                    data-position="<?php echo htmlspecialchars($st['sort_order'], ENT_QUOTES); ?>">
                                                <i class="bi bi-pencil-square"></i>
                                            </button>
                                            <a href="website-management.php?tab=home&delete_stat=<?php echo $st['id']; ?>" 
                                               class="btn btn-sm btn-outline-danger" 
                                               data-bs-toggle="tooltip" 
                                               data-bs-placement="top" 
                                               title="Delete" 
                                               onclick="return confirm('Delete this statistic?')">
                                                <i class="bi bi-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php 
                                    }
                                } else { 
                                ?>
                                    <tr>
                                        <td colspan="4" class="text-center text-muted py-3">No statistics added yet.</td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Top Recruiters -->
            <div class="card shadow-sm border-0 mb-4" id="recruiter-card">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Top Recruiters</h5>
                </div>
                <div class="card-body">
                    <!-- Recruiter Form (Add / Edit) -->
                    <form method="POST" enctype="multipart/form-data" class="row g-3 mb-4" id="form-recruiter">
                        <input type="hidden" name="recruiter_id" id="recruiter_id" value="<?php echo htmlspecialchars($edit_recruiter['id'] ?? ''); ?>">
                        
                        <div class="col-md-4">
                            <label class="form-label small text-muted">Company Name</label>
                            <input type="text" name="company_name" id="recruiter_name" class="form-control" placeholder="Company Name (e.g. TCS)" value="<?php echo htmlspecialchars($edit_recruiter['company_name'] ?? ''); ?>" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small text-muted">
                                Company Logo 
                                <span id="recruiter_logo_note" class="text-muted small <?php echo $edit_recruiter ? '' : 'd-none'; ?>">(Leave blank to keep current)</span>
                            </label>
                            <input type="file" name="logo" id="recruiter_logo" class="form-control" accept="image/*" <?php echo $edit_recruiter ? '' : 'required'; ?>>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label small text-muted">Position</label>
                            <input type="number" name="sort_order" id="recruiter_position" class="form-control" placeholder="1" value="<?php echo htmlspecialchars($edit_recruiter['sort_order'] ?? '1'); ?>" min="0">
                        </div>
                        <div class="col-md-2 d-flex align-items-end">
                            <button type="submit" name="<?php echo $edit_recruiter ? 'update_recruiter' : 'add_recruiter'; ?>" id="recruiter_submit_btn" class="btn <?php echo $edit_recruiter ? 'btn-primary' : 'btn-success'; ?> w-100">
                                <?php echo $edit_recruiter ? 'Update' : 'Add Recruiter'; ?>
                            </button>
                            <button type="button" id="recruiter_cancel_btn" class="btn btn-outline-secondary ms-2 <?php echo $edit_recruiter ? '' : 'd-none'; ?>" onclick="resetRecruiterForm()">
                                Cancel
                            </button>
                        </div>
                        <div id="recruiter_preview_box" class="col-12 mt-1 <?php echo ($edit_recruiter && !empty($edit_recruiter['logo'])) ? '' : 'd-none'; ?>">
                            <small class="text-muted me-2">Current Logo:</small>
                            <img id="recruiter_preview_img" src="<?php echo ($edit_recruiter && !empty($edit_recruiter['logo'])) ? getCmsImage($edit_recruiter['logo'], 'recruiters') : ''; ?>" alt="Logo" class="border rounded p-1" style="height: 35px; max-width: 90px; object-fit: contain;">
                        </div>
                    </form>

                    <!-- Recruiters List -->
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th width="120">Logo</th>
                                    <th>Company Name</th>
                                    <th width="100" class="text-center">Position</th>
                                    <th width="120" class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $rec_res = mysqli_query($conn, "SELECT * FROM cms_recruiters ORDER BY sort_order ASC, id ASC");
                                if (mysqli_num_rows($rec_res) > 0) {
                                    while ($rc = mysqli_fetch_assoc($rec_res)) {
                                        $logo_src = getCmsImage($rc['logo'], 'recruiters');
                                ?>
                                    <tr>
                                        <td>
                                            <?php if ($logo_src) { ?>
                                                <img src="<?php echo $logo_src; ?>" alt="Logo" class="border rounded p-1" style="height: 38px; max-width: 100px; object-fit: contain;">
                                            <?php } else { ?>
                                                <span class="text-muted small">No Logo</span>
                                            <?php } ?>
                                        </td>
                                        <td><?php echo htmlspecialchars($rc['company_name']); ?></td>
                                        <td class="text-center"><?php echo htmlspecialchars($rc['sort_order']); ?></td>
                                        <td class="text-center">
                                            <button type="button" 
                                                    class="btn btn-sm btn-outline-primary me-1 edit-recruiter-btn" 
                                                    data-bs-toggle="tooltip" 
                                                    data-bs-placement="top" 
                                                    title="Edit"
                                                    data-id="<?php echo $rc['id']; ?>"
                                                    data-name="<?php echo htmlspecialchars($rc['company_name'], ENT_QUOTES); ?>"
                                                    data-position="<?php echo htmlspecialchars($rc['sort_order'], ENT_QUOTES); ?>"
                                                    data-logo="<?php echo $logo_src; ?>">
                                                <i class="bi bi-pencil-square"></i>
                                            </button>
                                            <a href="website-management.php?tab=home&delete_recruiter=<?php echo $rc['id']; ?>" 
                                               class="btn btn-sm btn-outline-danger" 
                                               data-bs-toggle="tooltip" 
                                               data-bs-placement="top" 
                                               title="Delete" 
                                               onclick="return confirm('Delete this recruiter?')">
                                                <i class="bi bi-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php 
                                    }
                                } else { 
                                ?>
                                    <tr>
                                        <td colspan="4" class="text-center text-muted py-3">No recruiters added yet.</td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Testimonials -->
            <div class="card shadow-sm border-0 mb-4" id="testimonial-card">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Testimonials</h5>
                </div>
                <div class="card-body">
                    <!-- Testimonial Form (Add / Edit) -->
                    <form method="POST" enctype="multipart/form-data" class="row g-3 mb-4" id="form-testimonial">
                        <input type="hidden" name="testimonial_id" id="testimonial_id" value="<?php echo htmlspecialchars($edit_testimonial['id'] ?? ''); ?>">
                        
                        <div class="col-md-3">
                            <label class="form-label small text-muted">Student Name</label>
                            <input type="text" name="student_name" id="test_name" class="form-control" placeholder="Student Name" value="<?php echo htmlspecialchars($edit_testimonial['student_name'] ?? ''); ?>" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label small text-muted">Course</label>
                            <input type="text" name="course" id="test_course" class="form-control" placeholder="Course (e.g. BCA)" value="<?php echo htmlspecialchars($edit_testimonial['course'] ?? ''); ?>" required>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label small text-muted">Placed Company</label>
                            <input type="text" name="company" id="test_company" class="form-control" placeholder="Company (e.g. Infosys)" value="<?php echo htmlspecialchars($edit_testimonial['company'] ?? ''); ?>" required>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label small text-muted">Rating</label>
                            <select name="rating" id="test_rating" class="form-select">
                                <?php 
                                $curr_rating = (int)($edit_testimonial['rating'] ?? 5);
                                for ($r = 5; $r >= 1; $r--) {
                                    $sel = ($curr_rating == $r) ? 'selected' : '';
                                    echo "<option value='$r' $sel>$r Stars</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label small text-muted">Position</label>
                            <input type="number" name="sort_order" id="test_position" class="form-control" placeholder="1" value="<?php echo htmlspecialchars($edit_testimonial['sort_order'] ?? '1'); ?>" min="0">
                        </div>
                        <div class="col-md-8">
                            <label class="form-label small text-muted">Student Review / Message</label>
                            <textarea name="message" id="test_message" class="form-control" rows="2" placeholder="Write student placement review..." required><?php echo htmlspecialchars($edit_testimonial['message'] ?? ''); ?></textarea>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small text-muted">
                                Student Photo 
                                <span id="test_photo_note" class="text-muted small <?php echo $edit_testimonial ? '' : 'd-none'; ?>">(Leave blank to keep current)</span>
                            </label>
                            <input type="file" name="photo" id="test_photo" class="form-control" accept="image/*">
                            <div id="test_preview_box" class="mt-1 <?php echo ($edit_testimonial && !empty($edit_testimonial['photo'])) ? '' : 'd-none'; ?>">
                                <small class="text-muted me-1">Current:</small>
                                <img id="test_preview_img" src="<?php echo ($edit_testimonial && !empty($edit_testimonial['photo'])) ? getCmsImage($edit_testimonial['photo']) : ''; ?>" alt="Photo" class="rounded-circle" style="width: 32px; height: 32px; object-fit: cover;">
                            </div>
                        </div>
                        <div class="col-12">
                            <button type="submit" name="<?php echo $edit_testimonial ? 'update_testimonial' : 'add_testimonial'; ?>" id="test_submit_btn" class="btn <?php echo $edit_testimonial ? 'btn-primary' : 'btn-success'; ?>">
                                <?php echo $edit_testimonial ? 'Update' : 'Add Testimonial'; ?>
                            </button>
                            <button type="button" id="test_cancel_btn" class="btn btn-outline-secondary ms-2 <?php echo $edit_testimonial ? '' : 'd-none'; ?>" onclick="resetTestimonialForm()">
                                Cancel
                            </button>
                        </div>
                    </form>

                    <!-- Testimonials List -->
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th width="70">Photo</th>
                                    <th>Student</th>
                                    <th>Placed Company</th>
                                    <th>Rating</th>
                                    <th>Message</th>
                                    <th width="100" class="text-center">Position</th>
                                    <th width="120" class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $test_res = mysqli_query($conn, "SELECT * FROM cms_testimonials ORDER BY sort_order ASC, id ASC");
                                if (mysqli_num_rows($test_res) > 0) {
                                    while ($t = mysqli_fetch_assoc($test_res)) {
                                        $photo_src = getCmsImage($t['photo']);
                                ?>
                                    <tr>
                                        <td>
                                            <?php if ($photo_src) { ?>
                                                <img src="<?php echo $photo_src; ?>" alt="Photo" class="rounded-circle" style="width: 42px; height: 42px; object-fit: cover;">
                                            <?php } else { ?>
                                                <div class="bg-light rounded-circle text-center pt-2" style="width: 42px; height: 42px;">
                                                    <i class="bi bi-person text-secondary"></i>
                                                </div>
                                            <?php } ?>
                                        </td>
                                        <td>
                                            <strong><?php echo htmlspecialchars($t['student_name']); ?></strong>
                                            <br><small class="text-muted"><?php echo htmlspecialchars($t['course']); ?></small>
                                        </td>
                                        <td><?php echo htmlspecialchars($t['company']); ?></td>
                                        <td>
                                            <span class="text-warning">
                                                <?php for ($i = 0; $i < (int)$t['rating']; $i++) { echo "★"; } ?>
                                            </span>
                                        </td>
                                        <td><small><?php echo htmlspecialchars($t['message']); ?></small></td>
                                        <td class="text-center"><?php echo htmlspecialchars($t['sort_order']); ?></td>
                                        <td class="text-center">
                                            <button type="button" 
                                                    class="btn btn-sm btn-outline-primary me-1 edit-testimonial-btn" 
                                                    data-bs-toggle="tooltip" 
                                                    data-bs-placement="top" 
                                                    title="Edit"
                                                    data-id="<?php echo $t['id']; ?>"
                                                    data-name="<?php echo htmlspecialchars($t['student_name'], ENT_QUOTES); ?>"
                                                    data-course="<?php echo htmlspecialchars($t['course'], ENT_QUOTES); ?>"
                                                    data-company="<?php echo htmlspecialchars($t['company'], ENT_QUOTES); ?>"
                                                    data-rating="<?php echo htmlspecialchars($t['rating'], ENT_QUOTES); ?>"
                                                    data-position="<?php echo htmlspecialchars($t['sort_order'], ENT_QUOTES); ?>"
                                                    data-message="<?php echo htmlspecialchars($t['message'], ENT_QUOTES); ?>"
                                                    data-photo="<?php echo $photo_src; ?>">
                                                <i class="bi bi-pencil-square"></i>
                                            </button>
                                            <a href="website-management.php?tab=home&delete_testimonial=<?php echo $t['id']; ?>" 
                                               class="btn btn-sm btn-outline-danger" 
                                               data-bs-toggle="tooltip" 
                                               data-bs-placement="top" 
                                               title="Delete" 
                                               onclick="return confirm('Delete this testimonial?')">
                                                <i class="bi bi-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php 
                                    }
                                } else { 
                                ?>
                                    <tr>
                                        <td colspan="7" class="text-center text-muted py-3">No testimonials added yet.</td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        <?php } ?>

        <!-- Tab 2: About -->
        <?php if ($active_tab == 'about') { ?>

            <!-- About Content -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title mb-0">About Content</h5>
                </div>
                <div class="card-body">
                    <form method="POST" enctype="multipart/form-data">
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label">Heading</label>
                                <input type="text" name="heading" class="form-control" value="<?php echo htmlspecialchars($about['heading'] ?? ''); ?>" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Description</label>
                                <textarea name="description" class="form-control" rows="5" required><?php echo htmlspecialchars($about['description'] ?? ''); ?></textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">About Section Image</label>
                                <input type="file" name="image" class="form-control" accept="image/*">
                                <small class="text-muted">Allowed: JPG, PNG, WEBP</small>
                            </div>
                            <div class="col-md-6">
                                <?php 
                                $about_img_src = getCmsImage($about['image'] ?? '');
                                if ($about_img_src) { 
                                ?>
                                    <label class="form-label d-block">Current About Image</label>
                                    <img src="<?php echo $about_img_src; ?>" alt="About Image" class="rounded border p-1" style="height: 60px; max-width: 150px; object-fit: contain;">
                                <?php } ?>
                            </div>
                            <div class="col-12 mt-3">
                                <button type="submit" name="update_about" class="btn btn-primary">Save About Content</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Placement Team -->
            <div class="card shadow-sm border-0 mb-4" id="team-card">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Placement Team</h5>
                </div>
                <div class="card-body">
                    <!-- Team Member Form (Add / Edit) -->
                    <form method="POST" enctype="multipart/form-data" class="row g-3 mb-4" id="form-team">
                        <input type="hidden" name="team_id" id="team_id" value="<?php echo htmlspecialchars($edit_team['id'] ?? ''); ?>">
                        
                        <div class="col-md-4">
                            <label class="form-label small text-muted">Member Name</label>
                            <input type="text" name="name" id="team_name" class="form-control" placeholder="e.g. Prof. Shruti Parashar" value="<?php echo htmlspecialchars($edit_team['name'] ?? ''); ?>" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small text-muted">Designation</label>
                            <input type="text" name="designation" id="team_designation" class="form-control" placeholder="e.g. Dean - Training & Placement" value="<?php echo htmlspecialchars($edit_team['designation'] ?? ''); ?>" required>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label small text-muted">Position</label>
                            <input type="number" name="sort_order" id="team_position" class="form-control" placeholder="1" value="<?php echo htmlspecialchars($edit_team['sort_order'] ?? '1'); ?>" min="0">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label small text-muted">
                                Photo 
                                <span id="team_photo_note" class="text-muted small <?php echo $edit_team ? '' : 'd-none'; ?>">(Leave blank to keep)</span>
                            </label>
                            <input type="file" name="image" id="team_photo" class="form-control" accept="image/*">
                        </div>
                        <div id="team_preview_box" class="col-12 mt-1 <?php echo ($edit_team && !empty($edit_team['image'])) ? '' : 'd-none'; ?>">
                            <small class="text-muted me-1">Current Photo:</small>
                            <img id="team_preview_img" src="<?php echo ($edit_team && !empty($edit_team['image'])) ? getCmsImage($edit_team['image'], 'team') : ''; ?>" alt="Member Photo" class="rounded-circle" style="width: 35px; height: 35px; object-fit: cover;">
                        </div>
                        <div class="col-12">
                            <button type="submit" name="<?php echo $edit_team ? 'update_team_member' : 'add_team_member'; ?>" id="team_submit_btn" class="btn <?php echo $edit_team ? 'btn-primary' : 'btn-success'; ?>">
                                <?php echo $edit_team ? 'Update' : 'Add Team Member'; ?>
                            </button>
                            <button type="button" id="team_cancel_btn" class="btn btn-outline-secondary ms-2 <?php echo $edit_team ? '' : 'd-none'; ?>" onclick="resetTeamForm()">
                                Cancel
                            </button>
                        </div>
                    </form>

                    <!-- Team Members List -->
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th width="70">Photo</th>
                                    <th>Name</th>
                                    <th>Designation</th>
                                    <th width="100" class="text-center">Position</th>
                                    <th width="120" class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $team_res = mysqli_query($conn, "SELECT * FROM cms_team ORDER BY sort_order ASC, id ASC");
                                if (mysqli_num_rows($team_res) > 0) {
                                    while ($tm = mysqli_fetch_assoc($team_res)) {
                                        $tm_photo_src = getCmsImage($tm['image'], 'team');
                                ?>
                                    <tr>
                                        <td>
                                            <?php if ($tm_photo_src) { ?>
                                                <img src="<?php echo $tm_photo_src; ?>" alt="Member Photo" class="rounded-circle" style="width: 42px; height: 42px; object-fit: cover;">
                                            <?php } else { ?>
                                                <div class="bg-light rounded-circle text-center pt-2" style="width: 42px; height: 42px;">
                                                    <i class="bi bi-person text-secondary"></i>
                                                </div>
                                            <?php } ?>
                                        </td>
                                        <td><strong><?php echo htmlspecialchars($tm['name']); ?></strong></td>
                                        <td><?php echo htmlspecialchars($tm['designation']); ?></td>
                                        <td class="text-center"><?php echo htmlspecialchars($tm['sort_order']); ?></td>
                                        <td class="text-center">
                                            <button type="button" 
                                                    class="btn btn-sm btn-outline-primary me-1 edit-team-btn" 
                                                    data-bs-toggle="tooltip" 
                                                    data-bs-placement="top" 
                                                    title="Edit"
                                                    data-id="<?php echo $tm['id']; ?>"
                                                    data-name="<?php echo htmlspecialchars($tm['name'], ENT_QUOTES); ?>"
                                                    data-designation="<?php echo htmlspecialchars($tm['designation'], ENT_QUOTES); ?>"
                                                    data-position="<?php echo htmlspecialchars($tm['sort_order'], ENT_QUOTES); ?>"
                                                    data-photo="<?php echo $tm_photo_src; ?>">
                                                <i class="bi bi-pencil-square"></i>
                                            </button>
                                            <a href="website-management.php?tab=about&delete_team_member=<?php echo $tm['id']; ?>" 
                                               class="btn btn-sm btn-outline-danger" 
                                               data-bs-toggle="tooltip" 
                                               data-bs-placement="top" 
                                               title="Delete" 
                                               onclick="return confirm('Delete this team member?')">
                                                <i class="bi bi-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php 
                                    }
                                } else { 
                                ?>
                                    <tr>
                                        <td colspan="5" class="text-center text-muted py-3">No team members added yet.</td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        <?php } ?>

        <!-- Tab 3: Contact -->
        <?php if ($active_tab == 'contact') { ?>

            <!-- Contact Details Form -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title mb-0">Contact Details</h5>
                    <small class="text-muted">Manage website contact info, Google map, and social media links</small>
                </div>
                <div class="card-body">
                    <form method="POST">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Phone Number</label>
                                <input type="text" name="phone" class="form-control" value="<?php echo htmlspecialchars($contact['phone'] ?? ''); ?>" placeholder="+91 98765 43210">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Email Address</label>
                                <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($contact['email'] ?? ''); ?>" placeholder="placement@example.com">
                            </div>
                            <div class="col-12">
                                <label class="form-label">College / Office Address</label>
                                <textarea name="address" class="form-control" rows="3" placeholder="Enter complete address"><?php echo htmlspecialchars($contact['address'] ?? ''); ?></textarea>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Google Map Embed Link</label>
                                <textarea name="google_map" class="form-control" rows="3" placeholder="Enter Google Maps embed URL or iframe code"><?php echo htmlspecialchars($contact['google_map'] ?? ''); ?></textarea>
                                <small class="text-muted">Paste either the full &lt;iframe&gt; code or the map URL.</small>
                            </div>

                            <div class="col-12 mt-4">
                                <h6 class="text-secondary border-bottom pb-2">Social Links</h6>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label"><i class="bi bi-facebook text-primary me-1"></i> Facebook</label>
                                <input type="text" name="facebook" class="form-control" value="<?php echo htmlspecialchars($contact['facebook'] ?? ''); ?>" placeholder="https://facebook.com/yourpage">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label"><i class="bi bi-instagram text-danger me-1"></i> Instagram</label>
                                <input type="text" name="instagram" class="form-control" value="<?php echo htmlspecialchars($contact['instagram'] ?? ''); ?>" placeholder="https://instagram.com/yourpage">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label"><i class="bi bi-linkedin text-primary me-1"></i> LinkedIn</label>
                                <input type="text" name="linkedin" class="form-control" value="<?php echo htmlspecialchars($contact['linkedin'] ?? ''); ?>" placeholder="https://linkedin.com/company/yourpage">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label"><i class="bi bi-youtube text-danger me-1"></i> YouTube</label>
                                <input type="text" name="youtube" class="form-control" value="<?php echo htmlspecialchars($contact['youtube'] ?? ''); ?>" placeholder="https://youtube.com/@yourchannel">
                            </div>

                            <div class="col-12 mt-4">
                                <button type="submit" name="update_contact" class="btn btn-primary">Save Contact Details</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        <?php } ?>

    </div>
</div>

<script>
// Edit Statistic
function editStat(id, title, number, position) {
    document.getElementById('stat_id').value = id;
    document.getElementById('stat_title').value = title;
    document.getElementById('stat_number').value = number;
    document.getElementById('stat_position').value = position;

    var btn = document.getElementById('stat_submit_btn');
    btn.name = 'update_stat';
    btn.innerText = 'Update';
    btn.className = 'btn btn-primary w-100';

    document.getElementById('stat_cancel_btn').classList.remove('d-none');

    var form = document.getElementById('form-stat');
    if (form) {
        form.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }
    document.getElementById('stat_title').focus();
}

function resetStatForm() {
    document.getElementById('stat_id').value = '';
    document.getElementById('stat_title').value = '';
    document.getElementById('stat_number').value = '';
    document.getElementById('stat_position').value = '1';

    var btn = document.getElementById('stat_submit_btn');
    btn.name = 'add_stat';
    btn.innerText = 'Add Stat';
    btn.className = 'btn btn-success w-100';

    document.getElementById('stat_cancel_btn').classList.add('d-none');
}

// Edit Recruiter
function editRecruiter(id, name, position, logoSrc) {
    document.getElementById('recruiter_id').value = id;
    document.getElementById('recruiter_name').value = name;
    document.getElementById('recruiter_position').value = position;
    document.getElementById('recruiter_logo').removeAttribute('required');
    document.getElementById('recruiter_logo_note').classList.remove('d-none');

    var btn = document.getElementById('recruiter_submit_btn');
    btn.name = 'update_recruiter';
    btn.innerText = 'Update';
    btn.className = 'btn btn-primary w-100';

    document.getElementById('recruiter_cancel_btn').classList.remove('d-none');

    var previewBox = document.getElementById('recruiter_preview_box');
    var previewImg = document.getElementById('recruiter_preview_img');
    if (logoSrc) {
        previewImg.src = logoSrc;
        previewBox.classList.remove('d-none');
    } else {
        previewBox.classList.add('d-none');
    }

    var form = document.getElementById('form-recruiter');
    if (form) {
        form.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }
    document.getElementById('recruiter_name').focus();
}

function resetRecruiterForm() {
    document.getElementById('recruiter_id').value = '';
    document.getElementById('recruiter_name').value = '';
    document.getElementById('recruiter_position').value = '1';
    document.getElementById('recruiter_logo').value = '';
    document.getElementById('recruiter_logo').setAttribute('required', 'required');
    document.getElementById('recruiter_logo_note').classList.add('d-none');
    document.getElementById('recruiter_preview_box').classList.add('d-none');

    var btn = document.getElementById('recruiter_submit_btn');
    btn.name = 'add_recruiter';
    btn.innerText = 'Add Recruiter';
    btn.className = 'btn btn-success w-100';

    document.getElementById('recruiter_cancel_btn').classList.add('d-none');
}

// Edit Testimonial
function editTestimonial(id, name, course, company, rating, position, message, photoSrc) {
    document.getElementById('testimonial_id').value = id;
    document.getElementById('test_name').value = name;
    document.getElementById('test_course').value = course;
    document.getElementById('test_company').value = company;
    document.getElementById('test_rating').value = rating;
    document.getElementById('test_position').value = position;
    document.getElementById('test_message').value = message;
    document.getElementById('test_photo_note').classList.remove('d-none');

    var btn = document.getElementById('test_submit_btn');
    btn.name = 'update_testimonial';
    btn.innerText = 'Update';
    btn.className = 'btn btn-primary';

    document.getElementById('test_cancel_btn').classList.remove('d-none');

    var previewBox = document.getElementById('test_preview_box');
    var previewImg = document.getElementById('test_preview_img');
    if (photoSrc) {
        previewImg.src = photoSrc;
        previewBox.classList.remove('d-none');
    } else {
        previewBox.classList.add('d-none');
    }

    var form = document.getElementById('form-testimonial');
    if (form) {
        form.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }
    document.getElementById('test_name').focus();
}

function resetTestimonialForm() {
    document.getElementById('testimonial_id').value = '';
    document.getElementById('test_name').value = '';
    document.getElementById('test_course').value = '';
    document.getElementById('test_company').value = '';
    document.getElementById('test_rating').value = '5';
    document.getElementById('test_position').value = '1';
    document.getElementById('test_message').value = '';
    document.getElementById('test_photo').value = '';
    document.getElementById('test_photo_note').classList.add('d-none');
    document.getElementById('test_preview_box').classList.add('d-none');

    var btn = document.getElementById('test_submit_btn');
    btn.name = 'add_testimonial';
    btn.innerText = 'Add Testimonial';
    btn.className = 'btn btn-success';

    document.getElementById('test_cancel_btn').classList.add('d-none');
}

// Edit Team Member
function editTeam(id, name, designation, position, photoSrc) {
    document.getElementById('team_id').value = id;
    document.getElementById('team_name').value = name;
    document.getElementById('team_designation').value = designation;
    document.getElementById('team_position').value = position;
    document.getElementById('team_photo_note').classList.remove('d-none');

    var btn = document.getElementById('team_submit_btn');
    btn.name = 'update_team_member';
    btn.innerText = 'Update';
    btn.className = 'btn btn-primary';

    document.getElementById('team_cancel_btn').classList.remove('d-none');

    var previewBox = document.getElementById('team_preview_box');
    var previewImg = document.getElementById('team_preview_img');
    if (photoSrc) {
        previewImg.src = photoSrc;
        previewBox.classList.remove('d-none');
    } else {
        previewBox.classList.add('d-none');
    }

    var form = document.getElementById('form-team');
    if (form) {
        form.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }
    document.getElementById('team_name').focus();
}

function resetTeamForm() {
    document.getElementById('team_id').value = '';
    document.getElementById('team_name').value = '';
    document.getElementById('team_designation').value = '';
    document.getElementById('team_position').value = '1';
    document.getElementById('team_photo').value = '';
    document.getElementById('team_photo_note').classList.add('d-none');
    document.getElementById('team_preview_box').classList.add('d-none');

    var btn = document.getElementById('team_submit_btn');
    btn.name = 'add_team_member';
    btn.innerText = 'Add Team Member';
    btn.className = 'btn btn-success';

    document.getElementById('team_cancel_btn').classList.add('d-none');
}

// Attach event listeners & tooltips
document.addEventListener('DOMContentLoaded', function() {
    // Initialize tooltips
    if (typeof bootstrap !== 'undefined' && bootstrap.Tooltip) {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    }

    // Statistics Edit Click
    document.querySelectorAll('.edit-stat-btn').forEach(function(btn) {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            editStat(
                this.getAttribute('data-id'),
                this.getAttribute('data-title'),
                this.getAttribute('data-number'),
                this.getAttribute('data-position')
            );
        });
    });

    // Recruiters Edit Click
    document.querySelectorAll('.edit-recruiter-btn').forEach(function(btn) {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            editRecruiter(
                this.getAttribute('data-id'),
                this.getAttribute('data-name'),
                this.getAttribute('data-position'),
                this.getAttribute('data-logo')
            );
        });
    });

    // Testimonials Edit Click
    document.querySelectorAll('.edit-testimonial-btn').forEach(function(btn) {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            editTestimonial(
                this.getAttribute('data-id'),
                this.getAttribute('data-name'),
                this.getAttribute('data-course'),
                this.getAttribute('data-company'),
                this.getAttribute('data-rating'),
                this.getAttribute('data-position'),
                this.getAttribute('data-message'),
                this.getAttribute('data-photo')
            );
        });
    });

    // Team Edit Click
    document.querySelectorAll('.edit-team-btn').forEach(function(btn) {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            editTeam(
                this.getAttribute('data-id'),
                this.getAttribute('data-name'),
                this.getAttribute('data-designation'),
                this.getAttribute('data-position'),
                this.getAttribute('data-photo')
            );
        });
    });
});
</script>

<?php include 'includes/admin-footer.php'; ?>
