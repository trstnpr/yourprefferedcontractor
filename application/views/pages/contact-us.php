<div class="contactus-content">

	<section class="section-header parallax" data-parallax="scroll" data-image-src="<?php echo base_url('build/images/banner-contact-2.jpg'); ?>">

    	<div class="overlay">

	    	<div class="container">

	    		<h1 class="page-title"><?php echo $page->title; ?></h1>

	    	</div>

	    </div>

    </section>

    <section class="section-page">

    	<div class="container">

    		<div class="row">

    			<div class="col-md-6 col-md-offset-3">

					<div class="section-content">

						<div class="content-wrap">

							<div class="content-header">
								<?php echo $page->content; ?>
							</div>

							<div class="social-wrap">
								
								<ul class="social-list list-inline">
									
									<li><a href="<?php echo the_config('facebook_link'); ?>"><i class="fa fa-facebook text-muted fa-fw fa-2x"></i></a></li>

									<li><a href="<?php echo the_config('googleplus_link'); ?>"><i class="fa fa-google-plus text-muted fa-fw fa-2x"></i></a></li>

									<li><a href="<?php echo the_config('twitter_link'); ?>"><i class="fa fa-twitter text-muted fa-fw fa-2x"></i></a></li>

									<li><a href="<?php echo the_config('linkedin_link'); ?>"><i class="fa fa-linkedin text-muted fa-fw fa-2x"></i></a></li>

								</ul>

							</div>

							<span class="line center-block"></span>

							<div class="form-wrap">

								<form class="form-contact" method="post" action="<?php echo base_url('contact/send'); ?>">

									<div class="form-group">
										<label>Name *</label>
										<input type="text" class="form-control input-lg name" name="name" placeholder="Your Name ..." required />
									</div>

									<div class="form-group">
										<label>Email *</label>
										<input type="email" class="form-control input-lg email" name="email" placeholder="Your Email ..." required />
									</div>

									<div class="form-group">
										<label>Subject *</label>
										<input type="text" class="form-control input-lg subject" name="subject" placeholder="Your Subject ..." required />
									</div>

									<div class="form-group">
										<label>Message *</label>
										<textarea type="text" class="form-control input-lg message" name="message" rows="5" placeholder="Your Message ..." required ></textarea>
									</div>

									<div class="form-group">
										<div class="g-recaptcha" data-sitekey="<?php echo $gr_data['site_key']; ?>"></div>
									</div>

									<div class="form-group">
										<button type="submit" class="btn btn-success btn-lg btn-send">Send <i class="fa fa-paper-plane"></i></button>
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