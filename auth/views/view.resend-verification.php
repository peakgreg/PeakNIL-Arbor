<?php require_once MODULES_PATH . '/common/views/auth/view.header.php'; ?>

<div class="container mt-5">
  <div class="row h-100 align-items-center justify-content-center">
    <div class="col-12 col-md-7 col-lg-5">
      <div class="card shadow">
        <div class="card-header bg-white">
          <h4 class="mb-0">Resend Verification Email</h4>
        </div>
        <div class="card-body">
          <?php if ($success): ?>
            <div class="alert alert-success mb-3">
              A new verification code has been sent to your email address.
              Please check your inbox and spam folder.
            </div>
            <p class="mb-0">
              Return to <a href="/verify-email">verification page</a> to enter your code.
            </p>
          <?php elseif ($error): ?>
            <div class="alert alert-danger mb-3">
              <?php echo htmlspecialchars($error); ?>
            </div>
            <p class="mb-3">
              Please try again or contact support if the problem persists.
            </p>
            <a href="/resend-verification" class="btn btn-primary w-100">Try Again</a>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</div>

<?php require_once MODULES_PATH . '/common/views/auth/view.footer.php'; ?>
