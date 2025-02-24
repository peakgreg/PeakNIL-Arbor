<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

/**
 * Log email attempt to database
 * 
 * @param string $to_address Recipient email
 * @param string $from_address Sender email
 * @param string $from_name Sender name
 * @param string $subject Email subject
 * @param string $body Email body
 * @param bool $is_html Whether email is HTML
 * @param array $attachments Array of attachment paths
 * @param string $status 'success' or 'failed'
 * @param string $error_message Error message if failed
 * @return int|false The ID of the inserted log entry, or false on failure
 */
function log_email($to_address, $from_address, $from_name, $subject, $body, $is_html = false, $attachments = [], $status = 'success', $error_message = null) {
    global $db;
    
    try {
        $sql = "INSERT INTO email_log (
            to_address, from_address, from_name, subject, title, body, is_html, 
            attachments, status, error_message, sent_at
        ) VALUES (
            ?, ?, ?, ?, ?, ?, ?,
            ?, ?, ?, 
            ?
        )";

        $stmt = $db->prepare($sql);
        
        if (!$stmt) {
            throw new Exception("Prepare failed: " . $db->error);
        }
        
        $is_html_int = $is_html ? 1 : 0;
        $attachments_json = $attachments ? json_encode($attachments) : null;
        $sent_at = $status === 'success' ? date('Y-m-d H:i:s') : null;
        
        $stmt->bind_param("ssssssissss", 
            $to_address,
            $from_address,
            $from_name,
            $subject,
            $subject, // Use subject as title since it's required
            $body,
            $is_html_int,
            $attachments_json,
            $status,
            $error_message,
            $sent_at
        );
        
        if (!$stmt->execute()) {
            throw new Exception("Execute failed: " . $stmt->error);
        }

        $insert_id = $stmt->insert_id;
        $stmt->close();
        
        return $insert_id;
    } catch (Exception $e) {
        error_log("Error logging email: " . $e->getMessage());
        return false;
    }
}

/**
 * Send an email using the template
 * 
 * @param string $to Recipient email address
 * @param string $subject Email subject
 * @param string $title Email title
 * @param string $body Email body content
 * @param string $from_name Optional sender name
 * @return bool True if email was sent successfully, false otherwise
 */
function send_template_email($to, $subject, $title, $body, $from_name = '') {
    try {
        // Extract variables for template
        extract([
            'subject' => $subject,
            'title' => $title,
            'body' => $body
        ]);
        
        // Get template file
        ob_start();
        include dirname(__DIR__) . '/views/emails/template.php';
        $html_body = ob_get_clean();

        $mail = init_mailer();
        if (!$mail) {
            throw new Exception("Failed to initialize mailer");
        }

        if ($from_name) {
            $mail->FromName = $from_name;
        }

        $mail->addAddress($to);
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $html_body;
        $mail->AltBody = strip_tags($body);

        $success = $mail->send();
        
        // Log the email attempt
        $config = get_mail_config();
        log_email(
            $to,
            $config['from_address'],
            $from_name ?: $config['from_name'],
            $subject,
            $html_body,
            true,
            [],
            $success ? 'success' : 'failed',
            null
        );

        return $success;
    } catch (Exception $e) {
        $error_message = $e->getMessage();
        error_log("Error sending template email: " . $error_message);
        
        // Log the failed attempt
        $config = get_mail_config();
        log_email(
            $to,
            $config['from_address'],
            $from_name ?: $config['from_name'],
            $subject,
            $html_body ?? $body,
            true,
            [],
            'failed',
            $error_message
        );
        
        return false;
    }
}

/**
 * Get mail configuration from environment variables
 * 
 * @return array Mail configuration settings
 */
function get_mail_config() {
    return [
        'host' => getenv('MAIL_HOST'),
        'port' => getenv('MAIL_PORT'),
        'username' => getenv('MAIL_USERNAME'),
        'password' => getenv('MAIL_PASSWORD'),
        'encryption' => getenv('MAIL_ENCRYPTION'),
        'from_address' => getenv('MAIL_FROM_ADDRESS'),
        'from_name' => getenv('MAIL_FROM_NAME')
    ];
}

/**
 * Initialize PHPMailer with default configuration
 * 
 * @return PHPMailer Configured PHPMailer instance
 */
function init_mailer() {
    $mail = new PHPMailer(true);
    $config = get_mail_config();

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = $config['host'];
        $mail->SMTPAuth = true;
        $mail->Username = $config['username'];
        $mail->Password = $config['password'];
        $mail->SMTPSecure = $config['encryption'];
        $mail->Port = $config['port'];

        // Enable debug mode in development
        if (defined('IS_DEVELOPMENT') && IS_DEVELOPMENT) {
            $mail->SMTPDebug = SMTP::DEBUG_SERVER;
            $mail->Debugoutput = function($str, $level) {
                error_log("SMTP Debug: $str");
            };
        }

        // Default sender
        $mail->setFrom($config['from_address'], $config['from_name']);

        return $mail;
    } catch (Exception $e) {
        error_log("Error initializing mailer: " . $e->getMessage());
        return false;
    }
}

/**
 * Send a basic email
 * 
 * @param string $to Recipient email address
 * @param string $subject Email subject
 * @param string $body Email body
 * @param string $from_name Optional sender name
 * @return bool True if email was sent successfully, false otherwise
 */
function send_email($to, $subject, $body, $from_name = '') {
    try {
        $mail = init_mailer();
        if (!$mail) {
            throw new Exception("Failed to initialize mailer");
        }

        if ($from_name) {
            $mail->FromName = $from_name;
        }

        $mail->addAddress($to);
        $mail->Subject = $subject;
        $mail->Body = $body;

        $success = $mail->send();
        
        // Log the email attempt
        $config = get_mail_config();
        log_email(
            $to,
            $config['from_address'],
            $from_name ?: $config['from_name'],
            $subject,
            $body,
            false,
            [],
            $success ? 'success' : 'failed'
        );

        return $success;
    } catch (Exception $e) {
        $error_message = $e->getMessage();
        error_log("Error sending email: " . $error_message);
        
        // Log the failed attempt
        $config = get_mail_config();
        log_email(
            $to,
            $config['from_address'],
            $from_name ?: $config['from_name'],
            $subject,
            $body,
            false,
            [],
            'failed',
            $error_message
        );
        
        return false;
    }
}

/**
 * Send an HTML email
 * 
 * @param string $to Recipient email address
 * @param string $subject Email subject
 * @param string $html_body HTML content
 * @param string $alt_body Optional plain text alternative
 * @param string $from_name Optional sender name
 * @return bool True if email was sent successfully, false otherwise
 */
function send_html_email($to, $subject, $html_body, $alt_body = '', $from_name = '') {
    try {
        $mail = init_mailer();
        if (!$mail) {
            throw new Exception("Failed to initialize mailer");
        }

        if ($from_name) {
            $mail->FromName = $from_name;
        }

        $mail->addAddress($to);
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $html_body;
        $mail->AltBody = $alt_body ?: strip_tags($html_body);

        $success = $mail->send();
        
        // Log the email attempt
        $config = get_mail_config();
        log_email(
            $to,
            $config['from_address'],
            $from_name ?: $config['from_name'],
            $subject,
            $html_body,
            true,
            [],
            $success ? 'success' : 'failed'
        );

        return $success;
    } catch (Exception $e) {
        $error_message = $e->getMessage();
        error_log("Error sending HTML email: " . $error_message);
        
        // Log the failed attempt
        $config = get_mail_config();
        log_email(
            $to,
            $config['from_address'],
            $from_name ?: $config['from_name'],
            $subject,
            $html_body,
            true,
            [],
            'failed',
            $error_message
        );
        
        return false;
    }
}

/**
 * Send an email with attachments
 * 
 * @param string $to Recipient email address
 * @param string $subject Email subject
 * @param string $body Email body
 * @param array $attachments Array of file paths to attach
 * @param bool $is_html Whether the body is HTML
 * @param string $from_name Optional sender name
 * @return bool True if email was sent successfully, false otherwise
 */
function send_email_with_attachments($to, $subject, $body, $attachments = [], $is_html = false, $from_name = '') {
    try {
        $mail = init_mailer();
        if (!$mail) {
            throw new Exception("Failed to initialize mailer");
        }

        if ($from_name) {
            $mail->FromName = $from_name;
        }

        $mail->addAddress($to);
        
        if ($is_html) {
            $mail->isHTML(true);
            $mail->AltBody = strip_tags($body);
        }
        
        $mail->Subject = $subject;
        $mail->Body = $body;

        // Add attachments
        $valid_attachments = [];
        foreach ($attachments as $attachment) {
            if (file_exists($attachment)) {
                $mail->addAttachment($attachment);
                $valid_attachments[] = $attachment;
            }
        }

        $success = $mail->send();
        
        // Log the email attempt
        $config = get_mail_config();
        log_email(
            $to,
            $config['from_address'],
            $from_name ?: $config['from_name'],
            $subject,
            $body,
            $is_html,
            $valid_attachments,
            $success ? 'success' : 'failed'
        );

        return $success;
    } catch (Exception $e) {
        $error_message = $e->getMessage();
        error_log("Error sending email with attachments: " . $error_message);
        
        // Log the failed attempt
        $config = get_mail_config();
        log_email(
            $to,
            $config['from_address'],
            $from_name ?: $config['from_name'],
            $subject,
            $body,
            $is_html,
            $valid_attachments ?? [],
            'failed',
            $error_message
        );
        
        return false;
    }
}
