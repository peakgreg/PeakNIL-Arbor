<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $subject; ?></title>
  <!--[if mso]>
    <style>
        table {border-collapse:collapse;border-spacing:0;margin:0;}
        div, td {padding:0;}
        div {margin:0 !important;}
    </style>
    <noscript>
    <xml>
        <o:OfficeDocumentSettings>
            <o:PixelsPerInch>96</o:PixelsPerInch>
        </o:OfficeDocumentSettings>
    </xml>
    </noscript>
    <![endif]-->
</head>

<body style="margin:0;padding:0;background-color:#f5f5f5;">
  <!-- Outer wrapper table -->
  <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:#f5f5f5;">
    <tr>
      <td align="center" style="padding:40px 0;">
        <!-- Content wrapper table -->
        <table role="presentation" width="600" cellpadding="0" cellspacing="0" border="0"
          style="background-color:#ffffff;border-radius:22px;max-width:600px;width:100%;">
          <tr>
            <td style="padding:40px 40px 20px 40px;">
              <!-- Logo -->
              <img src="<?= EMAIL_LOGO ?>" alt="<?= SITE_NAME ?> Logo" width="150"
                style="display:block; border:0;" />
            </td>
          </tr>
          <tr>
            <td style="padding:10px 40px 40px 40px;">
              <!-- Your content goes here -->
              <h2 style="color:#333333;font-family:Arial,sans-serif;margin:0 0 20px 0;font-size:20px;">
                <?= $title ?>
              </h2>
              <p style="color:#666666;font-family:Arial,sans-serif;font-size:16px;line-height:24px;margin:0;">
                <?= $body ?>
              </p>
            </td>
          </tr>
        </table>

        <!-- Divider Line -->
        <table role="presentation" width="580" cellpadding="0" cellspacing="0" border="0"
          style="max-width:580px;width:100%;margin-top:20px;">
          <tr>
            <td style="border-top:1px solid #cccccc;padding-top:10px;"></td>
          </tr>
        </table>

        <!-- Social Media Links -->
        <table role="presentation" width="580" cellpadding="0" cellspacing="0" border="0"
          style="max-width:580px;width:100%;text-align:center;">
          <tr>
            <td style="padding:0;">
              <a href="<?= INSTAGRAM_URL ?>" target="_blank" style="margin:0 10px;display:inline-block;">
                <img src="https://cdn.peaknil.com/public/logos/social_media/outline-instagram.png" alt="Instagram" width="24"
                  style="display:block;border:0;vertical-align:middle;">
              </a>
              <a href="<?= X_URL ?>" target="_blank" style="margin:0 10px;display:inline-block;">
                <img src="https://cdn.peaknil.com/public/logos/social_media/outline-x.png" alt="X Icon" width="24"
                  style="display:block;border:0;vertical-align:middle;">
              </a>
              <a href="<?= TIKTOK_URL ?>" target="_blank" style="margin:0 10px;display:inline-block;">
                <img src="https://cdn.peaknil.com/public/logos/social_media/outline-tiktok.png" alt="TikTok Icon" width="24"
                  style="display:block;border:0;vertical-align:middle;">
              </a>
              <a href="<?= FACEBOOK_URL ?>" target="_blank" style="margin:0 10px;display:inline-block;">
                <img src="https://cdn.peaknil.com/public/logos/social_media/outline-facebook.png" alt="Facebook Icon" width="24"
                  style="display:block;border:0;vertical-align:middle;">
              </a>
            </td>
          </tr>
        </table>

        <!-- Divider Line -->
        <table role="presentation" width="580" cellpadding="0" cellspacing="0" border="0"
          style="max-width:580px;width:100%;margin-top:10px;">
          <tr>
            <td style="border-top:1px solid #cccccc;"></td>
          </tr>
        </table>

        <!-- Quick Links -->
        <table role="presentation" width="580" cellpadding="0" cellspacing="0" border="0"
          style="max-width:580px;width:100%;margin-top:20px;">
          <tr>
            <td align="left" style="padding-top: 10px;">
              <a href="<?= ABOUT_URL ?>" target="_blank"
                style="color:#0066cc;font-family:Arial,sans-serif;font-size:14px;text-decoration:none;padding:0 10px;">About
                Us</a>
              |
              <a href="<?= CONTACT_URL ?>" target="_blank"
                style="color:#0066cc;font-family:Arial,sans-serif;font-size:14px;text-decoration:none;padding:0 10px;">Contact</a>
              |
              <a href="<?= PRIVACY_URL ?>" target="_blank"
                style="color:#0066cc;font-family:Arial,sans-serif;font-size:14px;text-decoration:none;padding:0 10px;">Privacy
                Policy</a>
              |
              <a href="<?= UNSUBSCRIBE_URL ?>" target="_blank"
                style="color:#0066cc;font-family:Arial,sans-serif;font-size:14px;text-decoration:none;padding:0 10px;">Unsubscribe</a>
            </td>
          </tr>
        </table>

        <!-- Disclaimer text -->
        <table role="presentation" width="560" cellpadding="0" cellspacing="0" border="0"
          style="max-width:560px;width:100%;margin-top:10px;">
          <tr>
            <td style="padding-top: 10px; text-align:justify;">
              <p style="color:#999999;font-family:Arial,sans-serif;font-size:12px;line-height:18px;margin:0;">
                This email and any files transmitted with it are confidential and intended solely for the use of the
                individual or entity to whom they are addressed. If you have received this email in error, please notify <?= SITE_EMAIL ?>.

                <br><br>
                <b><?= FULL_COMPANY_NAME ?></b><br>
                <?= COMPANY_ADDRESS ?><br>
                <?= COMPANY_CITY ?>, <?= COMPANY_STATE ?> <?= COMPANY_ZIP ?>
                <br><br>
                Copyright © <?= FULL_COMPANY_NAME ?>
              </p>
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
</body>

</html>
