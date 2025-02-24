<?php
global $db;

// Conditional header
if (isset($_SESSION['uuid'])) {
    require_once MODULES_PATH . '/common/views/auth/view.header.php';
} else {
    require_once MODULES_PATH . '/common/views/public/view.header.php';
}
?>

<!-- Add custom CSS for cover photo and profile image -->
<style>
    body {
        margin-left: 0;
        margin-right: 0;
        padding-left: 0;
        padding-right: 0;
        overflow-x: hidden;
    }
    .cover-photo-wrapper {
        width: 100vw;
        position: relative;
        left: 50%;
        right: 50%;
        margin-left: -50vw;
        margin-right: -50vw;
    }
    .cover-photo {
        width: 100%;
        height: 300px;
        background-image: url('https://cdn.peaknil.com/public/default-cover-image.jpg');
        background-size: cover;
        background-position: center;
        position: relative;
    }
    .profile-image {
        position: absolute;
        bottom: -75px;
        left: 50px;
        width: 200px;
        height: 200px;
        border-radius: 50%;
        border: 5px solid #fff;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        background-image: url('https://cdn.peaknil.com/public/default-profile-image.png');
        background-size: cover;
        background-position: center;
    }
    .profile-info {
        position: absolute;
        bottom: 50px;
        left: 280px;
        z-index: 1;
    }
    .profile-name {
        font-size: 2.25rem;
        font-weight: bold;
        margin: 0;
        color: #fff;
        text-shadow: 0 2px 4px rgba(0,0,0,0.5);
    }

    /* Adjust for mobile displays */
    @media (max-width: 575px) {
        .profile-image {
            left: 20px;
            width: 160px;
            height: 160px;
            bottom: -60px;
        }
        .profile-info {
            bottom: 40px;
            left: 200px;
        }
        .profile-name {
            font-size: 1.75rem;
        }
    }
</style>

<!-- Cover photo with profile image and name -->
<div class="cover-photo-wrapper">
    <div class="cover-photo">
        <div class="profile-image"></div>
        <div class="profile-info">
            <h1 class="profile-name">
                <?php echo htmlspecialchars($profile['first_name'] . ' ' . $profile['last_name']); ?>
            </h1>
        </div>
    </div>
</div>

<script type="text/javascript" src="/assets/modules/profile/js/profile.js"></script>
<?php 
// Conditional footer
if (isset($_SESSION['uuid'])) {
    require_once MODULES_PATH . '/common/views/auth/view.footer.php';
} else {
    require_once MODULES_PATH . '/common/views/public/view.footer.php';
}
?>
