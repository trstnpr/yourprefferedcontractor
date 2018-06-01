<div class="page-content">

	<section class="section-header parallax" data-parallax="scroll" data-image-src="<?php echo base_url('build/images/banner-page-1.jpeg'); ?>">

    	<div class="overlay">

	    	<div class="container">

	    		<h1 class="page-title"><?php echo $page->title; ?></h1>

	    	</div>

	    </div>

    </section>

    <section class="section-page">

    	<div class="container">
    		
    		<div class="row">

    			<div class="col-sm-8 col-sm-push-4 col-lg-9 col-lg-push-3">

    				<div class="section-content">

	    				<h2 class="section-title"><?php echo $page->title; ?></h2>

	    				<div class="content-wrap">

	    					<?php if($page->featured_image != NULL) { ?>
	    					<div class="page-thumb">
	    						<img src="<?php echo base_url($page->featured_image); ?>" class="img-responsive" alt="<?php echo $page->title; ?>" title="<?php echo $page->title; ?>" />
	    					</div>
		    				<?php } ?>
		    				
	    					<?php echo $page->content; ?>

	    					<hr/>

		    			</div>

	    			</div>

    			</div>


    			<div class="col-sm-4 col-sm-pull-8 col-lg-3 col-lg-pull-9">

    				<div class="aside aside-widget">

    					<div class="sidemenu-wrap">

    						<div class="widget-body">

	    						<ul class="list-default">
	    							<li><a href="<?php echo base_url(); ?>">Home</a></li>
	    							<li><a href="<?php echo base_url('blog'); ?>">Blogs</a></li>
	    							<li><a href="<?php echo base_url('privacy-policy'); ?>">Privacy Policy</a></li>
	    							<li><a href="<?php echo base_url('about-us'); ?>">About Us</a></li>
	    							<li><a href="<?php echo base_url('contact-us'); ?>">Contact Us</a></li>
	    							<li><a href="<?php echo base_url('join-business'); ?>">Join Business</a></li>
	    						</ul>

	    					</div>
    						
    					</div>

    					<div class="well txt-center">
    						ADSPACE
    					</div>

	    				<?php include('parts/popcity-widget.php'); ?>

	    			</div>

    			</div>

    		</div>

    	</div>

    </section>

</div>