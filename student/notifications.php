<?php
include 'includes/student-header.php';
include 'includes/student-sidebar.php';

/* Mark as Read */
if (isset($_GET['read'])) {
    $id = (int)$_GET['read'];

    mysqli_query($conn, "
        UPDATE notifications
        SET is_read='1'
        WHERE id='$id'
        AND user_type='Student'
        AND user_id='" . $_SESSION['student_id'] . "'
    ");

    header("Location: notifications.php");
    exit();
}
?>

<div class="main-content">
    <?php include 'includes/student-topbar.php'; ?>

    <div class="container-fluid py-4">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white">
                <h4 class="mb-0">Notifications</h4>
            </div>

            <div class="card-body">
                <?php
                $query = mysqli_query($conn, "
                    SELECT *
                    FROM notifications
                    WHERE user_type='Student'
                    AND user_id='" . $_SESSION['student_id'] . "'
                    ORDER BY created_at DESC
                ");

                if (mysqli_num_rows($query) > 0) {
                    while ($row = mysqli_fetch_assoc($query)) {
                ?>
                        <div class="notification-item <?php echo ($row['is_read'] == 0) ? 'unread' : ''; ?>">
                            <div>
                                <h5><?php echo htmlspecialchars($row['title']); ?></h5>
                                <p><?php echo htmlspecialchars($row['message']); ?></p>
                                <small><?php echo date("d M Y h:i A", strtotime($row['created_at'])); ?></small>
                            </div>

                            <div>
                                <?php if ($row['is_read'] == 0) { ?>
                                    <a href="?read=<?php echo $row['id']; ?>" class="btn btn-sm btn-primary">
                                        Mark as Read
                                    </a>
                                <?php } else { ?>
                                    <span class="badge bg-success">Read</span>
                                <?php } ?>
                            </div>
                        </div>
                    <?php
                    }
                } else {
                    ?>
                    <div class="alert alert-info">
                        No notifications found.
                    </div>
                <?php
                }
                ?>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/student-footer.php'; ?>