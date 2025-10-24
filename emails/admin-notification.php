<?php
$domain = $_SERVER['HTTP_HOST'];
?>
<center>
	<table style="font-family: arial; border-collapse: collapse; border-spacing: 0px; color: #464646; width: 679px;" cellpadding="0">
		<tbody>
			<tr>
				<td colspan="2">
					<img src="<?php echo get_template_directory_uri(); ?>/images/email/email-logo.jpg" alt=""/>
				</td>
			</tr>
			<tr>
				<td height="15" colspan="2">&nbsp;</td>
			</tr>
			<tr style="background: #f68d27;">
				<td style="padding: 8px 14px;" colspan="2">
					<table>
						<tbody>
							<tr>
								<td style="font-size: 20px; color: #ffffff; font-family: arial;"><?php echo $data['form_name']; ?></td>
							</tr>
						</tbody>
					</table>
				</td>
			</tr>
			<tr>
				<td height="35" colspan="2">&nbsp;</td>
			</tr>
			<?php
			foreach($data['data'] as $index => $value) {

				if($index != 'recaptcha' && $index != 'form_id' && $index != 'action' && $index != 'qty_dummy') {?>
				<tr>
					<td style="font-size: 14px; font-weight: bold; color: #000000;padding-right: 10px; width: 300px; padding-bottom: 15px;">
					<?php

						if(isset($data['fields'][$index]['sf'])) {

							if(isset($data['labels'][$data['fields'][$index]['sf']])) {
								echo $data['labels'][$data['fields'][$index]['sf']];
							} else {
								echo $data['fields'][$index]['sf'];
							}

						} else {

							// Check if it's the message field
							if(isset($data['labels'][$index])) {
								echo $data['labels'][$index];
							} else {
								echo $index;
							}
						}

					?></td>
					<td style="font-size: 14px; color: #000000;padding-left:10px; padding-bottom: 15px;">
					<?php
						if($index == 'qty') {
							$resources = life_resource_entries();

							?>

							<table style="font-family: arial; border-spacing: 0px; color: #464646;" cellpadding="0">
								<thead>
									<tr>
										<th style="font-size: 14px; color: #000000;text-align:left;width:100%;padding-top:10px;padding-bottom:10px;background: #f68d27;padding-left:10px;">Item name</th>
										<th style="font-size: 14px; color: #000000;text-align:center;width:100%;padding-left:10px;padding-right:10px;padding-top:10px;padding-bottom:10px;background: #f68d27;">Qty</th>
									</tr>
								</thead>
								<tbody>
									<tbody>
										<?php
										foreach ( $value as $resource_id => $qty ) {
											if ( ($qty > 0) && isSet($resources[$resource_id]) ) {
										?>
										<tr>
											<td style="font-size: 14px; color: #000000;border-bottom:1px solid #f68d27;padding-top:10px;padding-bottom:10px;padding-left:10px;">
												<?php
												echo $data['resources'][$resource_id]['title'];
												if(!empty($data['resources'][$resource_id]['content'])) {
																echo "<br><small>({$data['resources'][$resource_id]['content']})</small>";
												}
												?>
											</td>
											<td style="font-size: 14px; color: #000000;text-align:center;padding-left:10px;padding-right:10px;border-bottom:1px solid #f68d27;padding-top:10px;padding-bottom:10px;"><b><?php echo $qty ?></b></td>
										</tr>
										<?php
											}
										}
										?>
									</tbody>
								</tbody>
							</table>

							<?php
						} else {
							echo $value;
						}

					 ?></td>
				</tr>
			<?php
				}
			}
			?>

			<tr>
				<td height="20">&nbsp;</td>
			</tr>

		</tbody>
	</table>
</center>