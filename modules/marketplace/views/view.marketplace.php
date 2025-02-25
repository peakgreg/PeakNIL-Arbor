<?php
global $db;

// Conditional header with file existence check
if (isset($_SESSION['uuid'])) {
    $header_file = MODULES_PATH . '/common/views/auth/view.header.php';
} else {
    $header_file = MODULES_PATH . '/common/views/public/view.header.php';
}

// Log the header file path and check if it exists
error_log('Attempting to include header file: ' . $header_file);
if (!file_exists($header_file)) {
    error_log('ERROR: Header file not found at: ' . $header_file);
    echo '<div style="color:red;background:#ffeeee;padding:15px;margin:15px;border:1px solid #ff0000;">
            <h3>Header File Not Found</h3>
            <p>The system could not find the header file at: ' . htmlspecialchars($header_file) . '</p>
            <p>Please contact the administrator.</p>
          </div>';
} else {
    error_log('Header file found, including: ' . $header_file);
    require_once $header_file;
}
?>
<?php
  // Include browse-by-menu with file existence check
  $browse_menu_file = MODULES_PATH . '/common/views/common/view.browse-by-menu.php';
  error_log('Attempting to include browse menu file: ' . $browse_menu_file);
  if (!file_exists($browse_menu_file)) {
      error_log('WARNING: Browse menu file not found at: ' . $browse_menu_file);
      echo '<!-- Browse menu file not found: ' . htmlspecialchars($browse_menu_file) . ' -->';
  } else {
      error_log('Browse menu file found, including: ' . $browse_menu_file);
      include $browse_menu_file;
  }
  
  // Include product-types-horizontal-scroll with file existence check
  $product_types_file = MODULES_PATH . '/common/views/common/view.product-types-horizontal-scroll.php';
  error_log('Attempting to include product types file: ' . $product_types_file);
  if (!file_exists($product_types_file)) {
      error_log('WARNING: Product types file not found at: ' . $product_types_file);
      echo '<!-- Product types file not found: ' . htmlspecialchars($product_types_file) . ' -->';
  } else {
      error_log('Product types file found, including: ' . $product_types_file);
      include $product_types_file;
  }
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
          $card_file = MODULES_PATH . '/marketplace/views/cards/view.card_' . $user['card_id'] . '.php';
          if (!file_exists($card_file)) {
              error_log('WARNING: Card file not found at: ' . $card_file);
              echo '<div style="border:1px solid #ddd;padding:10px;text-align:center;background:#f8f8f8;">
                      <p>Card template not found</p>
                      <p>ID: ' . htmlspecialchars($user['card_id']) . '</p>
                    </div>';
          } else {
              include $card_file;
          }
        ?>
      </a>
    </div>
    <?php } ?>
  </div>
</div>

<script type="text/javascript" src="/assets/modules/marketplace/js/card_flip.js"></script>

<?php 
// Conditional footer with file existence check
if (isset($_SESSION['uuid'])) {
    $footer_file = MODULES_PATH . '/common/views/auth/view.footer.php';
} else {
    $footer_file = MODULES_PATH . '/common/views/public/view.footer.php';
}

// Log the footer file path and check if it exists
error_log('Attempting to include footer file: ' . $footer_file);
if (!file_exists($footer_file)) {
    error_log('ERROR: Footer file not found at: ' . $footer_file);
    echo '<div style="color:red;background:#ffeeee;padding:15px;margin:15px;border:1px solid #ff0000;">
            <h3>Footer File Not Found</h3>
            <p>The system could not find the footer file at: ' . htmlspecialchars($footer_file) . '</p>
            <p>Please contact the administrator.</p>
          </div>';
} else {
    error_log('Footer file found, including: ' . $footer_file);
    require_once $footer_file;
}
?>
