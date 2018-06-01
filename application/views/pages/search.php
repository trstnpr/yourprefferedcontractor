<div class="searchresult-content">

    <section class="section-header parallax" data-parallax="scroll" data-image-src="<?php echo base_url('build/images/banner-search.jpeg'); ?>">

    	<div class="overlay">

	    	<div class="container">

	    		<h1 class="page-title"><?php echo $page_title; ?></h1>

	    	</div>

	    </div>

    </section>

    <section class="section-searchresults">

    	<div class="container">

    		<div class="row">

    			<div class="col-md-9">

    				<div class="section-content">
    					
			    		<?php if($search_data != NULL) { ?>

				    		<div class="result-wrap">

				    		<?php foreach($search_data as $result) {
				    			$loc = $result->name.', '.$result->state;
		    					$popular = ($result->is_popular == 1) ? '<i class="fa fa-check-circle is_popular" title="Popular City"></i>' : NULL;
				    		?>


					    		<div class="result-item">
      
									<div class="media item-wrap">

										<div class="media-left map-left">
											<a href="<?php echo embed_map($loc); ?>" data-lity>
												<img class="media-object" src="<?php echo static_map($loc, '500x500', 9); ?>" alt="<?php echo $loc; ?>" title="<?php echo $loc; ?>" />
											</a>
										</div>

										<div class="media-body details-right">

											<h4 class="media-heading title">
												<a href="<?php echo base_url('city/'.$result->slug); ?>">
													<?php echo $result->name; ?> 
													<small>
														<?php echo state_name($result->state); ?> 
														<?php echo $popular; ?>
													</small>
												</a>
											</h4>

											<a class="url" href="<?php echo base_url('city/'.$result->slug); ?>"><?php echo base_url('city/'.$result->slug); ?></a>

											<div class="zipcodes">
												<p> 
													<?php
						    							$zipcode = preg_split('/,([\s])+/', $result->zip_code);
						    							$zip_code = array();
						    							$x = 0; // Init limit
						    							foreach($zipcode as $zips) {
						    								$x++;
						    								$zip_code[] = trim('<a href="'.base_url('zip/'.$industry_data->slug.'/'.$zips).'" >'.$zips.'</a>, ', ', ');
						    								if($x > 30) { break; }
						    							}
						    							$zip = trim(implode(' ',$zip_code), '/([\s])+/');
						    							echo $zip;
						    						?>
												</p>
												<a href="tel:<?php echo $result->phone; ?>" class="btn btn-success btn-sm" >Call <?php echo $result->phone; ?></a>
											</div>

										</div>
									</div>

								</div>

					    	<?php } ?>

				    		</div>

			    		<?php } else { ?>

			    			<h3 class="txt-center">No Results Found.</h3>

			    		<?php } ?>

    				</div>

    			</div>

    			<div class="col-md-3">

    				<div class="aside aside-widget">

    					<div class="search-wrap">

    						<form class="search-form" method="get" action="<?php echo base_url('search'); ?>">

    						<input type="hidden" name="industry" value="1" />
    						
	    						<h4 class="widget-header">Search</h4>

	    						<div class="widget-body">

	    							<div class="form-group">

	    								<input type="text" class="form-control keyword" name="location" placeholder="City, State or Zip Code" data-suggest="<?php echo base_url('search/suggest'); ?>" required />

	    							</div>

	    							<!-- <div class="form-group">

	    								<select class="form-control" name="industry" required>

	    									<option value="" selected disabled>Choose Type</option>
	    									<?php
											//if(industry() != 0) {
												//foreach(industry() as $indstry) {
											?>
											<option value="<?php //echo $indstry->id; ?>"><?php //echo $indstry->industry; ?></option>
											<?php //} } ?>

	    								</select>

	    							</div> -->

	    							<div class="form-group">

	    								<button type="submit" class="btn btn-success btn-block">Search</button>

	    							</div>

	    						</div>

	    					</form>

    					</div>

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