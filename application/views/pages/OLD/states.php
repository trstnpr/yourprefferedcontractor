
<div class="states-content">

    <section class="section-header parallax" data-parallax="scroll" data-image-src="<?php echo base_url('build/images/banner-states.jpeg'); ?>">

    	<div class="overlay">

	    	<div class="container">

	    		<h1 class="page-title">States</h1>

	    	</div>

	    </div>

    </section>

    <section class="section-states">

    	<div class="container">
    		
    		<div class="row">

    			<div class="col-md-9">

    				<div class="section-content">

		    			<div class="states-wrap">

		    				<?php if($states->result() != 0) { ?>
		    				
		    				<div class="row">

		    					<?php foreach($states->result() as $state) { ?>

		    					<div class="col-md-4 col-sm-6">
		    						
		    						<div class="states-item">

		    							<a href="<?php echo base_url('state/'.strtolower($state->abbrev)); ?>">

			    							<div class="states-thumb">

			    								<div class="states-details">
				    								<?php echo $state->state; ?>
				    							</div>
			    								<img class="img-responsive" src="<?php echo base_url('build/images/states/'.$state->abbrev.'.jpg'); ?>" alt="<?php echo $state->state; ?>" title="<?php echo $state->state; ?>" />
			    								
			    							</div>

			    						</a>
		    							
		    						</div>

		    					</div>

		    					<?php
                                    }
                                    
                                    if (strlen($pagination)) {
                                        echo $pagination;
                                    }   
                                ?>

		    				</div>

		    				<?php } else { ?>

		    					<h2 class="txt-center">No States Available</h2>

		    				<?php } ?>

		    			</div>

	    			</div>

    			</div>

    			<div class="col-md-3">

    				<div class="aside aside-widget">

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