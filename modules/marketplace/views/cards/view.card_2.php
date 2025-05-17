<div class="card-container" style="height: auto;">
  <div class="card h-100 noselect card-modal" data-modal-target="#<?= $user['uuid']?>">
    <button class="info-icon" aria-label="Flip card for more information">
      <img class="icon-rotate-card"
        src="https://peaknil.s3.us-east-2.amazonaws.com/assets/images/site/icon-rotate-card.png">
    </button>
    <div class="card-front">
      <img src="<?= htmlspecialchars($user["profile_image_url"]) ?>" class="card-img-top" alt="Card 2" />
      <img class="athlete-image-2" src="<?= $school_logo ?>" alt="Team Logo" id="team-logo-<?= $user['school_id']; ?>">
      <div class="athlete-info-2">
          <div class="athlete-name-2"><?php echo $user["firstName"]; ?> <?php echo $user["lastName"]; ?>
              <img class="athlete-verified-2" src="<?php echo ($user['verified'] == '1') ? 'https://peaknil.s3.us-east-2.amazonaws.com/assets/images/site/verified.png' : 'https://peaknil.s3.us-east-2.amazonaws.com/assets/images/site/non-verified.png'; ?>">
          </div>
          <div class="athlete-school-2"><?= $school_name ?></div>
      </div>
    </div>
    <div class="card-back">
      <div class="card-body">
        <h5 class="card-title">More Info</h5>
        <p class="card-text">This is additional information about Card One that appears on the back.</p>
        <button class="flip-back-icon" aria-label="Flip card back">
          <img class="icon-rotate-card back-icon"
            src="https://peaknil.s3.us-east-2.amazonaws.com/assets/images/site/icon-rotate-card.png">
        </button>
      </div>
    </div>
  </div>
</div>