<?php
global $db;

// Conditional header
if (isset($_SESSION['uuid'])) {
    require_once MODULES_PATH . '/common/views/auth/view.header.php';
} else {
    require_once MODULES_PATH . '/common/views/public/view.header.php';
}
?>
<?php
  include MODULES_PATH . '/common/views/common/view.browse-by-menu.php';
  include MODULES_PATH . '/common/views/common/view.product-types-horizontal-scroll.php';
?>
<link rel="stylesheet" href="/assets/modules/marketplace/css/marketplace.css">
<link rel="stylesheet" href="/assets/modules/marketplace/css/card_flip.css">
<link rel="stylesheet" href="/assets/modules/marketplace/css/card_1.css">
<link rel="stylesheet" href="/assets/modules/marketplace/css/card_2.css">


<div class="container-fluid pt-3">
  <div class="row">
    <?php // MARK: Cards
    foreach ($users as $user) {
      $school_logo = "https://peaknil.s3-us-east-2.amazonaws.com/assets/images/teams/logos/50x50-light-mode/{$user['school_id']}.png";
      $school_name = $user['school_name'];
      $school_mascot = $user['school_mascot'];
    ?>
    <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-4 col-sm-6 col-6 mb-3" style="padding: 6px;">
      <a href = "/profile?id=<?= $user['uuid'] ?>"><?php include MODULES_PATH . '/marketplace/views/cards/view.card_' . $user['card_id'] . '.php'; ?></a>
    </div>
    <?php } ?>
  </div>
</div>

<script type="text/javascript" src="/assets/modules/marketplace/js/card_flip.js"></script>

<?php 
// Conditional footer
if (isset($_SESSION['uuid'])) {
    require_once MODULES_PATH . '/common/views/auth/view.footer.php';
} else {
    require_once MODULES_PATH . '/common/views/public/view.footer.php';
}
?>