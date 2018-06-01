
		</main>

		<footer class="footer">

			<div class="footer-top">

				<div class="container">

					<div class="row">

						<div class="col-md-9">

							<div class="footer-left">

								<div class="footer-nav">

									<p class="nav-menu">
										<a href="<?php echo base_url(); ?>">Home</a>
										<!-- &nbsp; | &nbsp;
										<a href="<?php echo base_url('states'); ?>">States</a> -->
										&nbsp; | &nbsp;
										<a href="<?php echo base_url('blog'); ?>">Blog</a>
										&nbsp; | &nbsp;
										<a href="<?php echo base_url('about-us'); ?>">About Us</a>
										&nbsp; | &nbsp;
										<a href="<?php echo base_url('privacy-policy'); ?>">Privacy Policy</a>
										&nbsp; | &nbsp;
										<a href="<?php echo base_url('contact-us'); ?>">Contact Us</a>
										&nbsp; | &nbsp;
										<a href="<?php echo base_url('join-business'); ?>">Join Business</a>

									</p>

								</div>

								<br/>

								<p class="footer-text"><?php echo the_config('tag_line'); ?></p>
								<p class="footer-text"><?php echo the_config('sub_tagline'); ?></p>

							</div>

						</div>

						<div class="col-md-3">

							<div class="footer-right">

								<div class="footer-brand">
									<img src="<?php echo base_url('build/images/logo.png'); ?>" class="img-responsive" alt="" title="" />
								</div>

								<div class="social-wrap">
								
									<ul class="social-list list-inline">
										
										<li><a href="<?php echo the_config('facebook_link'); ?>"><i class="fa fa-facebook text-muted fa-fw fa-2x"></i></a></li>

										<li><a href="<?php echo the_config('googleplus_link'); ?>"><i class="fa fa-google-plus text-muted fa-fw fa-2x"></i></a></li>

										<li><a href="<?php echo the_config('twitter_link'); ?>"><i class="fa fa-twitter text-muted fa-fw fa-2x"></i></a></li>

										<li><a href="<?php echo the_config('linkedin_link'); ?>"><i class="fa fa-linkedin text-muted fa-fw fa-2x"></i></a></li>

									</ul>

								</div>

							</div>

						</div>

					</div>
						
					

				</div>

			</div>

			<div class="footer-bottom">

				<div class="container">

					<p>© <?php echo date('Y'); ?> Copyright <?php echo the_config('site_name'); ?>. <br class="visible-xs"/>All Rights Reserved.</p>

				</div>

			</div>

		</footer>

        <script type="text/javascript" src="<?php echo base_url('build/js/master-scripts.js?v=1'); ?>"></script>
        <script src="http://maps.google.com/maps/api/js?key=<?php echo the_config('gmap_apikey'); ?>" 
            type="text/javascript"></script>
        <script type="text/javascript" src="<?php echo base_url('build/js/scripts.js?v=1'); ?>"></script>

        <script type="text/javascript">

        	// START Google Map Loads
			<?php if(!empty($business)) { ?>

			var locations = [
				<?php
					$x = 0;
					foreach($business as $biz) {
						$x++;
				?>

					["<?php echo addslashes($biz->name); ?>", <?php echo $biz->latitude; ?>, <?php echo $biz->longitude; ?>, <?php echo $x; ?>],
				<?php } ?>
			];

			var map = new google.maps.Map(document.getElementById('map-overlay'), {
				
				mapTypeId: google.maps.MapTypeId.ROADMAP
			});

			var infowindow = new google.maps.InfoWindow();
			var bounds = new google.maps.LatLngBounds();

			var marker, i;

			for (i = 0; i < locations.length; i++) {  
				marker = new google.maps.Marker({
					position: new google.maps.LatLng(locations[i][1], locations[i][2]),
					map: map
				});

				bounds.extend(marker.position);

				google.maps.event.addListener(marker, 'click', (function(marker, i) {
					return function() {
						infowindow.setContent(locations[i][0]);
						infowindow.open(map, marker);
					}
				})(marker, i));
			}

			map.fitBounds(bounds);


			var listener = google.maps.event.addListener(map, "idle", function () {
			    map.setZoom(9);
			    google.maps.event.removeListener(listener);
			});

			<?php } ?>
			// END Google Map Load

        </script>

    </body>

</html>