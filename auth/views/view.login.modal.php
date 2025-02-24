<div class="modal fade" id="login" tabindex="-1" aria-labelledby="login" aria-hidden="true" style = "z-index: 21000;">
  <div class="modal-dialog modal-dialog-centered modal-fullscreen-sm-down">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Login</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
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