<?php
// don't load directly
if ( !defined('ABSPATH') )
    die('-1');

if ( !isset( $email_vars ) ) {
    global $email_vars;
}
if ( !isset( $email_heading ) ) {
    global $email_heading;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta name="viewport" content="width=device-width" />
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&display=swap" rel="stylesheet">
</head>

<body style="background: #F1F1F1; font-family: 'Inter', Helvetica, sans-serif;">
	<table border="0" cellpadding="0" cellspacing="0" width="100%">
		<tr>
			<td height="60" style="height: 60px; line-height: 60px;"> </td>
		</tr>
		<tr>
			<td align="center">
				<!-- Content -->
				<table border="0" cellpadding="0" cellspacing="0" width="600">
					<tr>
						<td bgcolor="#ffffff">
							<table border="0" cellpadding="0" cellspacing="0" width="600">
								<tr>
									<td colspan="3" height="50" style="height: 50px; line-height: 50px;">&nbsp;</td>
								</tr>
								<tr>
									<td width="50" style="width: 50px;"> </td>
									<td width="500" style="font-size:16px;font-weight:normal;line-height:24px;font-family:'Inter',Helvetica,sans-serif">
										<!-- Text content -->
                                        <?php if ( !empty( $email_heading ) ) { ?>
										<p style="margin: 0; padding: 0; font-size: 40px; font-weight: bold; line-height: 40px; font-family: 'Inter', Helvetica, sans-serif;"><?= $email_heading ?></p>
                                        <?php } ?>
										