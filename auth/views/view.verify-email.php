<?php require_once MODULES_PATH . '/common/views/auth/view.header.php'; ?>

<div class="container mt-5">
  <div class="row h-100 align-items-center justify-content-center">
    <div class="col-12 col-md-7 col-lg-5">
      <div class="card shadow">
        <div class="card-header bg-white">
          <h4 class="mb-0">Email Verification</h4>
        </div>
        <div class="card-body">
          <?php if ($success): ?>
            <div class="alert alert-success">
              Your email has been successfully verified! You will be redirected to the dashboard.
              <script>
                setTimeout(function() {
                  window.location.href = '/dashboard';
                }, 2000);
              </script>
            </div>
          <?php elseif ($error): ?>
            <div class="alert alert-danger">
              <?php echo htmlspecialchars($error); ?>
            </div>
          <?php endif; ?>

          <?php if (!$success): ?>
            <p class="mb-4">
              Please enter the 4-digit verification code that was sent to 
              <strong><?php echo htmlspecialchars($user_email); ?></strong>
            </p>

            <form method="POST" action="/verify-email">
              <div class="form-group mb-3">
                <label for="code" class="form-label">Verification Code</label>
                <input type="text"
                  class="form-control"
                  id="code"
                  name="code"
                  required
                  pattern="[0-9]{4}"
                  maxlength="4"
                  placeholder="Enter 4-digit code">
              </div>
              <button type="submit" class="btn btn-primary w-100 mb-3">Verify Email</button>
            </form>

            <hr>
            
            <p class="mb-0 text-center">
              Didn't receive the code?
              <a href="/resend-verification">Resend verification email</a>
            </p>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</div>

<?php require_once MODULES_PATH . '/common/views/auth/view.footer.php'; ?>
