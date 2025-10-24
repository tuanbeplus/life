<?php
$domain = $_SERVER['HTTP_HOST'];

switch ( true ) {
	case ($data['risk_score'] >= 6 && $data['risk_score'] < 11):
		$risk_level = 'medium';
		break;
	case ($data['risk_score'] >= 11):
		$risk_level = 'high';
		break;
	default:
		$risk_level = 'low';
		break;
}
?>
<center>
	<table style="font-family: arial; border-collapse: collapse; border-spacing: 0px; color: #464646; width: 679px;" cellpadding="0">
		<tbody>
			<tr>
				<td>
					<img src="<?php echo get_template_directory_uri(); ?>/images/email/email-logo.jpg" alt=""/>
				</td>
			</tr>
			<tr>
				<td height="15">&nbsp;</td>
			</tr>
			<tr style="background: #f68d27;">
				<td style="padding: 8px 14px;">
					<table>
						<tbody>
							<tr>
								<td width="54">
									<img src="<?php echo get_template_directory_uri(); ?>/images/email/risk-mark.png" alt=""/>
								</td>
								<td style="font-size: 20px; color: #ffffff; font-family: arial;">Your score is <?php echo $data['risk_score']; ?> and your risk level is <?php echo $risk_level; ?></td>
							</tr>
						</tbody>
					</table>
				</td>
			</tr>
			<tr>
				<td>
					<?php if ( $data['risk_score'] >= 6 ) { ?>
					<img src="<?php echo get_template_directory_uri(); ?>/images/email/med-highrisk.jpg" alt=""/>
					<?php } else { ?>
					<img src="<?php echo get_template_directory_uri(); ?>/images/email/lowrisk.jpg" alt=""/>
					<?php } ?>
				</td>
			</tr>
			<tr>
				<td height="35">&nbsp;</td>
			</tr>
			<tr>
				<td style="font-size: 22px; font-weight: bold; color: #8ec449;">Thanks for taking the AUSDRISK test at <a style="color: #8ec449;" href="https://<?php echo $domain; ?>" target="_blank" rel="noopener">www.lifeprogram.org.au</a></td>
			</tr>
			<tr>
				<td>
					<table style="font-family: arial; font-weight: bold; color: #464646;">
						<tbody>
							<tr>
								<td height="20">&nbsp;</td>
							</tr>
							<tr>
								<td valign="middle" width="20">
									<img src="<?php echo get_template_directory_uri(); ?>/images/email/bullet.png" alt=""/>
								</td>
								<td style="font-size: 20px;">For scores of 6-8, approximately one person in every 50 will develop diabetes in the next five years.</td>
							</tr>
							<tr>
								<td height="20">&nbsp;</td>
							</tr>
							<tr>
								<td valign="middle" width="20">
									<img src="<?php echo get_template_directory_uri(); ?>/images/email/bullet.png" alt=""/>
								</td>
								<td style="font-size: 20px;">For scores of 9-11, approximately one person in every 30 will develop diabetes in the next five years.</td>
							</tr>
							<tr>
								<td height="20">&nbsp;</td>
							</tr>
						</tbody>
					</table>
				</td>
			</tr>
			<tr>
				<td style="font-size: 14px; padding-bottom: 23px;">Although you are not at immediate risk of developing type 2 diabetes, without taking action to improve your health now, you may find yourself at risk in the future. It's important to discuss your diabetes risk score with your doctor for advice on how to reduce your risk.</td>
			</tr>
			<tr>
				<td><strong>You may also be eligible for the <em>Life!</em> program.</strong> This FREE healthy lifestyle program is run by health professionals and you'll learn more about nutrition, physical activity, sleep, stress and goal setting. You can choose to do a group course in your local area or telephone health coaching. The <em>Life!</em> program gives you the motivation and support you need to make and maintain a healthier lifestyle.</td>
			</tr>
			<tr>
				<td height="20">&nbsp;</td>
			</tr>
			<tr>
				<td>Call 13 RISK (13 74 75) or email&nbsp;<a href="mailto:life@diabetesvic.org.au">life@diabetesvic.org.au</a> to discuss the program and your eligibility. The <em>Life!</em> team is passionate about people and their health and we're here to help you.</td>
			</tr>
			<tr>
				<td height="20">&nbsp;</td>
			</tr>
			<tr>
				<td>There are also many other services out there to help you make small changes to your health to <a href="https://<?php echo $domain; ?>/living-well/helpful-links">reduce your risk.</a> You can also join us on <a href="https://www.facebook.com/pages/Life-Helping-you-prevent-diabetes-heart-disease-and-stroke/82660007866">Facebook</a> and <a style="color: #464646;" href="https://www.instagram.com/thelifeprogram_/" target="_blank" rel="noopener">Instagram</a> to hear the latest in health news.</td>
			</tr>
			<tr>
				<td height="20">&nbsp;</td>
			</tr>
			<tr>
				<td style="font-size: 14px; padding-bottom: 30px;">Please encourage your friends and family to take the AUSDRISK test too.</td>
			</tr>
			<tr>
				<td style="font-size: 14px;">Yours in good health,</td>
			</tr>
			<tr>
				<td style="font-size: 16px; font-weight: bold; color: #f57b20; padding-bottom: 40px;">The <em>Life!</em> team</td>
			</tr>
			<tr>
				<td>
					<table style="font-family: arial; border-collapse: collapse; border-spacing: 0px; color: #464646; border-top-width: 4px; border-top-style: solid; border-top-color: #c6e29f; font-size: 14px; table-layout: fixed; width: 679px; background: #f0f0f0;" cellpadding="0">
						<tbody>
							<tr>
								<td style="padding: 30px 20px 5px 20px;">
									<span style="font-weight: bold; color: #8dc63f; padding-left: 15px;">Infoline</span>
									<strong>13 RISK (13 7475)</strong>
								</td>
							</tr>
							<tr>
								<td style="padding: 0 20px 30px 20px;"><strong>T</strong> 03 8648 1880 <strong style="padding-left: 15px;">F</strong> 03 9667 1757 <strong style="padding-left: 15px;">E</strong> life@diabetesvic.org.au</td>
							</tr>
						</tbody>
					</table>
				</td>
			</tr>
		</tbody>
	</table>
</center>