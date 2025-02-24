<?php
#
require_once __DIR__ . '/../config/init.php';
require_once MODULES_PATH . '/common/functions/email_functions.php';

$message = '';
$status = '';
$config = get_mail_config();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $to = $_POST['to'] ?? '';
    $subject = $_POST['subject'] ?? '';
    $body = $_POST['body'] ?? '';
    $type = $_POST['type'] ?? 'plain';
    
    if ($type === 'plain') {
        $result = send_email($to, $subject, $body);
    } else {
        $result = send_html_email($to, $subject, $body);
    }
    
    if ($result) {
        $status = 'success';
        $message = 'Email sent successfully!';
    } else {
        $status = 'error';
        $message = 'Failed to send email. Check error logs for details.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Email Sending</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 800px; margin: 20px auto; padding: 0 20px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; }
        input[type="email"], input[type="text"], textarea, select {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        textarea { height: 150px; }
        button { 
            background: #007bff;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover { background: #0056b3; }
        .message {
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 4px;
        }
        .success { background: #d4edda; color: #155724; }
        .error { background: #f8d7da; color: #721c24; }
    </style>
</head>
<body>
    <h1>Test Email Sending</h1>
    
    <?php if ($message): ?>
    <div class="message <?php echo $status; ?>">
        <?php echo htmlspecialchars($message); ?>
    </div>
    <?php endif; ?>

    <form method="POST" action="">
        <div class="form-group">
            <label for="to">To:</label>
            <input type="email" id="to" name="to" required>
        </div>

        <div class="form-group">
            <label for="subject">Subject:</label>
            <input type="text" id="subject" name="subject" required>
        </div>

        <div class="form-group">
            <label for="type">Email Type:</label>
            <select id="type" name="type">
                <label for="type">Email Type:</label>
                <option value="plain">Plain Text</option>
                <option value="html">HTML</option>
            </select>
        </div>

        <div class="form-group">
            <label for="body">Body:</label>
            <textarea id="body" name="body" required></textarea>
        </div>

        <button type="submit">Send Test Email</button>
    </form>

    <div style="margin-top: 20px;">
        <h3>Current Email Configuration:</h3>
        <ul>
            <li>SMTP Host: <?php echo htmlspecialchars($config['host']); ?></li>
            <li>SMTP Port: <?php echo htmlspecialchars($config['port']); ?></li>
            <li>Encryption: <?php echo htmlspecialchars($config['encryption']); ?></li>
            <li>From Address: <?php echo htmlspecialchars($config['from_address']); ?></li>
            <li>From Name: <?php echo htmlspecialchars($config['from_name']); ?></li>
        </ul>

        <h3>Notes:</h3>
        <ul>
            <li>Make sure to update the .env file with your email settings before testing.</li>
            <li>For Gmail, use an App Password instead of your regular password.</li>
            <li>Check error logs if sending fails.</li>
        </ul>
    </div>
</body>
</html>
