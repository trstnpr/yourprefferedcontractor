<?php
	$biz = get_business(obtain_bearer_token(), $biz_id);

	//print_r($biz);

	$image_url = ($biz->image_url == null) ? base_url('build/images/business.png') : $biz->image_url;
?>

<div class="business-content">

	<section class="section-bizhead">
		
		<div class="container">

			<div class="row ">

				<div class="col-md-9 " >
					
					<h1 class="biz-title"><i class="fa fa-unlock-alt"></i> <?php echo $biz->name; ?> <small><?php echo $biz->categories[0]->title; ?></small></h1>

				</div>

				<div class="col-md-3" >

					<a class="btn btn-block btn-danger" href="tel:<?php echo $biz->display_phone; ?>" ><i class="fa fa-phone"></i> Call Now <?php echo $biz->display_phone; ?></a>

				</div>

			</div>


		</div>

	</section>

	<section class="section-bizdetails">

		<div class="container">
			
			<div class="row row-parent">

				<div class="col-md-4 col1">
					
					<div class="bizcard-wrap">
						
						<div class="biz-card">

							<div class="thumb">
								<a href="<?php echo $image_url ?>" data-lity>
									<img src="<?php echo $image_url; ?>" class="img-responsive" alt="<?php echo $biz->name; ?>" title="<?php echo $biz->name; ?>" />
								</a>

							</div>

							<div class="biz-info">
							
								<div class="biz-details">
									<h3 class="biz-title"><?php echo $biz->name; ?></h3>

									<hr/>

									<ul>
										<li class="biz-category"><i class="fa fa-folder"></i> <?php echo $biz->categories[0]->title; ?></li>
										<li><i class="fa fa-map-marker"></i> <?php echo $biz->location->address1.' '.$biz->location->city; ?></li>
										<li class="city"><i class="fa fa-location-arrow"></i> <?php echo $biz->location->zip_code.' '.$biz->location->state.' '.$biz->location->country ?></li>
										<li><i class="fa fa-phone"></i> <?php echo $biz->display_phone; ?></li>
									</ul>
								</div>
							</div>

						</div>

					</div>

				</div>

				<div class="col-md-8">
					<div class="map-wrap">
						<iframe width="100%" height="350" frameborder="0" src="https://www.google.com/maps?f=q&amp;source=s_q&amp;hl=en&amp;geocode=&amp;q=<?php echo $biz->location->address1.' '.$biz->location->address2.' '.$biz->location->address3.' '.$biz->location->city.' '.$biz->location->state.' '.$biz->location->zip_code.' '.$biz->location->country; ?>&amp;aq=&amp;sspn=<?php echo $biz->coordinates->longitude; ?>,<?php echo $biz->coordinates->latitude; ?>&amp;ie=UTF8&amp;hq=&amp;&amp;t=m&amp;z=12&amp;output=embed"></iframe>
					</div>
				</div>

			</div>

		</div>

	</section>

	<section class="section-bizphoto">

		<div class="container">

			<h2>Photos of <?php echo $biz->name; ?></h2>

			<div class="photo-wrap">

				<?php

					$photos = $biz->photos;

					if (!empty($photos)) {  ?>


				<div class="row">
					<?php
					
						foreach($photos as $photo) { ?>
						
					<div class="col-md-4">
						<a href="<?php echo $photo; ?>" data-lity>
							<img class="img-responsive" src="<?php echo $photo; ?>" alt="Photos <?php echo $biz->name; ?>" title="Photos <?php echo $biz->name; ?>" />
						</a>
					</div>

						<?php } ?>
				</div>

				<?php } else { ?>

					<h2 class="txt-center">No Photos Available</h2>
					
				<?php } ?>

			</div>

		</div>

	</section>


</div>