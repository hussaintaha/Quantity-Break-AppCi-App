<?php
// dump($themes);
?>
<div style="min-height: 500px;"  >
	<div style="--top-bar-background:#357997; --top-bar-color:rgb(255, 255, 255); --top-bar-border:rgb(196, 205, 213); --top-bar-background-lighter:hsla(198, 33%, 55%, 1); --p-frame-offset:0px;">
		<div class="Polaris-Frame Polaris-Frame--hasNav Polaris-Frame--hasTopBar" data-polaris-layer="true" data-has-navigation="true">
			<!-- div for  form-->
			<div style="--top-bar-background:#00848e; --top-bar-background-lighter:#1d9ba4; --top-bar-color:#f9fafb; --p-frame-offset:0px;">
				<div class="">
					<div class="" style="margin-bottom: 1rem">
						<div class="Polaris-Page-Header__Navigation">
							<div class="Polaris-Page-Header__BreadcrumbWrapper">
								<nav role="navigation">
									<a  href="
										<?php echo base_url().'Home/welcome?shop='.$_GET['shop'] ?>" class="Polaris-Breadcrumbs__Breadcrumb" type="button" data-polaris-unstyled="true">
										<span class="Polaris-Breadcrumbs__ContentWrapper">
											<span class="Polaris-Breadcrumbs__Icon">
												<span class="Polaris-Icon">
													<svg viewBox="0 0 20 20" class="Polaris-Icon__Svg" focusable="false" aria-hidden="true">
														<path d="M12 16a.997.997 0 0 1-.707-.293l-5-5a.999.999 0 0 1 0-1.414l5-5a.999.999 0 1 1 1.414 1.414L8.414 10l4.293 4.293A.999.999 0 0 1 12 16" fill-rule="evenodd"></path>
													</svg>
												</span>
											</span>
											<span class="Polaris-Breadcrumbs__Content">Back</span>
										</span>
									</a>
								</nav>
							</div>
						</div>
						<div class="Polaris-Page-Header__MainContent">
							<div class="Polaris-Page-Header__TitleActionMenuWrapper">
								<div>
									<div class="Polaris-Header-Title__TitleAndSubtitleWrapper">
										<div class="Polaris-Header-Title">
											<h1 class="Polaris-DisplayText Polaris-DisplayText--sizeLarge">Give feedback or request for additional feature for the app.</h1>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="Polaris-Page__Content">
						<div style="--top-bar-background:#00848e; --top-bar-background-lighter:#1d9ba4; --top-bar-color:#f9fafb; --p-frame-offset:0px;">
							<div class="Polaris-Card" style="width: 100%">
								<div class="Polaris-Card__Section">
									<div style="--top-bar-background:#00848e; --top-bar-background-lighter:#1d9ba4; --top-bar-color:#f9fafb; --p-frame-offset:0px;">
										<form method="post" id="feedback">
											<div class="Polaris-FormLayout">
												<div class="Polaris-Card__Section">
                          <div class="Polaris-FormLayout__Item">
                            <div class="">
                              <div class="Polaris-Labelled__LabelWrapper">
                                <div class="Polaris-Label">
                                  <label id="nameLabel" for="name" class="Polaris-Label__Text">Name</label>
                                </div>
                              </div>
                              <div class="Polaris-Connected">
                                <div class="Polaris-Connected__Item Polaris-Connected__Item--primary">
                                  <div class="Polaris-TextField">
                                    <input id="name" class="Polaris-TextField__Input" name="name" type="name" aria-describedby="nameHelpText" aria-labelledby="nameLabel" aria-invalid="false" aria-multiline="false" required>
                                      <div class="Polaris-TextField__Backdrop"></div>
                                    </div>
                                  </div>
                                </div>
                                <div class="Polaris-Labelled__HelpText" id="nameHelpText">
                                  <!-- <span>We’ll use this email address to contact you.</span> -->
                                </div>
                              </div>
                            </div>
														<div class="Polaris-FormLayout__Item">
															<div class="">
																<div class="Polaris-Labelled__LabelWrapper">
																	<div class="Polaris-Label">
																		<label id="emailLabel" for="email" class="Polaris-Label__Text">Email</label>
																	</div>
																</div>
																<div class="Polaris-Connected">
																	<div class="Polaris-Connected__Item Polaris-Connected__Item--primary">
																		<div class="Polaris-TextField">
																			<input id="email" class="Polaris-TextField__Input" name="email" type="email" aria-describedby="emailHelpText" aria-labelledby="emailLabel" aria-invalid="false" aria-multiline="false" required>
																				<div class="Polaris-TextField__Backdrop"></div>
																			</div>
																		</div>
																	</div>
																	<div class="Polaris-Labelled__HelpText" id="emailHelpText">
																		<span>We’ll use this email address to contact you.</span>
																	</div>
																</div>
															</div>
														<div class="Polaris-FormLayout__Item">
															<div class="">
																<div class="Polaris-Labelled__LabelWrapper">
																	<div class="Polaris-Label">
																		<label id="messageLabel" for="message" class="Polaris-Label__Text">Message</label>
																	</div>
																</div>
																<div class="Polaris-Connected">
																	<div class="Polaris-Connected__Item Polaris-Connected__Item--primary">
																		<div class="Polaris-TextField">
																			<textarea id="message" name="message" class="Polaris-TextField__Input"  aria-describedby="messageHelpText" aria-labelledby="messageLabel" aria-invalid="false" aria-multiline="false" required></textarea>
																				<div class="Polaris-TextField__Backdrop"></div>
																			</div>
																		</div>
																	</div>
																	<div class="Polaris-Labelled__HelpText" id="messageHelpText">
																		<!-- <span>We’ll use this email address to inform you on future changes to Polaris.</span> -->
																	</div>
																</div>
														</div>
															<div class="Polaris-FormLayout__Item">
																<button type="submit" class="Polaris-Button">
																	<span class="Polaris-Button__Content">
																		<span class="Polaris-Button__Text">Submit</span>
																	</span>
																</button>
															</div>
														</div>
														<span class="Polaris-VisuallyHidden">
															<button type="submit" aria-hidden="true" tabindex="-1">Submit</button>
														</span>
													</form>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>

					</div>
			</div>
</div>

</div>
</div>
