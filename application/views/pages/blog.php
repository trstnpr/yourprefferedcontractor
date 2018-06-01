<div class="blogs-content">

	<section class="section-header parallax" data-parallax="scroll" data-image-src="<?php echo base_url('build/images/banner-blogs.jpg'); ?>">

    	<div class="overlay">

	    	<div class="container">

	    		<h1 class="page-title">Blog</h1>

	    	</div>

	    </div>

    </section>

    <section class="section-blogs-wrap">

    	<div class="container">

			<div class="row">

    			<div class="col-md-9">

    				<div class="section-content">

    				<?php
    				if($blogs->result() != 0) {
    					foreach($blogs->result() as $blog) {
    				?>
    					
    					<div class="blog-item">
                            <div class="blog-header">
                                
                                <h3 class="blog-title">
                                    <a href="<?php echo base_url($blog->slug); ?>">
                                        <?php echo $blog->title; ?>
                                    </a>        
                                </h3>
                                <p class="blog-info">Posted on <?php echo date_proper($blog->created_at); ?> by <?php echo $blog->author; ?></p>

                            </div>
                            <?php
                                if($blog->featured_image != NULL) {
                                    $blog_thumb = ($blog->featured_image != NULL) ? base_url($blog->featured_image) : base_url('build/images/lock.png');
                            ?>

                            <div class="blog-thumb">
                                <a href="<?php echo base_url($blog->slug); ?>">
                                    <img src="<?php echo $blog_thumb; ?>" class="img-resonsive" alt="<?php echo $blog->title; ?>" title="<?php echo $blog->title; ?>" />
                                </a>
                            </div>

                            <?php } ?>
                            <div class="blog-content">
        						<p class="blog-excerpt">
                                    <?php
                                        if($blog->excerpt != NULL) {
                                            echo $blog->excerpt;
                                        } else {
                                            echo truncate($blog->content, 300);
                                        }
                                    ?>    
                                </p>

                                <br/>

        						<div class="blog-category">
        							
      								<?php
    				            		if(unserialize($blog->category) != NULL) {
    				            			$data = array();
    					            		foreach(unserialize($blog->category) as $category) {
    					            			$data[] = '<span class="label label-success">'.$category.'</span> ';
    					            		}
    					            		$category = trim(join(' ', $data), ' ');
    					            		echo $category;
    					            	}
    				            	?>

        						</div>
                            </div>
    					</div>

    				<?php
    					}

                        if (strlen($pagination)) {
                            echo $pagination;
                        }
    				} else { ?>

                    <div class="well">
                        <h2>No Blog Posts Available</h2>
                    </div>

                    <?php } ?>

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