  </main>

  <?php
    // Enhanced login modal inclusion with fallback paths
    error_log('Starting login modal inclusion with fallbacks...');
    
    // Define possible locations for the login modal file
    $login_modal_locations = [
        // Standard path
        AUTH_PATH . '/views/view.login.modal.php',
        
        // Alternative paths for production
        '/var/www/auth/views/view.login.modal.php',
        '/var/www/html/auth/views/view.login.modal.php',
        dirname(dirname(dirname(dirname(__FILE__)))) . '/auth/views/view.login.modal.php'
    ];
    
    // Try each location until we find one that exists
    $login_modal_found = false;
    foreach ($login_modal_locations as $login_modal_file) {
        error_log('Trying login modal file: ' . $login_modal_file);
        
        if (file_exists($login_modal_file)) {
            error_log('SUCCESS: Login modal file found at: ' . $login_modal_file);
            include $login_modal_file;
            $login_modal_found = true;
            break;
        }
    }
    
    // If no login modal file was found, log a warning
    if (!$login_modal_found) {
        error_log('WARNING: Login modal file not found in any location');
        echo '<!-- Login modal file not found in any location -->';
    }
  ?>

  <script type="text/javascript" src="/assets/common/js/helpers.js"></script>
  <script type="text/javascript" src="/assets/common/js/menu.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

  <?php
    // Enhanced debug file inclusion with fallback paths
    error_log('Starting debug file inclusion with fallbacks...');
    
    // Define possible locations for the debug file
    $debug_locations = [
        // Standard path
        MODULES_PATH . '/common/views/public/view.debug.php',
        
        // Alternative paths for production
        '/var/www/modules/common/views/public/view.debug.php',
        '/var/www/html/modules/common/views/public/view.debug.php',
        dirname(__FILE__) . '/view.debug.php',
        
        // Try auth directory as fallback
        MODULES_PATH . '/common/views/auth/view.debug.php',
        '/var/www/modules/common/views/auth/view.debug.php',
        
        // Try common directory as fallback
        MODULES_PATH . '/common/views/common/view.debug.php',
        '/var/www/modules/common/views/common/view.debug.php'
    ];
    
    // Try each location until we find one that exists
    $debug_found = false;
    foreach ($debug_locations as $debug_file) {
        error_log('Trying debug file: ' . $debug_file);
        
        if (file_exists($debug_file)) {
            error_log('SUCCESS: Debug file found at: ' . $debug_file);
            include $debug_file;
            $debug_found = true;
            break;
        }
    }
    
    // If no debug file was found, log a warning
    if (!$debug_found) {
        error_log('WARNING: Debug file not found in any location');
        echo '<!-- Debug file not found in any location -->';
    }
  ?>
</body>
</html>
