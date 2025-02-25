<?php
global $db;

// Enhanced header inclusion with fallback paths
error_log('Starting header inclusion with fallbacks...');

// Determine which header file to use (auth or public)
$header_type = isset($_SESSION['uuid']) ? 'auth' : 'public';
error_log('Header type: ' . $header_type);

// Define possible locations for the header file
$header_locations = [
    // Standard path
    MODULES_PATH . '/common/views/' . $header_type . '/view.header.php',
    
    // Alternative paths for production
    '/var/www/modules/common/views/' . $header_type . '/view.header.php',
    '/var/www/html/modules/common/views/' . $header_type . '/view.header.php',
    dirname(dirname(dirname(__FILE__))) . '/common/views/' . $header_type . '/view.header.php',
    
    // Fallback to the other header type if the primary one isn't found
    MODULES_PATH . '/common/views/' . ($header_type === 'auth' ? 'public' : 'auth') . '/view.header.php',
    '/var/www/modules/common/views/' . ($header_type === 'auth' ? 'public' : 'auth') . '/view.header.php'
];

// Try each location until we find one that exists
$header_found = false;
foreach ($header_locations as $header_file) {
    error_log('Trying header file: ' . $header_file);
    
    if (file_exists($header_file)) {
        error_log('SUCCESS: Header file found at: ' . $header_file);
        require_once $header_file;
        $header_found = true;
        break;
    }
}

// If no header file was found, display an error message
if (!$header_found) {
    error_log('ERROR: Header file not found in any location');
    echo '<div style="color:red;background:#ffeeee;padding:15px;margin:15px;border:1px solid #ff0000;">
            <h3>Header File Not Found</h3>
            <p>The system could not find the header file in any of the expected locations.</p>
            <p>Attempted locations:</p>
            <ul>';
    
    foreach ($header_locations as $location) {
        echo '<li>' . htmlspecialchars($location) . '</li>';
    }
    
    echo '</ul>
            <p>Please contact the administrator.</p>
          </div>';
    
    // Provide a minimal header as fallback
    echo '<div style="padding:20px;background:#f8f8f8;margin-bottom:20px;">
            <h1>PeakNIL</h1>
            <p>Marketplace</p>
          </div>';
}
?>
<?php
  // Enhanced browse-by-menu inclusion with fallback paths
  error_log('Starting browse-by-menu inclusion with fallbacks...');
  
  // Define possible locations for the browse-by-menu file
  $browse_menu_locations = [
      // Standard path
      MODULES_PATH . '/common/views/common/view.browse-by-menu.php',
      
      // Alternative paths for production
      '/var/www/modules/common/views/common/view.browse-by-menu.php',
      '/var/www/html/modules/common/views/common/view.browse-by-menu.php',
      dirname(dirname(dirname(__FILE__))) . '/common/views/common/view.browse-by-menu.php'
  ];
  
  // Try each location until we find one that exists
  $browse_menu_found = false;
  foreach ($browse_menu_locations as $browse_menu_file) {
      error_log('Trying browse menu file: ' . $browse_menu_file);
      
      if (file_exists($browse_menu_file)) {
          error_log('SUCCESS: Browse menu file found at: ' . $browse_menu_file);
          include $browse_menu_file;
          $browse_menu_found = true;
          break;
      }
  }
  
  // If no browse menu file was found, log a warning
  if (!$browse_menu_found) {
      error_log('WARNING: Browse menu file not found in any location');
      echo '<!-- Browse menu file not found in any location -->';
  }
  
  // Enhanced product-types-horizontal-scroll inclusion with fallback paths
  error_log('Starting product-types-horizontal-scroll inclusion with fallbacks...');
  
  // Define possible locations for the product-types file
  $product_types_locations = [
      // Standard path
      MODULES_PATH . '/common/views/common/view.product-types-horizontal-scroll.php',
      
      // Alternative paths for production
      '/var/www/modules/common/views/common/view.product-types-horizontal-scroll.php',
      '/var/www/html/modules/common/views/common/view.product-types-horizontal-scroll.php',
      dirname(dirname(dirname(__FILE__))) . '/common/views/common/view.product-types-horizontal-scroll.php'
  ];
  
  // Try each location until we find one that exists
  $product_types_found = false;
  foreach ($product_types_locations as $product_types_file) {
      error_log('Trying product types file: ' . $product_types_file);
      
      if (file_exists($product_types_file)) {
          error_log('SUCCESS: Product types file found at: ' . $product_types_file);
          include $product_types_file;
          $product_types_found = true;
          break;
      }
  }
  
  // If no product types file was found, log a warning
  if (!$product_types_found) {
      error_log('WARNING: Product types file not found in any location');
      echo '<!-- Product types file not found in any location -->';
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
          // Enhanced card file inclusion with fallback paths
          error_log('Starting card file inclusion with fallbacks for card ID: ' . $user['card_id']);
          
          // Define possible locations for the card file
          $card_locations = [
              // Standard path
              MODULES_PATH . '/marketplace/views/cards/view.card_' . $user['card_id'] . '.php',
              
              // Alternative paths for production
              '/var/www/modules/marketplace/views/cards/view.card_' . $user['card_id'] . '.php',
              '/var/www/html/modules/marketplace/views/cards/view.card_' . $user['card_id'] . '.php',
              dirname(__FILE__) . '/cards/view.card_' . $user['card_id'] . '.php'
          ];
          
          // Try each location until we find one that exists
          $card_found = false;
          foreach ($card_locations as $card_file) {
              error_log('Trying card file: ' . $card_file);
              
              if (file_exists($card_file)) {
                  error_log('SUCCESS: Card file found at: ' . $card_file);
                  include $card_file;
                  $card_found = true;
                  break;
              }
          }
          
          // If no card file was found, display a placeholder
          if (!$card_found) {
              error_log('WARNING: Card file not found in any location for ID: ' . $user['card_id']);
              echo '<div style="border:1px solid #ddd;padding:10px;text-align:center;background:#f8f8f8;">
                      <p>Card template not found</p>
                      <p>ID: ' . htmlspecialchars($user['card_id']) . '</p>
                      <p>Name: ' . htmlspecialchars($user['first_name'] ?? '') . ' ' . htmlspecialchars($user['last_name'] ?? '') . '</p>
                      <p>School: ' . htmlspecialchars($school_name ?? '') . '</p>
                    </div>';
          }
        ?>
      </a>
    </div>
    <?php } ?>
  </div>
</div>

<script type="text/javascript" src="/assets/modules/marketplace/js/card_flip.js"></script>

<?php 
// Enhanced footer inclusion with fallback paths
error_log('Starting footer inclusion with fallbacks...');

// Determine which footer file to use (auth or public)
$footer_type = isset($_SESSION['uuid']) ? 'auth' : 'public';
error_log('Footer type: ' . $footer_type);

// Define possible locations for the footer file
$footer_locations = [
    // Standard path
    MODULES_PATH . '/common/views/' . $footer_type . '/view.footer.php',
    
    // Alternative paths for production
    '/var/www/modules/common/views/' . $footer_type . '/view.footer.php',
    '/var/www/html/modules/common/views/' . $footer_type . '/view.footer.php',
    dirname(dirname(dirname(__FILE__))) . '/common/views/' . $footer_type . '/view.footer.php',
    
    // Fallback to the other footer type if the primary one isn't found
    MODULES_PATH . '/common/views/' . ($footer_type === 'auth' ? 'public' : 'auth') . '/view.footer.php',
    '/var/www/modules/common/views/' . ($footer_type === 'auth' ? 'public' : 'auth') . '/view.footer.php'
];

// Try each location until we find one that exists
$footer_found = false;
foreach ($footer_locations as $footer_file) {
    error_log('Trying footer file: ' . $footer_file);
    
    if (file_exists($footer_file)) {
        error_log('SUCCESS: Footer file found at: ' . $footer_file);
        require_once $footer_file;
        $footer_found = true;
        break;
    }
}

// If no footer file was found, display an error message
if (!$footer_found) {
    error_log('ERROR: Footer file not found in any location');
    echo '<div style="color:red;background:#ffeeee;padding:15px;margin:15px;border:1px solid #ff0000;">
            <h3>Footer File Not Found</h3>
            <p>The system could not find the footer file in any of the expected locations.</p>
            <p>Attempted locations:</p>
            <ul>';
    
    foreach ($footer_locations as $location) {
        echo '<li>' . htmlspecialchars($location) . '</li>';
    }
    
    echo '</ul>
            <p>Please contact the administrator.</p>
          </div>';
    
    // Provide a minimal footer as fallback
    echo '<div style="padding:20px;background:#f8f8f8;margin-top:20px;text-align:center;">
            <p>&copy; ' . date('Y') . ' PeakNIL. All rights reserved.</p>
          </div>';
}
?>
