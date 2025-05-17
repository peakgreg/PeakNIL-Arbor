<?php
global $db;

// Conditional header
if (isset($_SESSION['uuid'])) {
    require_once MODULES_PATH . '/common/views/auth/view.header.php';
} else {
    require_once MODULES_PATH . '/common/views/public/view.header.php';
}

// Initialize user array with default values and safely extract profile data
$user = [
    'uuid' => $_GET['id'],
    'profile_image_url' => isset($profile['profile_image_path']) ? $profile['profile_image_path'] : '',
    'school_thumbnail_path' => isset($profile['school_marketplace_logo_path']) ? $profile['school_marketplace_logo_path'] : '',
    'school_id' => isset($profile['school_nanoid']) ? $profile['school_nanoid'] : '',
    'school_name' => isset($profile['school_name']) ? $profile['school_name'] : '',
    'first_name' => isset($profile['first_name']) ? $profile['first_name'] : '',
    'last_name' => isset($profile['last_name']) ? $profile['last_name'] : '',
    'verified' => isset($profile['flags']) && isset($profile['flags']['verified']) ? $profile['flags']['verified'] : false,
    
    // Initialize social media flags with safe defaults
    'instagram_set' => 'false',
    'x_set' => 'false',
    'tiktok_set' => 'false',
    'facebook_set' => 'false',
    'linkedin_set' => 'false',
    
    // Initialize follower counts with safe defaults
    'x_follower_count' => 0,
    'instagram_follower_count' => 0,
    'tiktok_follower_count' => 0
];

// Safely set social media flags if data exists
if (isset($profile['social_media'])) {
    $user['instagram_set'] = !empty($profile['social_media']['instagram_username']) ? 'true' : 'false';
    $user['x_set'] = !empty($profile['social_media']['x_username']) ? 'true' : 'false';
    $user['tiktok_set'] = !empty($profile['social_media']['tiktok_username']) ? 'true' : 'false';
    $user['facebook_set'] = !empty($profile['social_media']['facebook_username']) ? 'true' : 'false';
    $user['linkedin_set'] = !empty($profile['social_media']['linkedin_username']) ? 'true' : 'false';
}

// Safely set follower counts if stats exist
if (isset($profile['x_stats']) && isset($profile['x_stats']['x_follower_count'])) {
    $user['x_follower_count'] = $profile['x_stats']['x_follower_count'];
}

if (isset($profile['instagram_stats']) && isset($profile['instagram_stats']['instagram_follower_count'])) {
    $user['instagram_follower_count'] = $profile['instagram_stats']['instagram_follower_count'];
}

if (isset($profile['tiktok_stats']) && isset($profile['tiktok_stats']['tiktok_follower_count'])) {
    $user['tiktok_follower_count'] = $profile['tiktok_stats']['tiktok_follower_count'];
}
?>

<link rel="stylesheet" href="/assets/modules/marketplace/css/card_flip.css">
<link rel="stylesheet" href="/assets/modules/marketplace/css/card_1.css">
<link rel="stylesheet" href="/assets/modules/marketplace/css/card_2.css">

<style>
  .profile_description {
    font-size: 0.95rem;
    font-weight: 400;
    line-height: 1.70;
  }
  .tags {
    display: inline-block; 
    padding: 4px 10px; 
    margin: 0px 5px 8px 0px; 
    border: 1.5px solid #bbb; 
    border-radius: 5px;
    font-size: 0.85rem;
    font-weight: 600;
  }
</style>

<div class = "row m-0 ps-2 pe-2 pt-4">
  <div class = "col-xxl-3 col-xl-3 col-lg-4 col-md-5 col-sm-12 col-12">
    <a href = "/profile?id=<?= $_GET['id'] ?>">
    <?php 
    // Check if card_id exists and the card file exists before including it
    if (isset($profile['card_id']) && !empty($profile['card_id'])) {
        $cardFile = MODULES_PATH . '/marketplace/views/cards/view.card_' . $profile['card_id'] . '.php';
        if (file_exists($cardFile)) {
            include $cardFile;
        } else {
            // Fallback if card file doesn't exist
            echo '<div class="card" style="width: 100%; height: 300px; background-color: #f8f9fa; display: flex; align-items: center; justify-content: center; border-radius: 8px;">
                <div class="text-center">
                    <div style="font-size: 3rem; color: #adb5bd;"><i class="bi bi-person-circle"></i></div>
                    <div style="color: #6c757d; font-weight: 500;">Profile Card</div>
                </div>
            </div>';
        }
    } else {
        // Fallback if no card_id
        echo '<div class="card" style="width: 100%; height: 300px; background-color: #f8f9fa; display: flex; align-items: center; justify-content: center; border-radius: 8px;">
            <div class="text-center">
                <div style="font-size: 3rem; color: #adb5bd;"><i class="bi bi-person-circle"></i></div>
                <div style="color: #6c757d; font-weight: 500;">Profile Card</div>
            </div>
        </div>';
    }
    ?>
    </a>
    <div class = "mt-4 mb-2 fs-6" style = "font-weight: 600;">Profile</div>
    <div class = "profile_description">
      <?= isset($profile['profile_description']) ? $profile['profile_description'] : '' ?>
    </div>
    <div class = "mt-4 mb-5">
    <?php
    foreach ($tagsArray as $tag) {
        echo '<div class = "tags">' . htmlspecialchars($tag) . '</div>';
    }
    ?>
    </div>
  </div>
  <div class="col-xxl-9 col-xl-9 col-lg-8 col-md-7 col">
    <?php
      include MODULES_PATH . '/profile/views/view.nil.php';
    ?>
  </div>
</div>

<pre style = "margin-top: 1000px;">
<?php
print_r($profile);
?>
</pre>

<script type="text/javascript" src="/assets/modules/marketplace/js/card_flip.js"></script>
<script type="text/javascript" src="/assets/modules/profile/js/profile.js"></script>
<?php 
// Conditional footer
if (isset($_SESSION['uuid'])) {
    require_once MODULES_PATH . '/common/views/auth/view.footer.php';
} else {
    require_once MODULES_PATH . '/common/views/public/view.footer.php';
}
?>
