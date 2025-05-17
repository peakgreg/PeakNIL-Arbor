<?php
require_once MODULES_PATH . '/common/views/auth/view.header.php';
?>

<div class="container">
    <div class="balance-display">
        0.00
    </div>
    
    <div class="transaction-list">
        <h3>Recent Transactions</h3>
        <?php include MODULES_PATH . '/wallet/views/view.history.php' ?>
    </div>
</div>

<?php 
require_once MODULES_PATH . '/common/views/auth/view.footer.php';