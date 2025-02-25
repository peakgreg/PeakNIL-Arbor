<?php
global $db;

// Include the file inclusion helper functions
require_once MODULES_PATH . '/common/functions/include_functions.php';

// Include header based on authentication status
include_header(isset($_SESSION['uuid']));

// Include common components
include_component('browse-by-menu');
include_component('product-types-horizontal-scroll');
?>
<link rel="stylesheet" href="/assets/modules/marketplace/css/marketplace.css">
<link rel="stylesheet" href="/assets/modules/marketplace/css/card_flip.css">
<link rel="stylesheet" href="/assets/modules/marketplace/css/card_1.css">
<link rel="stylesheet" href="/assets/modules/marketplace/css/card_2.css">


<div class="container-fluid pt-3">
  <div class="row">
    <?php // MARK: Cards
    foreach ($users as $user) {
      $school_logo = "https://peaknil.s3-us-east-2.amazonaws.com/assets/images/teams/logos/50x50-light-mode/{$user['school_id']}.png";
      $school_name = $user['school_name'];
      $school_mascot = $user['school_mascot'];
    ?>
    <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-4 col-sm-6 col-6 mb-3" style="padding: 6px;">
      <a href = "/profile?id=<?= $user['uuid'] ?>">
        <?php
          // Create a card placeholder if the card file is not found
          $card_placeholder = '<div style="border:1px solid #ddd;padding:10px;text-align:center;background:#f8f8f8;">
                                <p>Card template not found</p>
                                <p>ID: ' . htmlspecialchars($user['card_id']) . '</p>
                                <p>Name: ' . htmlspecialchars($user['first_name'] ?? '') . ' ' . htmlspecialchars($user['last_name'] ?? '') . '</p>
                                <p>School: ' . htmlspecialchars($school_name ?? '') . '</p>
                              </div>';
          
          // Primary path for the card file
          $card_file = 'view.card_' . $user['card_id'] . '.php';
          $primary_path = MODULES_PATH . '/marketplace/views/cards/' . $card_file;
          
          // Generate fallback paths
          $fallback_paths = generate_fallback_paths($primary_path, $card_file);
          
          // Include the card file with fallbacks
          include_with_fallback($primary_path, $fallback_paths, false, $card_placeholder);
        ?>
      </a>
    </div>
    <?php } ?>
  </div>
</div>

<script type="text/javascript" src="/assets/modules/marketplace/js/card_flip.js"></script>

<?php
// Include footer based on authentication status
include_footer(isset($_SESSION['uuid']));
?>
