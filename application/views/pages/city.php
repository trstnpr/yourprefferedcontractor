<?php
	$state_img = (!file_exists(APPPATH.'../build/images/states/'.$state->abbrev.'.jpg')) ? base_url('build/images/states/place-statecity.jpeg') : base_url('build/images/states/'.$state->abbrev.'.jpg');
?>


<section class="city-content">

    <section class="section-header parallax" data-parallax="scroll" data-image-src="<?php echo $state_img; ?>">

    	<div class="overlay">

	    	<div class="container">

	    		<h1 class="page-title">
	    			Looking For The Best <?php echo $industry_data->label; ?> In
	    			<span class="txt-inblock"><?php echo $city_data->name.', '.strtoupper($city_data->state); ?>?</span>
	    			<a href="tel:<?php echo $city_data->phone; ?>" class="txt-inblock">CALL <?php echo $city_data->phone; ?></a>
	    		</h1>

	    	</div>

	    </div>

    </section>

    <section class="section-city-wrap">

   		<div class="container">

    		<div class="row">

    			<div class="col-md-9">

    				<div class="section-content">

			    		<div class="service-item-wrap">

				    		<?php if($business != 0) { ?>

				    		<div class="masonry-row">
				    		
					    		<?php foreach($business as $biz) { ?>

					    		<div class="masonry-cell">

									<div class="svc-item">
										
										<div class="svc-details">

											<small class="category"><?php echo $biz->sample_categories; ?></small>

											<h4 class="name"><?php echo $biz->name; ?></h4>

											<span class="line"></span>

											<?php if(!empty($biz->image)) { ?>
											<img src="<?php echo $biz->image; ?>" class="img-responsive" alt="<?php echo $biz->name; ?>" title="<?php echo $biz->name; ?>"/>

											<br/>
											<?php } ?>

											<?php if(isset($biz->address)) { ?>

											<ul class="list-default">

												<li><?php echo $biz->address->street; ?></li>

												<li><?php echo $biz->address->city.' '.$biz->address->state.' '.$biz->address->postal_code; ?></li>

											</ul>

											<?php } ?>

											<br/>

											<span class="phone txt-inblock"><?php echo format_phone($biz->phone_number); ?></span>

										</div>

									</div>

							    </div>

					    		<?php } ?>

					    	</div>

				    		<?php } else { ?>

				    			<h2 class="txt-center">No Business Available.</h2>

				    		<?php } ?>

			    		</div>

			    		<div class="zips-wrap">

	    					<h2 class="section-title">Areas In <span class="txt-inblock"><?php echo $city_data->name.', '.strtoupper($city_data->state); ?></span></h2>

	    					<div class="zipcodes">
	    						<?php
	    							$zipcode = preg_split('/,([\s])+/', $city_data->zip_code);
	    							$zip_code = array();
	    							foreach($zipcode as $zips) {
	    								$zip_code[] = '<a href="'.base_url('zip/'.$industry_data->slug.'/'.$zips).'" class="zip-item">'.$zips.'</a>';
	    							}
	    							$zip = trim(implode(' ',$zip_code), '/,([\s])+/');
	    							echo $zip;

	    						?>

	    					</div>

			    		</div>

			    	</div>

    			</div>

    			<div class="col-md-3">
    				
    				<div class="aside aside-widget">
    					
    					<div class="map-wrap">
    					<?php
	    					if(empty($business)) {
	    				?>
	    					<iframe frameborder="0" src="https://www.google.com/maps?f=q&amp;source=s_q&amp;hl=en&amp;geocode=&amp;q=<?php echo $location; ?>&amp;aq=&amp;sspn=0.111915,0.295601&amp;ie=UTF8&amp;hq=&amp;&amp;t=m&amp;z=6&amp;output=embed" ></iframe>
	    				<?php } else { ?>
	    					<div id="map-overlay"></div>
	    				<?php } ?>
	    				</div>

						<?php include('parts/popcity-widget.php'); ?>

                        <div class="weather-wrap data-img" data-bg="<?php echo base_url('build/images/states/'.$state->abbrev.'.jpg'); ?>" title="Weather status in <?php echo ucwords($location); ?>">

							<div class="overlay">

								<div class="weather-widget" data-weather="<?php echo ucwords($location); ?>" ></div>

							</div>

						</div>

                        <?php if($recent_blogs != 0) { ?>
                        <div class="blogs-wrap">
                            <div class="header">
                                <h4>Recent Articles</h4>
                            </div>
                            <div class="content">
                            <?php
                                foreach($recent_blogs as $blog) {
                                    $blog_thumb = ($blog->featured_image != NULL) ? base_url($blog->featured_image) : base_url('build/images/lock.png');
                            ?>

                                <div class="blog-item">
                                    <small><?php echo date_proper($blog->created_at); ?></small>
                                    <p class="blog-title"><?php echo $blog->title; ?><p>
                                    <a class="btn btn-xs btn-success" href="<?php echo base_url($blog->slug); ?>">Read more</a>
                                </div>

                            <?php } ?>

                            </div>
                        </div>
                        <?php } ?>

    				</div>

    			</div>

    		</div>

    	</div>

    </section>

</section>