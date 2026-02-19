<!-- Newsletter email template -->
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>{{newsletter_title}}</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Preheader: shown in inbox preview (best kept short) -->
  <style>
    /* Prevent some clients from adding default styles */
    body { margin:0; padding:0; -webkit-text-size-adjust:100%; -ms-text-size-adjust:100%; }
    table { border-collapse:collapse; }
    img { border:0; height:auto; line-height:100%; outline:none; text-decoration:none; display:block; }
    a[x-apple-data-detectors] { color:inherit !important; text-decoration:none !important; }
    /* Responsive */
    @media only screen and (max-width:600px) {
      .container { width:100% !important; }
      .stack { display:block !important; width:100% !important; }
      .title { font-size:24px !important; }
      .description { font-size:16px !important; }
      .btn { width:100% !important; }
    }
  </style>
</head>
<body style="background-color:#f3f4f6; padding:16px;">


  <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="max-width:700px; margin:0 auto;" class="container">
    <tr>
      <td align="center" style="padding:20px 0;">
        <!-- Card -->
        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#ffffff; border-radius:8px; overflow:hidden; box-shadow:0 2px 6px rgba(0,0,0,0.08);">
          <!-- Header / Logo -->
          <tr>
            <td style="padding:20px; text-align:left;">
              <!-- Replace with your logo img or plain text -->
              <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                <tr>
                  <td style="vertical-align:middle;">
                    <img src="<?=base_url($customerRow->logo)?>" alt="<?=$customerRow->full_legal_name?> logo" width="120" style="display:block;">
                  </td>
                  <td style="text-align:right; vertical-align:middle; font-size:12px; color:#6b7280;">
                    <?=date('F j, Y', strtotime($newsletterRow->created_at))?>
                  </td>
                </tr>
              </table>
            </td>
          </tr>

          <!-- Hero / Title -->
          <tr>
            <td style="padding:0 20px 10px 20px;">
              <h1 class="title" style="margin:0; font-family:Arial, Helvetica, sans-serif; font-size:16px; line-height:34px; color:#0f172a;">
                <?=$newsletterRow->name?>
              </h1>
            </td>
          </tr>

					<!-- Optional image -->
          <tr>
            <td style="padding:0 20px 20px 20px;">
              <img src="<?=base_url($newsletterRow->thumbnail_url)?>" alt="<?=$newsletterRow->name?>" width="100%" style="border-radius:6px; max-width:660px;">
            </td>
          </tr>

          <!-- Short description -->
          <tr>
            <td style="padding:0 20px 20px 20px;">
              <p class="description" style="margin:0; font-family:Arial, Helvetica, sans-serif; font-size:14px; line-height:24px; color:#374151;">
                <?=$newsletterRow->summary?>
              </p>
            </td>
          </tr>

          <!-- Read more button -->
          <tr>
            <td style="padding:0 20px 30px 20px;">
              <table role="presentation" cellpadding="0" cellspacing="0" align="left">
                <tr>
                  <td align="center">
                    <!-- Button link -->
                    <a href="https://<?=$customerDBSettingRow->host?>.clubmember.app/v1" class="btn" target="_blank" style="display:inline-block; text-decoration:none; font-family:Arial, Helvetica, sans-serif; font-size:14px; padding:12px 22px; border-radius:6px; background:#2563eb; color:#ffffff; font-weight:600;"> Read More</a>
                  </td>
                </tr>
              </table>
            </td>
          </tr>

          <!-- Divider -->
          <tr>
            <td style="padding:0 20px;">
              <hr style="border:none; border-top:1px solid #eef2f7; margin:0;">
            </td>
          </tr>

          <!-- Footer / small print -->
          <tr>
            <td style="padding:16px 20px 28px 20px; color:#6b7280; font-family:Arial, Helvetica, sans-serif; font-size:13px; line-height:18px;">
              <p style="margin:0 0 8px 0;">
               <strong><?=$customerRow->full_legal_name?></strong>
              </p>
              <p style="margin:0;">
                If you have any questions or need help, feel free to reach out.
              </p>
							<p>Copyright @ 2026 <?=$customerRow->full_legal_name?>. All rights reserved.</p><br>
                                                
              <p><b>Website:</b> <?=$customerRow->website?></p>
							<p><b>Email:</b> <?=$customerRow->email?></p>
            </td>
          </tr>
        </table>
        <!-- End Card -->
      </td>
    </tr>
  </table>

</body>
</html>
