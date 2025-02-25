<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
  <title>PeakNIL</title>
  
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-bar-style" content="default">
  <link rel="manifest" href="manifest.json">

  <link href="/assets/common/css/base.css" rel="stylesheet">
  <link href="/assets/modules/landing/css/landing.css" rel="stylesheet">

  <?php /* ?>
  <link rel="stylesheet" href="/assets/common/css/min/min.css">
  <link rel="stylesheet" href="/assets/common/css/min/min.dark.css" media="(prefers-color-scheme: dark)" id="dark-theme">
  <?php */ ?>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,100..900&display=swap" rel="stylesheet">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

</head>
<body style = "">
<main class="content">
<?php
// Enhanced nav inclusion with fallback paths
error_log('Starting nav inclusion with fallbacks...');

// Define possible locations for the nav file
$nav_locations = [
    // Standard path
    MODULES_PATH . '/common/views/public/view.nav.php',
    
    // Alternative paths for production
    '/var/www/modules/common/views/public/view.nav.php',
    '/var/www/html/modules/common/views/public/view.nav.php',
    dirname(__FILE__) . '/view.nav.php',
    
    // Try auth directory as fallback
    MODULES_PATH . '/common/views/auth/view.nav.php',
    '/var/www/modules/common/views/auth/view.nav.php',
    
    // Try common directory as fallback
    MODULES_PATH . '/common/views/common/view.nav.php',
    '/var/www/modules/common/views/common/view.nav.php',
    
    // Try backup nav file
    MODULES_PATH . '/common/views/public/view.nav.bak.php',
    '/var/www/modules/common/views/public/view.nav.bak.php'
];

// Try each location until we find one that exists
$nav_found = false;
foreach ($nav_locations as $nav_file) {
    error_log('Trying nav file: ' . $nav_file);
    
    if (file_exists($nav_file)) {
        error_log('SUCCESS: Nav file found at: ' . $nav_file);
        require_once $nav_file;
        $nav_found = true;
        break;
    }
}

// If no nav file was found, display a minimal navigation
if (!$nav_found) {
    error_log('WARNING: Nav file not found in any location');
    echo '<div style="background:#f8f8f8;padding:15px;margin-bottom:20px;">
            <div style="display:flex;justify-content:space-between;align-items:center;">
                <div><strong>PeakNIL</strong></div>
                <div>
                    <a href="/" style="margin-right:15px;text-decoration:none;color:#333;">Home</a>
                    <a href="/login" style="text-decoration:none;color:#333;">Login</a>
                </div>
            </div>
          </div>';
}
?>
