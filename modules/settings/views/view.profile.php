      <div class="row">

        <hr>

        <div class="col-md-4 settings-title-section">
          <h5>Personal Information</h5>
          <p class="settings-description">Edit your personal information</p>
        </div>

        <div class="col-md-8">
            <div class="form-group-custom">
              <label for="first_name" class="form-label">First Name</label>
              <input type="text" class="form-control" id="first_name" value="<?php echo isset($user_data['first_name']) ? htmlspecialchars($user_data['first_name'], ENT_QUOTES, 'UTF-8') : ''; ?>">
            </div>

            <div class="form-group-custom">
              <label for="middle_name" class="form-label">Middle Name</label>
              <input type="text" class="form-control" id="middle_name" value="<?php echo isset($user_data['middle_name']) ? htmlspecialchars($user_data['middle_name'], ENT_QUOTES, 'UTF-8') : ''; ?>">
            </div>

            <div class="form-group-custom">
              <label for="last_name" class="form-label">Last Name</label>
              <input type="text" class="form-control" id="last_name" value="<?php echo isset($user_data['last_name']) ? htmlspecialchars($user_data['last_name'], ENT_QUOTES, 'UTF-8') : ''; ?>">
            </div>

            <div class="form-group-custom">
              <label for="gender" class="form-label">Gender</label>
              <select class="form-control" id="gender">
                <option value="">Select Gender</option>
                <?php
                $gender_options = ['m' => 'Male', 'w' => 'Female', 'p' => 'Prefer not to say'];
                $user_gender = isset($user_data['gender']) ? $user_data['gender'] : '';
                foreach ($gender_options as $value => $label) {
                    $selected = ($user_gender === $value) ? 'selected' : '';
                    echo "<option value=\"" . htmlspecialchars($value, ENT_QUOTES, 'UTF-8') . "\" {$selected}>" . htmlspecialchars($label, ENT_QUOTES, 'UTF-8') . "</option>";
                }
                ?>
              </select>
            </div>

        </div>

        <hr>

        <div class="col-md-4 settings-title-section">
          <h5>Contact Information</h5>
          <p class="settings-description">Edit your contact information</p>
        </div>

        <div class="col-md-8">
            <div class="form-group-custom">
              <label for="email" class="form-label">Email</label>
              <input type="email" class="form-control" id="email" value="<?php echo isset($user_data['email']) ? htmlspecialchars($user_data['email'], ENT_QUOTES, 'UTF-8') : ''; ?>">
            </div>

            <div class="form-group-custom">
              <label for="street_address" class="form-label">Street Address</label>
              <input type="text" class="form-control" id="street_address" value="<?php echo isset($user_data['street_address']) ? htmlspecialchars($user_data['street_address'], ENT_QUOTES, 'UTF-8') : ''; ?>">
            </div>

            <div class="row">
              <div class="col-md-12 col-lg-6">
                <div class="form-group-custom">
                  <label for="city" class="form-label">City</label>
                  <input type="text" class="form-control" id="city" value="<?php echo isset($user_data['city']) ? htmlspecialchars($user_data['city'], ENT_QUOTES, 'UTF-8') : ''; ?>">
                </div>
              </div>
              <div class="col-md-6 col-lg-3">
                <div class="form-group-custom">
                  <label for="state" class="form-label">State</label>
                  <select class="form-control" id="state">
                    <option value="">Select State</option>
                    <?php
                    $us_states = [
                        'AL' => 'Alabama', 'AK' => 'Alaska', 'AZ' => 'Arizona', 'AR' => 'Arkansas', 'CA' => 'California',
                        'CO' => 'Colorado', 'CT' => 'Connecticut', 'DE' => 'Delaware', 'FL' => 'Florida', 'GA' => 'Georgia',
                        'HI' => 'Hawaii', 'ID' => 'Idaho', 'IL' => 'Illinois', 'IN' => 'Indiana', 'IA' => 'Iowa',
                        'KS' => 'Kansas', 'KY' => 'Kentucky', 'LA' => 'Louisiana', 'ME' => 'Maine', 'MD' => 'Maryland',
                        'MA' => 'Massachusetts', 'MI' => 'Michigan', 'MN' => 'Minnesota', 'MS' => 'Mississippi', 'MO' => 'Missouri',
                        'MT' => 'Montana', 'NE' => 'Nebraska', 'NV' => 'Nevada', 'NH' => 'New Hampshire', 'NJ' => 'New Jersey',
                        'NM' => 'New Mexico', 'NY' => 'New York', 'NC' => 'North Carolina', 'ND' => 'North Dakota', 'OH' => 'Ohio',
                        'OK' => 'Oklahoma', 'OR' => 'Oregon', 'PA' => 'Pennsylvania', 'RI' => 'Rhode Island', 'SC' => 'South Carolina',
                        'SD' => 'South Dakota', 'TN' => 'Tennessee', 'TX' => 'Texas', 'UT' => 'Utah', 'VT' => 'Vermont',
                        'VA' => 'Virginia', 'WA' => 'Washington', 'WV' => 'West Virginia', 'WI' => 'Wisconsin', 'WY' => 'Wyoming'
                    ];
                    $user_state = isset($user_data['state']) ? $user_data['state'] : '';
                    foreach ($us_states as $abbreviation => $state_name) {
                        $selected = ($user_state === $abbreviation) ? 'selected' : '';
                        echo "<option value=\"{$abbreviation}\" {$selected}>{$state_name}</option>";
                    }
                    ?>
                  </select>
                </div>
              </div>
              <div class="col-md-6 col-lg-3">
                <div class="form-group-custom">
                  <label for="postal_code" class="form-label">Postal Code</label>
                  <input type="text" class="form-control" id="postal_code" value="<?php echo isset($user_data['postal_code']) ? htmlspecialchars($user_data['postal_code'], ENT_QUOTES, 'UTF-8') : ''; ?>">
                </div>
              </div>
            </div>

        </div>

        <hr>

        <div class="col-md-4 settings-title-section">
          <h5>Profile Information</h5>
          <p class="settings-description">Edit your profile information</p>
        </div>

        <div class="col-md-8">
            <div class="form-group-custom">
              <label for="profile" class="form-label">Profile</label>
              <textarea class="form-control" id="profile" rows="8"><?php echo isset($user_data['profile_description']) ? htmlspecialchars($user_data['profile_description']) : ''; ?></textarea>
            </div>
        </div>

        <hr>

        <div class="col-md-4 settings-title-section">
          <h5>Interests</h5>
          <p class="settings-description">Edit your interests</p>
        </div>

        <div class="col-md-8">
            <div class="form-group-custom">
              <label for="interests" class="form-label">Interests</label>
              <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#interestsModal">
                Select Interests
              </button>
            </div>
        </div>

        <hr>

      </div>