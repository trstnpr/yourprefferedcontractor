<?php
    $banner = ($page->featured_image != NULL) ? base_url($page->featured_image) : base_url('build/images/placeholder.jpg') ;
?>

<div class="post-content">

	<section class="section-header parallax" data-parallax="scroll" data-image-src="<?php echo $banner; ?>">

    	<div class="overlay">

	    	<div class="container">

	    		<h1 class="page-title"><?php echo $page->title; ?></h1>

	    		<h4 class="page-pubdate">Posted on <?php echo date_proper($page->created_at); ?> by <?php echo $page->author; ?></h4>

	    	</div>

	    </div>

    </section>

    <section class="section-page">

    	<div class="container">

    		
    		<div class="row">

    			<div class="col-sm-8 col-md-6 col-md-push-3">

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

    			<div class="col-xs-12 col-sm-4 col-md-3 col-md-pull-6">

    				<div class="aside aside-details">

    					<div class="post-meta">
    						
    						<ul class="fa-ul">
    							
    							<li>
    								<i class="fa fa-li fa-calendar"></i>
    								<?php echo date_proper($page->created_at); ?>
    							</li>

    							<li>
    								<i class="fa fa-li fa-user"></i>
    								<?php echo ucwords($page->author); ?>
    							</li>

    							<li>
    								<i class="fa fa-li fa-folder"></i>
    								<?php
    				            		if(unserialize($page->category) != NULL) {
    				            			$data = array();
    					            		foreach(unserialize($page->category) as $category) {
    					            			$data[] = $category.'&nbsp;&nbsp;';
    					            		}
    					            		$category = trim(join(' ', $data), '&nbsp;');
    					            		echo $category;
    					            	}
    				            	?>
    							</li>

    							<li>
    								<i class="fa fa-li fa-tags"></i>
    								<?php echo $page->tag; ?>
    							</li>

    						</ul>

    					</div>

    					<hr/>

    					<div class="well txt-center">
    						ADSPACE
    					</div>
	    				
	    			</div>

    			</div>

    			<div class="col-xs-12 col-sm-4 col-md-3">

    				<div class="aside aside-widget">

    					<?php include('parts/popcity-widget.php'); ?>

	    				<?php if($blogs != 0) { ?>
	    				<div class="blogs-wrap">
	    					<div class="header">
	    						<h4>Recent Articles</h4>
	    					</div>
	    					<div class="content">
	    					<?php foreach($blogs as $blog) { ?>

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