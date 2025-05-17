<?php
require_once MODULES_PATH . '/common/views/auth/view.header.php';
# $transactions = get_wallet_history($_SESSION['uuid'], 5);
?>
<div class="transaction-items">
    <?php if (!empty($transactions)): ?>
        <?php foreach ($transactions as $txn): ?>
            <div class="transaction-item">
                <div class="txn-date">1/2/2025</div>
                <div class="txn-description"><?= htmlspecialchars($txn['description']) ?></div>
                <div class="txn-amount <?= $txn['amount'] > 0 ? 'credit' : 'debit' ?>">
                    $12.34
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p class="no-transactions">No transactions found</p>
    <?php endif; ?>
</div>

<?php 
require_once MODULES_PATH . '/common/views/auth/view.footer.php';