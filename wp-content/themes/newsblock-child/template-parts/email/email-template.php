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
                                        <?= $args['content'] ?>
                                        <!-- Text content end -->
                                    </td>
									<td width="50" style="width: 50px;"> </td>
								</tr>
								<tr>
									<td colspan="3" height="50" style="height: 50px; line-height: 50px;">&nbsp;</td>
								</tr>
							</table>
						</td>
					</tr>
                    <!-- Footer -->
                    <tr>
                        <td bgcolor="#000000" style="color: #ffffff">
                            <table border="0" cellpadding="0" cellspacing="0" width="600">
                                <tr>
                                    <td colspan="3" height="50" style="height: 50px; line-height: 50px;">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td width="50" style="width: 50px;"> </td>
                                    <td width="500">
                                        <table border="0" cellpadding="0" cellspacing="0" width="500">
                                            <tr>
                                                <td width="140" valign="middle">
                                                    <img width="140" height="26" border="0" alt="Logo" src="<?= get_stylesheet_directory_uri() ?>/images/email/logo.png" style="display:block" />
                                                </td>
                                                <td width="50" valign="middle">&nbsp;</td>
                                                <td width="310" valign="middle" style="font-size: 12px; font-weight: normal; line-height: 16px; font-family: 'Inter', Helvetica, sans-serif;">
                                                    Доступно и интересно рассказываем о технологиях, бизнесе и репутации в новой <nobr>Web3-экономике</nobr>.
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="3" height="20" width="100%">&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td width="140" valign="middle">
                                                    <table border="0" cellpadding="0" cellspacing="0" width="138">
                                                        <tr>
                                                            <td width="30">
                                                                <a href="https://twitter.com/trianulla"><img src="<?= get_stylesheet_directory_uri() ?>/images/email/tw.png" alt="Twitter" width="30" height="30" style="display: block;" /></a>
                                                            </td>
                                                            <td width="6">&nbsp;</td>
                                                            <td width="30">
                                                                <a href="https://t.me/trianulla"><img src="<?= get_stylesheet_directory_uri() ?>/images/email/tg.png" alt="Telegram" width="30" height="30" style="display: block;" /></a>
                                                            </td>
                                                            <td width="6">&nbsp;</td>
                                                            <td width="30">
                                                                <a href="https://vk.com/"><img src="<?= get_stylesheet_directory_uri() ?>/images/email/vk.png" alt="VK" width="30" height="30" style="display: block;" /></a>
                                                            </td>
                                                            <td width="6">&nbsp;</td>
                                                            <td width="30">
                                                                <a href="https://www.linkedin.com/in/"><img src="<?= get_stylesheet_directory_uri() ?>/images/email/in.png" alt="Linkedin" width="30" height="30" style="display: block;" /></a>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                                <td width="50" valign="middle">&nbsp;</td>
                                                <td width="310" valign="middle" style="font-size: 12px; font-weight: normal; line-height: 16px; font-family: 'Inter', Helvetica, sans-serif;">
                                                    &nbsp;
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td width="50" style="width: 50px;"> </td>
                                </tr>
                                <tr>
                                    <td colspan="3" height="50" style="height: 50px; line-height: 50px;">&nbsp;</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <!-- Footer end -->
				</table>
				<!-- Content end -->
			</td>
		</tr>
		<tr>
			<td height="60" style="height: 60px; line-height: 60px;"> </td>
		</tr>
	</table>
</body>

</html>