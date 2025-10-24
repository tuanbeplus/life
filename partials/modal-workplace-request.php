
				<div id="workplace-request-modal" class="modal uses-simplebar" data-dismissable="1">
					
					<div class="inner">
						
						<div class="content formatted">
							
							<h2 class="modal-heading">Request a Workplace Session</h2>
							
							<form action="/" method="post" novalidate="" data-ajax-submit>
								
								<div class="form-group">
									<label for="workplace-name">Name of your workplace</label>
									<input type="text" name="company" value="" id="workplace-name" aria-required="true" required />
								</div>
								
								<div class="form-group">
									<label for="workplace-first-name">Contact person first name</label>
									<input type="text" name="first_name" value="" id="workplace-first-name" aria-required="true" required />
								</div>
								
								<div class="form-group">
									<label for="workplace-last-name">Contact person last name</label>
									<input type="text" name="last_name" value="" id="workplace-last-name" aria-required="true" required />
								</div>
								
								<div class="form-group">
									<label for="workplace-heard-about-via">How did you hear about the <em>Life!</em> program?</label>
									<input type="text" name="heard_about_via" value="" id="workplace-heard-about-via" aria-required="true" required />
								</div>
								
								<div class="form-group">
									<label for="workplace-phone">Phone</label>
									<input type="text" name="phone" value="" id="workplace-phone" aria-required="true" required />
								</div>
								
								<div class="form-group">
									<label for="workplace-email">Email</label>
									<input type="email" name="email" value="" id="workplace-email" aria-required="true" required />
								</div>
								
								<div class="form-group">
									<label for="workplace-session-dates">Proposed session dates - please provide at least two dates</label>
									<input type="text" name="session_dates" value="" id="workplace-session-dates" aria-required="true" required />
								</div>
								
								<div class="form-group">
									<label for="workplace-participants">Number of participants</label>
									<input type="number" name="participants" value="" id="workplace-participants" aria-required="true" required data-parsley-required-message="Please enter the number of participants" />
								</div>
								
								<?php /* <div class="form-group">
									<label for="workplace-session-type">Would you like a face-to-face session or a webinar? </label>
									<select name="session_type" id="workplace-session-type" aria-required="true" required>
										<option value="">Please select...</option>
										<option value="Face-to-face session">Face-to-face session</option>
										<option value="Webinar">Webinar</option>
									</select>
								</div> */ ?>
								
								<div class="form-feedback"></div>
								
								<div class="form-group close-modal">
									<button type="button" name="submit_signup" class="button grey" data-dismiss-modal aria-label="Return to site"><span>Return to Site</span></button>
								</div>
								
								<div class="form-group submit">
									<button type="submit" name="submit_workplace" class="button grey loader" aria-label="Submit enquiry">
										<?php echo life_icon('loader', null, 'life-spin loading'); ?>
										<span>Submit Enquiry</span>
									</button>
									<input type="hidden" name="action" value="life_ajax_submit_form" />
									<input type="hidden" name="form_id" value="workplaceRequest" />
								</div>
								
							</form>
						
						</div>
						<!-- /.content -->
						
					</div>
					<!-- /.inner -->
					
					<div class="dismiss-modal">
						<button type="button" class="icon" data-dismiss-modal aria-label="Dismiss modal"><?php echo life_icon('times'); ?></button>
					</div>
					
				</div>
				<!-- /#health-check-modal -->
