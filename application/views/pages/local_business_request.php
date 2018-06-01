<div class="localbizreq-content">

	<section class="section-header parallax" data-parallax="scroll" data-image-src="<?php echo base_url('build/images/banner-join-2.jpg'); ?>">

    	<div class="overlay">

	    	<div class="container">

	    		<h1 class="page-title"><?php echo $page->title; ?></h1>

	    	</div>

	    </div>

    </section>

    <section class="section-localbizreq-page">

    	<div class="container">

    		<div class="row">

    			<div class="col-md-6 col-md-offset-3">

					<div class="section-content">

						<div class="content-wrap">
		    				
							<div class="content-header">

								<?php echo $page->content; ?>

							</div>

							<span class="line center-block"></span>

							<div class="form-wrap">

								<form class="submit-biz" method="post" action="<?php echo base_url('business/post/process'); ?>" enctype="multipart/form-data">

									<div class="row">

										<div class="col-md-12">
											<div class="form-group">
												<label for="exampleInputFile">Business Photo</label>
												<input type="file" class="biz_photo" name="photo" accept=".jpg, .jpeg, .png" onchange="readURL(this);" required />
												<p class="help-block">Format .jpg .jpeg and .png only.</p>
												<button type="button" class="btn btn-xs btn-warning remove-preview" style="display:none;">Remove</button>
												<img class="img-responsive preview" src="" />
											</div>
										</div>

										<div class="col-md-12">
											<div class="form-group">
												<label>Business Name *</label>
												<input type="text" class="form-control input-lg biz_name" name="name" placeholder="Business Name" required/>
											</div>
										</div>

										<div class="col-md-12">
											<div class="form-group">
												<label>Industry *</label>
												<select class="form-control input-lg" name="industry" required>
													<option value="" disabled selected>Select Industry</option>
													<?php foreach(industry() as $type) { ?>
													<option value="<?php echo $type->id; ?>" data-slug="<?php echo $type->slug; ?>"><?php echo $type->industry; ?></option>
													<?php } ?>
												</select>
											</div>
										</div>

										<div class="col-md-12">
											<div class="form-group">
												<label>City *</label>
												<input type="text" class="form-control input-lg biz_city" name="city" placeholder="City" required/>
											</div>
										</div>

										<div class="col-md-6">
											<div class="form-group">
												<label>State *</label>
												<input type="text" class="form-control input-lg biz_state" name="state" placeholder="State Abbreviation" maxlength="2" required/>
											</div>
										</div>

										<div class="col-md-6">
											<div class="form-group">
												<label>Zip Code *</label>
												<input type="text" class="form-control input-lg biz_zip" name="zip" placeholder="Zip Code" maxlength="5" required/>
											</div>
										</div>

										<div class="col-md-12">
											<div class="form-group">
												<label>Email Address *</label>
												<input type="email" class="form-control input-lg biz_email" name="email" placeholder="Email Address" required/>
											</div>
										</div>

										<div class="col-md-12">
											<div class="form-group">
												<label>Contact Number *</label>
												<input type="text" class="form-control input-lg biz_contact" name="contact" placeholder="Contact Number" required/>
											</div>
										</div>

										<div class="col-md-12">
											<div class="form-group">
												<div class="g-recaptcha" data-sitekey="<?php echo $gr_data['site_key']; ?>"></div>
											</div>
										</div>

										<div class="col-md-12">
											<div class="form-group">
												<button type="submit" class="btn btn-success btn-lg submit-biz-btn">Submit <i class="fa fa-paper-plane"></i></button>

											</div>
										</div>

									</div>

									
								</form>

							</div>

		    			</div>

					</div>

				</div>

			</div>

		</div>

    </section>

</div>