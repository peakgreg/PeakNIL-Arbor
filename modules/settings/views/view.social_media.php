      <div class="row">

        <hr>

        <div class="col-md-4 settings-title-section">
          <h5>Social Media Accounts</h5>
          <p class="settings-description">Edit your social media profiles</p>
        </div>

        <div class="col-md-8">
            <div class="form-group-custom">
              <label for="instagram_username" class="form-label">Instagram Username</label>
              <input type="text" class="form-control" id="instagram_username" value="<?php echo isset($user_data['instagram_username']) ? htmlspecialchars($user_data['instagram_username'], ENT_QUOTES, 'UTF-8') : ''; ?>">
            </div>

            <div class="form-group-custom">
              <label for="x_username" class="form-label">X (Twitter) Username</label>
              <input type="text" class="form-control" id="x_username" value="<?php echo isset($user_data['x_username']) ? htmlspecialchars($user_data['x_username'], ENT_QUOTES, 'UTF-8') : ''; ?>">
            </div>

            <div class="form-group-custom">
              <label for="tiktok_username" class="form-label">TikTok Username</label>
              <input type="text" class="form-control" id="tiktok_username" value="<?php echo isset($user_data['tiktok_username']) ? htmlspecialchars($user_data['tiktok_username'], ENT_QUOTES, 'UTF-8') : ''; ?>">
            </div>

            <div class="form-group-custom">
              <label for="facebook_username" class="form-label">Facebook Username</label>
              <input type="text" class="form-control" id="facebook_username" value="<?php echo isset($user_data['facebook_username']) ? htmlspecialchars($user_data['facebook_username'], ENT_QUOTES, 'UTF-8') : ''; ?>">
            </div>

            <div class="form-group-custom">
              <label for="linkedin_username" class="form-label">LinkedIn Username</label>
              <input type="text" class="form-control" id="linkedin_username" value="<?php echo isset($user_data['linkedin_username']) ? htmlspecialchars($user_data['linkedin_username'], ENT_QUOTES, 'UTF-8') : ''; ?>">
            </div>

            <div class="form-group-custom">
              <label for="youtube_username" class="form-label">YouTube Username</label>
              <input type="text" class="form-control" id="youtube_username" value="<?php echo isset($user_data['youtube_username']) ? htmlspecialchars($user_data['youtube_username'], ENT_QUOTES, 'UTF-8') : ''; ?>">
            </div>
        </div>

        <hr>

      </div>