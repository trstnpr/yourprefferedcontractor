<div class="app-content">

    <section class="section-banner parallax" data-parallax="scroll" data-image-src="<?php echo base_url('build/images/cg-banner-1.jpeg'); ?>">
      
		<div class="overlay">

			<div class="container">

				<div class="row">

					<div class="col-md-10 col-md-offset-1">

						<div class="header-content">

							<div class="tagline">

								<h1><?php echo the_config('tag_line'); ?></h1>
								<h2><?php echo the_config('sub_tagline'); ?></h2>

							</div>

						</div>

					</div>

				</div>  

			</div>

		</div>

	</section>

	<section class="section-search">

		<div class="container">
			
			<div class="section-title">
				<h2>What Are You Looking For?</h2>
			</div>

			<div class="form-wrap">

				<?php include('parts/home-search.php'); ?>

			</div>

		</div>

	</section>

	<section class="section-featsvc">

		<div class="container">
			
			<section class="section-title">
				
				<h2>Featured <span>Services</span></h2>

			</section>

			<div class="service-wrap">
				
				<?php if($business != 0) { ?>

				<div class="row">

					<?php
						$x = 0;
						foreach($business as $biz) {
							$x++;
							$map_loc = $biz->latitude.','.$biz->longitude;
					?>

					<div class="col-md-3">

						<div class="svc-item">

							<div class="svc-details">
								<h4 class="svc-name"><?php echo $biz->name; ?></h4>
								<label class="label label-success svc-type">Locksmith</label>
							</div>

							<div class="svc-thumb">
								<figure class="sticker data-img" data-bg="<?php echo base_url('build/images/sticker.png'); ?>"></figure>
								<img src="<?php echo static_map($map_loc, '500x500', 15); ?>" class="img-responsive" alt="" title="" />
							</div>

							

							<div class="svc-footer">
								<ul class="fa-ul">
									<li><i class="fa fa-li fa-map-marker"></i> <?php echo $biz->address->city.', '.$biz->address->state.' '.$biz->address->postal_code;; ?></li>
									<li><i class="fa fa-li fa-phone"></i> <?php echo format_phone($biz->phone_number); ?></li>
								</ul>
							</div>

						</div>

					</div>

					<?php if($x >= 4) { break; } } ?>

				</div>

				<?php } ?>

			</div>

		</div>

	</section>

	
	<section class="section-popcity parallax" data-parallax="scroll" data-image-src="<?php echo base_url('build/images/banner-bg-5.jpg'); ?>">

		<div class="overlay">
			
			<div class="container">
				
				<div class="section-title">
					
					<h2>Popular <span>Areas</span></h2>

				</div>

				<?php if ($popular_city['result'] == 'success') { ?>

				<div class="popcity-wrap">
					<?php foreach($popular_city['data'] as $popcity) { ?>
					<a class="popcity-item" href="<?php echo base_url('city/'.$popcity->slug); ?>"><i class="fa fa-map-marker"></i> <?php echo $popcity->name; ?></a>
					<?php } ?>

				</div>

				<?php } ?>

			</div>

		</div>

	</section>

	<?php if($blogs != 0) { ?>
	<section class="section-blog">
		
		<div class="container">
			
			<section class="section-title">
				
				<h2>Recent <span>Blog</span></h2>

			</section>

			<div class="blog-wrap">

				<div class="row">

					<?php
						foreach($blogs as $blog) {
							$blog_thumb = ($blog->featured_image != NULL) ? base_url($blog->featured_image) : base_url('build/images/placeholder.jpg');
					?>
					
					<div class="col-md-3">
						
						<div class="blog-item">

							<div class="thumb-content data-img" data-bg="<?php echo $blog_thumb; ?>">

								<div class="overlay">
									
									<small>Posted on <?php echo date_proper($blog->created_at); ?></small>
									<h3><?php echo $blog->title; ?></h3>
									<label class="label label-warning">Category</label>
								</div>

							</div>

							<div class="blog-excerpt">
								<p><?php echo truncate($blog->excerpt, 90); ?></p>
							</div>

							<div class="blog-footer clearfix">
								Posted by <?php echo $blog->author; ?> <a class="btn btn-success btn-xs pull-right" href="<?php echo base_url($blog->slug); ?>">READ</a>
							</div>
							
						</div>

					</div>

					<?php } ?>

				</div>

			</div>

		</div>

	</section>
	<?php } ?>
	
</div>