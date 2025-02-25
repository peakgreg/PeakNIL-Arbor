        <?php
        // Enhanced mobile menu inclusion with fallback paths
        error_log('Starting mobile menu inclusion with fallbacks...');
        
        // Define possible locations for the mobile menu file
        $mobile_menu_locations = [
            // Standard path
            MODULES_PATH . '/common/views/common/view.mobile-menu.php',
            
            // Alternative paths for production
            '/var/www/modules/common/views/common/view.mobile-menu.php',
            '/var/www/html/modules/common/views/common/view.mobile-menu.php',
            dirname(dirname(__FILE__)) . '/common/view.mobile-menu.php',
            
            // Try auth directory as fallback
            MODULES_PATH . '/common/views/auth/view.mobile-menu.php',
            '/var/www/modules/common/views/auth/view.mobile-menu.php',
            
            // Try public directory as fallback
            MODULES_PATH . '/common/views/public/view.mobile-menu.php',
            '/var/www/modules/common/views/public/view.mobile-menu.php'
        ];
        
        // Try each location until we find one that exists
        $mobile_menu_found = false;
        foreach ($mobile_menu_locations as $mobile_menu_file) {
            error_log('Trying mobile menu file: ' . $mobile_menu_file);
            
            if (file_exists($mobile_menu_file)) {
                error_log('SUCCESS: Mobile menu file found at: ' . $mobile_menu_file);
                include $mobile_menu_file;
                $mobile_menu_found = true;
                break;
            }
        }
        
        // If no mobile menu file was found, log a warning
        if (!$mobile_menu_found) {
            error_log('WARNING: Mobile menu file not found in any location');
            echo '<!-- Mobile menu file not found in any location -->';
        }
        ?>

</main>

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
        dirname(dirname(__FILE__)) . '/public/view.debug.php',
        
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
