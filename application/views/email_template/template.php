<html lang="en">
<head>
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type">
    <title>
       SARIS | ONLINE APPLICATION
    </title>
    <style type="text/css">
        a:hover { text-decoration: none !important; }
        .header h1 {color: #fff !important; font: normal 25px Georgia, serif; margin: 0; padding: 0; line-height: 25px;}
        .header p {color: #dfa575; font: normal 11px Georgia, serif; margin: 0; padding: 0; line-height: 11px; letter-spacing: 2px}
        .content h2 {color:#8598a3 !important; font-weight: normal; margin: 0; padding: 0; font-style: italic; line-height: 20px; font-size: 20px;font-family: Georgia, serif; }
        .content p {color:#767676; font-weight: normal; margin: 0; padding: 0; line-height: 20px; font-size: 12px;font-family: Georgia, serif;}
        .content a {color: #d18648; text-decoration: none;}
        .footer p {padding: 0; font-size: 11px; color:#fff; margin: 0; font-family: Georgia, serif;}
        .footer a {color: #f7a766; text-decoration: none;}
        a{color: #d18648 !important; text-decoration: none !important; cursor: pointer !important;}
    </style>
</head>
<body style="margin: 0; padding: 0; background: #bccdd9;">
<?php
$college = get_collage_info();
?>
<table cellpadding="0" cellspacing="0" border="0" align="center" width="100%">
    <tr>
        <td align="center" style="margin: 0; padding: 0; background:#bccdd9 url('bg_email.png');padding: 35px 0">
            <table cellpadding="0" cellspacing="0" border="0" align="center" width="650" style="font-family: Georgia, serif;" class="header">
                <tr>
                    <td bgcolor="#698291" height="115" align="center">
                        <h1 style="color: #fff; font: normal 17px Georgia, serif; margin: 0; padding: 0; line-height: 33px;"><?php echo $college->Name; ?></h1>
						<p style="color: #dfa575; font: normal 15px Georgia, serif; margin: 0; padding: 0; line-height: 20px;">SARIS ONLINE APPLICATION SYSTEM</p>
			        </td>
			      </tr>
				  <tr>
					  <td style="font-size: 1px; height: 5px; line-height: 1px;" height="5">&nbsp;</td>
				  </tr>
				</table><!-- header-->

				<table cellpadding="0" cellspacing="0" border="0" align="center" width="650" style="font-family: Georgia, serif; background: #fff;" bgcolor="#ffffff">
			      <tr>
			        <td width="14" style="font-size: 0px;" bgcolor="#ffffff">&nbsp;</td>
					<td width="620" valign="top" align="left" bgcolor="#ffffff"style="font-family: Georgia, serif; background: #fff;">
						<table cellpadding="0" cellspacing="0" border="0"  style="color: #717171; font: normal 11px Georgia, serif; margin: 0; padding: 0;" width="620" class="content">
						<tr>
							<td style="padding: 25px 0 5px; border-bottom: 2px solid #d2b49b;font-family: Georgia, serif; "  valign="top" align="center">
								<h3 style="color:#767676; font-weight: normal; margin: 0; padding: 0; font-style: italic; line-height: 13px; font-size: 20px;"><?php echo $title; ?></h3>
							</td>
						</tr>
						<tr>
							<td style="padding: 25px 0 0;" align="left">
								<h2 style="color:#8598a3; font-weight: normal; margin: 0; padding: 0; font-style: italic; line-height: 20px; font-size: 20px;font-family: Georgia, serif; "><?php echo $salutation; ?></h2>
							</td>
						</tr>
						<tr>
							<td style="padding: 15px 0 15px; border-bottom: 1px solid #d2b49b;"  valign="top">
								<p style="color:#767676; font-weight: normal; margin: 0; padding: 0; line-height: 20px; font-size: 12px;font-family: Georgia, serif; ">
                               <?php echo $content; ?>
								</p>
                            </td>
						</tr>

                            <tr>
                                <td>
                                    <p style="color:#767676; font-weight: normal; margin: 0; padding: 0; line-height: 20px; font-size: 12px;font-family: Georgia, serif; ">
                                        Regards,<br/>SARIS SOFTWARE,<br/><?php echo $college->Name; ?><br/><?php echo $college->PostalAddress.' '.$college->City; ?><br/>TANZANIA

                                    </p>
                                </td>
                            </tr>

						</table>
					</td>

					<td width="16" bgcolor="#ffffff" style="font-size: 0px;font-family: Georgia, serif; background: #fff;">&nbsp;</td>
			      </tr>

				</table><!-- body -->

				<table cellpadding="0" cellspacing="0" border="0" align="center" width="650" style="font-family: Georgia, serif; line-height: 10px;" bgcolor="#698291" class="footer">
			      <tr>
			        <td bgcolor="#698291"  align="center" style="padding: 15px 0 10px; font-size: 11px; color:#fff; margin: 0; line-height: 1.2;font-family: Georgia, serif;" valign="top">
						<p style="padding: 0; font-size: 11px; color:#fff; margin: 0; font-family: Georgia, serif;"><?php echo $college->Name; ?><br/>Address : <?php echo $college->PostalAddress.' | Email : '.$college->Email .' | LandLine : '.$college->LandLine.' | Website : <a style="font-size:13px; color:#f7a766 !important;" href="'.$college->Site.'">'.$college->Site.'</a>'; ?></p>
                        <p style="padding: 0; font-size: 11px; color:#fff; margin: 0 0 8px 0; font-family: Georgia, serif;">Designed and Developed by <a style=" color:#f7a766 !important;" href="http://www.zalongwa.com">Zalongwa Technology LTD </a>.</p>
					</td>
			      </tr> 
				</table><!-- footer-->
		  	</td>
		</tr>
    </table>
  </body>
</html>