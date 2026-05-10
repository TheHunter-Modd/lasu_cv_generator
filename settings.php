<?php
require_once 'includes/config_session.inc.php';
require_once 'includes/settings_model.inc.php';
require_once 'includes/settings_view.inc.php';
require_once 'includes/dbh.inc.php';

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    die();
}

// Fetch fresh user data
 $user = get_user_by_id($pdo, $_SESSION["user_id"]);

if (!$user) {
    header("Location: includes/logout.inc.php");
    die();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings - LASU CV</title>
    <link rel="stylesheet" href="css/dashboard.css">
    <link rel="stylesheet" href="css/settings.css">
    <link rel="stylesheet" href="css/mobile-responsive.css">
</head>
<body>

<div class="dashboard">

    <!-- OVERLAY -->
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

    <!-- SIDEBAR -->
    <div class="sidebar" id="appSidebar">
        <h2 class="logo">
            <img src="assets/file-text.svg">
            <span>lasucv.</span>
        </h2>
        <ul class="menu">
            <li>
                <a href="dashboard.php">
                    <img src="assets/layout-dashboard.svg" alt="">
                    <span>Dashboard</span>
                </a>
            </li>
            <li>
                <a href="builder.php">
                    <img src="assets/file-pen.svg" alt="">
                    <span>Builder</span>
                </a>
            </li>
            <li>
                <a href="preview.php">
                    <img src="assets/eye.svg" alt="">
                    <span>Preview CV</span>
                </a>
            </li>
        </ul>
        <a href="includes/logout.inc.php" class="logout">
            <img src="assets/log-out.svg" alt="">
            <span>Logout</span>
        </a>
    </div>

    <!-- MAIN -->
    <div class="main">

        <!-- HEADER -->
        <div class="header-area">
            <div class="top-nav">

                <button class="mobile-menu-btn" id="hamburgerBtn"
                        onclick="toggleSidebar()"
                        aria-label="Open navigation menu"
                        aria-expanded="false">
                    <span></span><span></span><span></span>
                </button>

                <div class="tabs">
                    <button onclick="window.location.href='dashboard.php'">Dashboard</button>
                    <button class="active">Settings</button>
                </div>

                <div class="actions">
                    <div class="icons">
                        <span><img src="assets/settings.svg" alt="Settings" style="opacity:1;filter:none;"></span>
                    </div>
                </div>

            </div>

            <div class="page-header">
                <p class="sub">Manage your account</p>
                <h1>Settings</h1>
            </div>
        </div>

        <!-- CONTENT -->
        <div class="content">

            <!-- Success / Error Messages -->
            <?php show_settings_messages(); ?>

            <!-- ═══════════════════════════════════════════ -->
            <!-- AVATAR SECTION                            -->
            <!-- ═══════════════════════════════════════════ -->
            <div class="settings-card">
                <div class="settings-card-header">
                    <h3>Profile Photo</h3>
                </div>
                <div class="avatar-section">
                    <div class="avatar-preview">
                        <?php if (!empty($user["avatar"])): ?>
                            <img src="<?php echo htmlspecialchars($user["avatar"]); ?>" alt="Avatar" class="avatar-img">
                        <?php else: ?>
                            <div class="avatar-placeholder-big">
                                <?php echo strtoupper(substr($user["first_name"], 0, 1)); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="avatar-info">
                        <p class="avatar-name"><?php echo htmlspecialchars($user["first_name"] . " " . $user["last_name"]); ?></p>
                        <p class="avatar-matric"><?php echo htmlspecialchars($user["matric_number"]); ?></p>
                        <form action="includes/settings.inc.php" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="action" value="avatar">
                            <label for="avatar-upload" class="avatar-upload-btn">Change Photo</label>
                            <input type="file" id="avatar-upload" name="avatar" accept="image/png,image/jpeg,image/gif,image/webp" hidden>
                            <button type="submit" class="avatar-save-btn" id="avatarSaveBtn" style="display:none;">Upload</button>
                        </form>
                        <small>JPG, PNG or GIF. Max 2MB.</small>
                    </div>
                </div>
            </div>

            <!-- ═══════════════════════════════════════════ -->
            <!-- PROFILE INFO SECTION                      -->
            <!-- ═══════════════════════════════════════════ -->
            <div class="settings-card">
                <div class="settings-card-header">
                    <h3>Personal Information</h3>
                    <p>Update your personal details.</p>
                </div>
                <form action="includes/settings.inc.php" method="post" class="settings-form">
                    <input type="hidden" name="action" value="profile">
                    <div class="form-row">
                        <div class="form-field">
                            <label>First Name</label>
                            <input type="text" name="first_name" value="<?php echo htmlspecialchars($user["first_name"]); ?>" required>
                        </div>
                        <div class="form-field">
                            <label>Last Name</label>
                            <input type="text" name="last_name" value="<?php echo htmlspecialchars($user["last_name"]); ?>" required>
                        </div>
                    </div>
                    <div class="form-field">
                        <label>Matric Number</label>
                        <input type="text" value="<?php echo htmlspecialchars($user["matric_number"]); ?>" disabled>
                        <small>Matric number cannot be changed.</small>
                    </div>
                    <button type="submit" class="settings-btn">Save Changes</button>
                </form>
            </div>

            <!-- ═══════════════════════════════════════════ -->
            <!-- ACCOUNT INFO SECTION                      -->
            <!-- ═══════════════════════════════════════════ -->
            <div class="settings-card">
                <div class="settings-card-header">
                    <h3>Account Information</h3>
                    <p>Manage your email address.</p>
                </div>
                <form action="includes/settings.inc.php" method="post" class="settings-form">
                    <input type="hidden" name="action" value="email">
                    <div class="form-field">
                        <label>Email Address</label>
                        <input type="email" name="email" value="<?php echo htmlspecialchars($user["email"]); ?>" required>
                    </div>
                    <button type="submit" class="settings-btn">Update Email</button>
                </form>
            </div>

            <!-- ═══════════════════════════════════════════ -->
            <!-- CHANGE PASSWORD SECTION                   -->
            <!-- ═══════════════════════════════════════════ -->
            <div class="settings-card">
                <div class="settings-card-header">
                    <h3>Change Password</h3>
                    <p>Ensure your account stays secure.</p>
                </div>
                <form action="includes/settings.inc.php" method="post" class="settings-form">
                    <input type="hidden" name="action" value="password">
                    <div class="form-field">
                        <label>Current Password</label>
                        <input type="password" name="current_pwd" placeholder="Enter current password" required>
                    </div>
                    <div class="form-row">
                        <div class="form-field">
                            <label>New Password</label>
                            <input type="password" name="new_pwd" placeholder="Min 6 characters" required>
                        </div>
                        <div class="form-field">
                            <label>Confirm New Password</label>
                            <input type="password" name="confirm_pwd" placeholder="Re-enter new password" required>
                        </div>
                    </div>
                    <button type="submit" class="settings-btn">Update Password</button>
                </form>
            </div>

            <!-- ═══════════════════════════════════════════ -->
            <!-- DANGER ZONE                               -->
            <!-- ═══════════════════════════════════════════ -->
            <div class="settings-card danger-card">
                <div class="settings-card-header">
                    <h3>Danger Zone</h3>
                    <p>Irreversible actions.</p>
                </div>
                <div class="danger-content">
                    <div>
                        <strong>Delete Account</strong>
                        <p>Permanently remove your account and all data. This cannot be undone.</p>
                    </div>
                    <button class="danger-btn" onclick="alert('Account deletion is disabled in demo mode.')">Delete Account</button>
                </div>
            </div>

        </div><!-- /.content -->
    </div><!-- /.main -->
</div><!-- /.dashboard -->

<script>
function toggleSidebar() {
    var sidebar = document.getElementById('appSidebar');
    var overlay = document.getElementById('sidebarOverlay');
    var btn     = document.getElementById('hamburgerBtn');
    var isOpen = sidebar.classList.toggle('open');
    overlay.classList.toggle('open');
    if (btn) { btn.classList.toggle('open', isOpen); btn.setAttribute('aria-expanded', isOpen ? 'true' : 'false'); }
    document.body.style.overflow = isOpen ? 'hidden' : '';
}

// Show upload button when a file is selected
document.addEventListener('DOMContentLoaded', function() {
    var fileInput = document.getElementById('avatar-upload');
    var saveBtn = document.getElementById('avatarSaveBtn');
    if (fileInput && saveBtn) {
        fileInput.addEventListener('change', function() {
            if (this.files && this.files.length > 0) {
                saveBtn.style.display = 'inline-block';
            } else {
                saveBtn.style.display = 'none';
            }
        });
    }
});
</script>

</body>
</html>