<?php require_once MODULES_PATH . '/common/views/public/view.header.php'; ?>

        <?php
        if (isset($_GET['error'])) {
            $error_message = '';
            switch ($_GET['error']) {
                case 'session_expired':
                    $error_message = 'Your session has expired. Please login again.';
                    break;
                case 'invalid_request':
                    $error_message = 'Invalid form submission. Please try again.';
                    break;
                case 'locked':
                    $minutes = isset($_GET['minutes']) ? (int)$_GET['minutes'] : 15;
                    $error_message = "Too many login attempts. Please try again in {$minutes} minutes.";
                    break;
                case 'invalid_credentials':
                    $error_message = 'Invalid email or password.';
                    break;
                case 'validation_failed':
                    $error_message = 'Please check your input and try again.';
                    break;
            }
            if ($error_message): ?>
                <div class="alert alert-warning">
                    <?php echo htmlspecialchars($error_message); ?>
                </div>
            <?php endif;
        } ?>
        
<div class="container mt-5">
  <div class="row h-100 align-items-center justify-content-center">
    <div class="col-12 col-md-7 col-lg-5">
      <div class="card shadow">
        <div class="card-body p-4">
          <form action="/login" method="POST" class="signup-form" novalidate>
            <div class="mb-3">
              <label for="email" class="form-label">Email</label>
              <input 
                type="email"
                id="email"
                name="email"
                required
                maxlength="255"
                class="form-control"
              >
              <div class="form-error invalid-feedback" id="email-error"></div>
            </div>

            <div class="mb-3">
              <label for="password" class="form-label">Password</label>
              <input 
                type="password"
                id="password"
                name="password"
                required
                class="form-control"
              >
              <div class="form-error invalid-feedback" id="password-error"></div>
            </div>

            <?php echo csrf_token_field(); ?>

            <button type="submit" class="auth-button btn btn-primary w-100 mb-3">
              Login
            </button>

            <div class="auth-links text-center">
              <p class="mb-2">Don't have an account? <a href="/register">Register here</a></p>
              <p class="mb-0"><a href="/reset-password">Forgot your password?</a></p>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<?php require_once MODULES_PATH . '/common/views/public/view.footer.php'; ?>
