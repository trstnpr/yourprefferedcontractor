<?php
	$state_img = (!file_exists(APPPATH.'../build/images/states/'.$state->abbrev.'.jpg')) ? base_url('build/images/states/place-statecity.jpeg') : base_url('build/images/states/'.$state->abbrev.'.jpg');
?>

<div class="state-content">

    <section class="section-header parallax" data-parallax="scroll" data-image-src="<?php echo $state_img; ?>">

    	<div class="overlay">

	    	<div class="container">

	    		<h1 class="page-title"><?php echo $state->state; ?></h1>

	    	</div>

	    </div>

    </section>

    <section class="section-state-wrap">

    	<div class="container">

    		<div class="row">

    			<div class="col-md-9">

    				<div class="section-content">
			    		
			    		<div class="city-wrap">

		    				<?php

		    				if($cities->result() != 0) {

		    					foreach($cities->result() as $city) {
		    						$location = $city->name.', '.$state->abbrev;
		    						$slug = base_url('city/'.$city->slug);
		    						$popular = ($city->is_popular == 1) ? '<i class="fa fa-check-circle is_popular" title="Popular City"></i>' : NULL;
		    				?>

		    				<div class="city-item">
      
								<div class="media item-wrap">

									<div class="media-left map-left">
										<a href="<?php echo embed_map($location); ?>" data-lity>
											<img class="media-object" src="<?php echo static_map($location, '500x500', 9); ?>" alt="<?php echo $location; ?>" title="<?php echo $location; ?>" />
										</a>
									</div>

									<div class="media-body details-right">

										<h4 class="media-heading title clearfix">
											<a href="<?php echo $slug;; ?>">
												<?php echo $city->name; ?> 
												<small>
													<?php echo $state->state; ?>
													<?php echo $popular; ?>
												</small>
											</a>

											<span class="label label-warning pull-right txt-inblock"><?php echo ucwords($industry); ?></span>
										</h4>

										<a class="url" href="<?php echo $slug; ?>"><?php echo $slug; ?></a>

										<div class="zipcodes">
											<p> 
												<?php
					    							$zipcode = preg_split('/,([\s])+/', $city->zip_code);
					    							$zip_code = array();
					    							$x = 0; // Init limit
					    							foreach($zipcode as $zips) {
					    								$x++;
					    								$zip_code[] = trim('<a href="'.base_url('zip/'.$industry.'/'.$zips).'" >'.$zips.'</a>, ', ', ');
					    								if($x > 30) { break; }
					    							}
					    							$zip = trim(implode(' ',$zip_code), '/([\s])+/');
					    							echo $zip;
					    						?>
											</p>
											<a href="tel:<?php echo $city->phone; ?>" class="btn btn-success btn-sm" >Call <?php echo $city->phone; ?></a>
										</div>

									</div>
								</div>

							</div>



							<?php

								}

								if (strlen($pagination)) {
		                            echo $pagination;
		                        }
								
							} else {

							?>

							<h2 class="txt-center">No Cities Available.</h2>

							<?php } ?>
				    		
			    		</div>


    				</div>

    			</div>

    			<div class="col-md-3">

    				<div class="aside aside-widget">

	    				<?php include('parts/weather.php'); ?>

	    				<?php include('parts/popcity-widget.php'); ?>

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

</div>