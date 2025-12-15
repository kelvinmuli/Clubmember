<!DOCTYPE html>
<html>
  <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Please confirm your e-mail</title>
    
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <style type="text/css">
      body,table,td,a{ 
      -webkit-text-size-adjust:100%;
      -ms-text-size-adjust:100%; 
      }
      table,td{
      mso-table-lspace:0pt;
      mso-table-rspace:0pt;
      }
      img{ 
      -ms-interpolation-mode:bicubic;
      }
      img{
      border:0;
      height:auto;
      line-height:100%;
      outline:none;
      text-decoration:none;
      }
      table{
      border-collapse:collapse !important;
      }
      body{
      height:100% !important;
      margin:0 !important;
      padding:0 !important;
      width:100% !important;
      }
      a[x-apple-data-detectors]{
      color:inherit !important;
      text-decoration:none !important;
      font-size:inherit !important;
      font-family:inherit !important;
      font-weight:inherit !important;
      line-height:inherit !important;
      }
      a{
      color:#00bc87;
      text-decoration:underline;
      }
      * img[tabindex=0]+div{
      display:none !important;
      }
      @media screen and (max-width:350px){
      h1{
      font-size:24px !important;
      line-height:24px !important;
      }
      }   div[style*=margin: 16px 0;]{
      margin:0 !important;
      }
      @media screen and (min-width: 360px){
      .headingMobile {
      font-size: 40px !important;
      }
      .headingMobileSmall {
      font-size: 28px !important;
      }
      }
    </style>
  </head>
  <body bgcolor="#ffffff" style="background-color: #ffffff; margin: 0 !important; padding: 0 !important;">
   <!--  <div style="display: none; font-size: 1px; color: #fefefe; line-height: 1px; font-family: "Helvetica Neue", Helvetica, Arial, sans-serif; max-height: 0px; max-width: 0px; opacity: 0; overflow: hidden;"> To finish signing up, you just need to confirm that we got your e-mail right within 48 hours. To confirm please click the VERIFY button.</div> -->
    <center>
      <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" valign="top">
        <tbody>
					<!-- Header / Logo -->
          <tr>
            <td style="padding:20px; text-align:left;">
              <!-- Replace with your logo img or plain text -->
              <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                <tr>
                  <td style="vertical-align:middle;">
                    <img src="<?=base_url($customerRow->logo)?>" alt="<?=$customerRow->full_legal_name?> logo" width="120" style="display:block;">
                  </td>
                </tr>
              </table>
            </td>
          </tr>

          <tr>
            <td>
              <table border="0" cellpadding="0" cellspacing="0" align="center" valign="top" bgcolor="#ffffff" style="padding: 0 20px !important;max-width: 500px;width: 90%;">
                <tbody>
                  <tr>
                    <td bgcolor="#ffffff" align="center" style="padding: 10px 0 0px 0;"><!--[if (gte mso 9)|(IE)]><table align="center" border="0" cellspacing="0" cellpadding="0" width="350">
											<tr>
											<td align="center" valign="top" width="350">
											<![endif]-->
                      <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 500px;border-bottom: 1px solid #e4e4e4 ;">
                        <tbody>
                          <tr>
                            
                            <td bgcolor="#ffffff" align="right" valign="middle" style="padding: 0px; color: #111111; font-family: "Helvetica Neue", Helvetica, Arial, sans-serif; font-size: 48px; font-weight: 400; line-height: 48px;padding:0 0 15px 0;"><a href="#"  style="font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;color: #797979;font-size: 12px;font-weight:400;-webkit-font-smoothing:antialiased;text-decoration: none;"></a></td>
                          </tr>
                        </tbody>
                      </table><!--[if (gte mso 9)|(IE)]></td></tr></table>
												<![endif]-->
                    </td>
                  </tr>
                  <tr>
                    <td bgcolor="#ffffff" align="center" style="padding: 0;"><!--[if (gte mso 9)|(IE)]><table align="center" border="0" cellspacing="0" cellpadding="0" width="350">
<tr>
<td align="center" valign="top" width="350">
<![endif]-->
                      <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 500px;border-bottom: 1px solid #e4e4e4;">
                        <tbody>
                          <tr>
                            <td bgcolor="#ffffff" align="left" style="padding: 20px 0 0 0; color: #666666; font-family: "Helvetica Neue", Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400;-webkit-font-smoothing:antialiased;"><br />
                                                <p class="headingMobile" style="margin: 0;color: #171717;font-size: 16px;font-weight: 200;line-height: 130%;margin-bottom:5px;">Hello <?=$full_legal_name?>,</p>
                            </td>
                          </tr>


                    <tr>
                      <td height="20"></td>
                    </tr>
                    <tr>
                      <td bgcolor="#ffffff" align="left" style="padding:0; color: #666666; font-family: Helvetica Neue, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400;-webkit-font-smoothing:antialiased;">

                          <p style="margin:0;color:#585858;font-size:14px;font-weight:400;line-height:170%;">
                            A new <?=$membershipTypeName?> Subscription has been added to your account for the <?=$club_name?>.
                          </p><br>

                          
                          <p style="margin:0;color:#585858;font-size:14px;font-weight:400;line-height:170%;"><b>Amount Due:</b>   <?=$amount?></p>
                          <p style="margin:0;color:#585858;font-size:14px;font-weight:400;line-height:170%;"><b>Due Date:</b> <?=$due_at ?? date('d M Y', strtotime($due_at)); ?></p>
                          <br>
													<p style="margin:0;color:#585858;font-size:14px;font-weight:400;line-height:170%;"><b>Notes:</b> <?=$notes ?? ''?></p>
													<br>
                          <p style="margin:0;color:#585858;font-size:14px;font-weight:400;line-height:170%;">To complete your payment:<br>
														Visit the url: <a href="https://nmra.clubmember.app/v1/login/1705386384290" target="_blank">https://nmra.clubmember.app/v1/login/1705386384290</a><br>
														Login to your ClubMember.app account with the password you just set up.<br>
														Head to the Subscriptions section.<br>
														Follow the prompts to pay securely.<br><br>

														Your support helps keep the association running smoothly, thank you!
                          </p><br>

													<p>Copyright @ 2025 New Muthaiga Residents Association</p><br>
                          
                          <p><b>Website:</b> https://newmuthaigaresidentsassociation.com</p>
                          <p><b>Email:</b> committee@newmuthaigaresidentsassociation.com</p>
												</tr>
                                                                            
											<tr>
												<td align="center">
													<table width="100%" border="0" cellspacing="0" cellpadding="0">
														<tr>
															<td align="center" style="padding: 33px 0 33px 0;">
																<table border="0" cellspacing="0" cellpadding="0" width="100%">
																	<tr>
																		<p></p>
																	
																	</tr>
																</table>
															</td>
														</tr>
													</table>
												</td>
											</tr>
										</tbody>
									</table><!--[if (gte mso 9)|(IE)]></td></tr></table>
		<![endif]-->
						</td>
						</tr>
						<tr>
          <td bgcolor="#ffffff" align="center" style="padding: 0;"><!--[if (gte mso 9)|(IE)]><table align="center" border="0" cellspacing="0" cellpadding="0" width="350">
<tr>
<td align="center" valign="top" width="350">
<![endif]-->
           
<![endif]-->
          </td>
        </tr>
      </tbody>
    </table>
            </td>
          </tr>
        </tbody>
      </table>
    </center>

  
  <script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script></body>
</html>