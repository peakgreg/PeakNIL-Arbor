<?php
global $db;

// Conditional header
if (isset($_SESSION['uuid'])) {
    require_once MODULES_PATH . '/common/views/auth/view.header.php';
} else {
    require_once MODULES_PATH . '/common/views/public/view.header.php';
}

$user['uuid'] = $_GET['id'];
$user["profile_image_url"] = $profile['profile_image_path'];
$user["school_thumbnail_path"] = $profile['school_marketplace_logo_path'];
$user['school_id'] = $profile['school_nanoid'];
$user['school_name'] = $profile['school_name'];
$user["first_name"] = $profile['first_name'];
$user["last_name"] = $profile['last_name'];
$user['verified'] = $profile['flags']['verified'];

// Initialize social media flags and follower counts
$user['instagram_set'] = !empty($profile['social_media']['instagram_username']) ? 'true' : 'false';
$user['x_set'] = !empty($profile['social_media']['x_username']) ? 'true' : 'false';
$user['tiktok_set'] = !empty($profile['social_media']['tiktok_username']) ? 'true' : 'false';
$user['facebook_set'] = !empty($profile['social_media']['facebook_username']) ? 'true' : 'false';
$user['linkedin_set'] = !empty($profile['social_media']['linkedin_username']) ? 'true' : 'false';
$user['x_follower_count'] = $profile['x_stats']['x_follower_count'];
$user['instagram_follower_count'] = $profile['instagram_stats']['instagram_follower_count'];
$user['tiktok_follower_count'] = $profile['tiktok_stats']['tiktok_follower_count'];
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
    <a href = "/profile?id=<?= $_GET['id'] ?>"><?php include MODULES_PATH . '/marketplace/views/cards/view.card_' . $profile['card_id'] . '.php'; ?></a>
    <div class = "mt-4 mb-2 fs-6" style = "font-weight: 600;">Profile</div>
    <div class = "profile_description">
      <?= $profile['profile_description'] ?>
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
