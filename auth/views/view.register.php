<?php require_once MODULES_PATH . '/common/views/public/view.header.php'; ?>

<main class="auth-container container mt-5">
  <div class="row h-100 align-items-center justify-content-center">
    <div class="col-12 col-md-7 col-lg-5">
      <div class="auth-card card shadow">
        <div class="card-body p-4">
          <h1 class="auth-title text-center mb-4">Create Account</h1>
          
          <?php if (!empty($_SESSION['form_errors'])): ?>
            <div class="alert alert-danger">
              <?php foreach ($_SESSION['form_errors'] as $error): ?>
                <div><?php echo htmlspecialchars($error); ?></div>
              <?php endforeach; ?>
            </div>
            <?php unset($_SESSION['form_errors']); ?>
          <?php endif; ?>

          <form action="/register" method="POST" class="auth-form" novalidate>
            <div class="form-group mb-3">
              <label for="username" class="form-label">Username</label>
              <input 
                type="text"
                id="username"
                name="username"
                required
                minlength="3"
                maxlength="50"
                pattern="[a-zA-Z0-9_]+"
                title="Only letters, numbers and underscores allowed"
                class="form-control"
              >
              <div class="form-error invalid-feedback" id="username-error"></div>
            </div>

            <div class="form-group mb-3">
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

            <div class="form-group mb-3">
              <label for="password" class="form-label">Password</label>
              <input 
                type="password"
                id="password"
                name="password"
                required
                minlength="8"
                pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$"
                title="Must contain at least one uppercase, one lowercase, and one number"
                class="form-control"
              >
              <div class="form-error invalid-feedback" id="password-error"></div>
            </div>

            <div class="form-group mb-3">
              <label for="confirm_password" class="form-label">Confirm Password</label>
              <input 
                type="password"
                id="confirm_password"
                name="confirm_password"
                required
                class="form-control"
              >
              <div class="form-error invalid-feedback" id="confirm_password-error"></div>
            </div>

            <?php echo csrf_token_field(); ?>

            <div class="form-group mb-3">
              <button type="submit" class="auth-button btn btn-primary w-100">Register</button>
            </div>

            <div class="auth-links text-center">
              <p class="mb-0">Already have an account? <a href="/login">Login here</a></p>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</main>

<?php require_once MODULES_PATH . '/common/views/public/view.footer.php'; ?>