<?php
require_once MODULES_PATH . '/common/views/auth/view.header.php';
require_once MODULES_PATH . '/settings/functions/settings_functions.php';

$uuid = $_SESSION['uuid'];

$all_interests = get_all_interests();

$uuid = $_SESSION['uuid'];
$user_data = get_user_settings_data($uuid);
?>

<style>
.tab-content {
  display: block;
}

.settings-card {
  border-radius: 0.5rem;
  /* Rounded corners for the card */
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
  /* Subtle shadow */
}

.nav-tabs .nav-link.active {
  font-weight: bold;
  /* Make active tab bold */
}

.tab-content {
  min-height: 200px;
  /* Give some minimum height to the content area */
}

/* Form Field */
.form-control {
  background-color: rgb(249, 249, 249);
  border-radius: 10px;
  border: 0px;
  box-shadow: rgba(9, 30, 66, 0.25) 0px 1px 1px, rgba(9, 30, 66, 0.13) 0px 0px 1px 1px;
}

/* Navigation Tabs */
/* Style the overall nav container */
.nav-pills-custom {
  background-color: #f8f9fa;
  /* Light grey background, adjust as needed */
  padding: 0.3rem 0.1rem;
  /* Add some padding around the nav */
  border-radius: 0.5rem;
  /* Rounded corners for the container */
  display: inline-flex;
  /* Make the container only as wide as its content */
}

/* Style individual nav links */
.nav-pills-custom .nav-link {
  color: #495057;
  /* Default text color for links */
  background-color: transparent;
  /* No background for inactive links */
  border-radius: 0.375rem;
  /* Standard Bootstrap rounded corners */
  padding: 0.5rem 1rem;
  /* Adjust padding as needed */
  margin: 0 0.25rem;
  /* Add small margin between links */
  transition: background-color 0.2s ease-in-out, color 0.2s ease-in-out;
  /* Smooth transitions */
}

/* Style the active nav link */
.nav-pills-custom .nav-link.active {
  background-color: #ffffff;
  /* White background for the active item */
  color: #212529;
  /* Darker text color for the active item */
  font-weight: 500;
  /* Slightly bolder text */
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
  /* Shadow to make it pop */
  border: 1px solid #dee2e6;
  /* Subtle border */
}

/* Optional: Hover effect for inactive links (can be removed if not desired) */
.nav-pills-custom .nav-link:not(.active):hover {
  background-color: #e9ecef;
  /* Light background on hover */
  color: #000;
}

/* END: Navigation Tabs */

/* Settings Styling */
/* Style the description text to match the image */
.settings-description {
  color: #6c757d;
  /* Bootstrap's secondary text color */
  font-size: 0.9rem;
}

/* Add some bottom margin to the form groups */
.form-group-custom {
  margin-bottom: 1.5rem;
  /* Space between form fields */
}

/* Add some bottom margin to the title section on smaller screens */
.settings-title-section {
  margin-bottom: 1rem;
  /* Space below title/desc when stacked */
}

/* Remove bottom margin on medium and larger screens where columns are side-by-side */
@media (min-width: 768px) {
  .settings-title-section {
    margin-bottom: 0;
  }
}

.form-label {
  font-weight: 500;
}
</style>

<div class="container-fluid pt-3 pb-4">
  <span class="page-title">Settings</span>
</div>

<div class="container">
  <!-- Nav tabs -->
  <ul class="nav nav-pills nav-pills-custom" id="myTab" role="tablist">
    <li class="nav-item" role="presentation">
      <button class="nav-link active" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button"
        role="tab">
        Profile
      </button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link" id="social-media-tab" data-bs-toggle="tab" data-bs-target="#social-media" type="button"
        role="tab">
        Social Media
      </button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link" id="account-tab" data-bs-toggle="tab" data-bs-target="#account" type="button" role="tab">
        Account
      </button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link" id="banking-tab" data-bs-toggle="tab" data-bs-target="#banking" type="button" role="tab">
        Banking
      </button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link" id="compliance-tab" data-bs-toggle="tab" data-bs-target="#compliance" type="button"
        role="tab">
        Compliance
      </button>
    </li>
  </ul>

  <!-- Tab content -->
  <div class="tab-content" id="myTabContent">
    <div class="tab-pane fade show active p-3" id="profile" role="tabpanel">
      <?php
        require_once MODULES_PATH . '/settings/views/view.profile.php';
      ?>
    </div>
    <div class="tab-pane fade p-3" id="social-media" role="tabpanel">
      <?php
        require_once MODULES_PATH . '/settings/views/view.social_media.php';
      ?>
    </div>
    <div class="tab-pane fade p-3" id="account" role="tabpanel">
      <h3>Account</h3>
      <p>This is the Account tab content.</p>
    </div>
    <div class="tab-pane fade p-3" id="banking" role="tabpanel">
      <h3>Banking</h3>
      <p>This is the banking tab content.</p>
    </div>
    <div class="tab-pane fade p-3" id="compliance" role="tabpanel">
      <h3>Compliance</h3>
      <p>This is the Compliance tab content.</p>
    </div>
  </div>
</div>



<!-- Interests Modal -->
<div class="modal fade" id="interestsModal" tabindex="-1" aria-labelledby="interestsModalLabel" aria-hidden="true"
  style="z-index: 20000;">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="interestsModalLabel">Select Interests</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <!-- Interests list will be loaded here -->
        <?php if (!empty($all_interests)): ?>
        <?php foreach ($all_interests as $interest): ?>
        <div class="form-check">
          <input class="form-check-input" type="checkbox" value="<?php echo htmlspecialchars($interest['id']); ?>"
            id="interest_<?php echo htmlspecialchars($interest['id']); ?>">
          <label class="form-check-label" for="interest_<?php echo htmlspecialchars($interest['id']); ?>">
            <?php echo htmlspecialchars($interest['interest_name']); ?>
          </label>
        </div>
        <?php endforeach; ?>
        <?php else: ?>
        <p>No interests found.</p>
        <?php endif; ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>


<?php
if ($user_data === false) {
    echo "Error fetching user data or user not found.";
} else {
    echo "<pre>";
    print_r($user_data);
    echo "</pre>";
}
?>
<?php 
require_once MODULES_PATH . '/common/views/auth/view.footer.php';