<!DOCTYPE html>

<html lang="en">

    <head>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8">
        <meta charset="UTF-8">
        <meta name="viewport" content="initial-scale=1, width=device-width">

        <title><?php echo $title; ?></title>

        <meta name="title" content="<?php echo $meta_title; ?>">
        <!-- <meta name="keywords" content="<?php // echo $meta_keyword; ?>"> -->
        <meta name="description" content="<?php echo $meta_description; ?>">
        <meta name="robots" content="index, follow" />

        <script>
			(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
			(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
			m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
			})(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

			ga('create', '<?php echo the_config('ga_id'); ?>', 'auto');
			ga('send', 'pageview');

		</script>

        <link href="<?php echo base_url('build/css/styles.css?v=1'); ?>" rel="stylesheet">
        <script src='https://www.google.com/recaptcha/api.js'></script>

    </head>


    <body>

		<div class="navbar-wrapper">

			<header class="navbar navbar-fixed-top main-menu">

				<div class="navbar-extra-top clearfix hidden-xs">
					<div class="navbar container">
						<ul class="nav navbar-nav navbar-left">
							<li class="menu-item"><a href="<?php echo base_url('contact-us'); ?>"><i class="fa fa-envelope"></i> Contact Us</a></li>
							<li class="menu-item"><a href="<?php echo base_url('join-business'); ?>"><i class="fa fa-suitcase"></i> Join Business</a></li>
						</ul>
						<div class="navbar-top-right">
							<ul class="nav navbar-nav navbar-right">
								<li><a href="<?php echo the_config('facebook_link'); ?>"><i class="fa fa-facebook fa-fw"></i></a></li>
								<li><a href="<?php echo the_config('googleplus_link'); ?>"><i class="fa fa-google-plus fa-fw"></i></a></li>
								<li><a href="<?php echo the_config('twitter_link'); ?>"><i class="fa fa-twitter fa-fw"></i></a></li>
								<li><a href="<?php echo the_config('linkedin_link'); ?>"><i class="fa fa-linkedin fa-fw"></i></a></li>
							</ul>
						</div>
					</div>
				</div>

				<div class="container collapse-md main-nav" id="navbar-main-container">
					<div class="navbar-header">
						<a href="<?php echo base_url(); ?>" class="navbar-brand">
							<img class="img-responsive" alt="<?php echo the_config('site_name'); ?>" title="<?php echo the_config('site_name'); ?>" src="<?php echo base_url('build/images/logo.png'); ?>"/>
							<span class="sr-only">BRAND</span>
						</a>
						<button class="navbar-toggle collapsed" type="button" data-toggle="collapse" data-target="#navbar-main">
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>
					</div>

					<nav class="navbar-collapse collapse" id="navbar-main" style="height: 1px;">
						<ul class="nav navbar-nav navbar-right">
							<li><a class="menu" href="<?php echo base_url(); ?>">Home</a></li>

							<li class="dropdown">
								<a href="#" class="dropdown-toggle menu" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Industry</a>
								<?php if(industry() != 0) { ?>
								<ul class="dropdown-menu">
									<?php foreach(industry() as $indstry) { ?>
									<li><a href="<?php echo base_url('industry/'.$indstry->slug); ?>"><?php echo $indstry->industry; ?></a></li>
									<?php } ?>
								</ul>
								<?php } ?>
							</li>

							<li><a class="menu" href="<?php echo base_url('blog'); ?>">Blog</a></li>
							<li><a class="menu" href="<?php echo base_url('about-us'); ?>">About Us</a></li>
							<li><a class="menu" href="<?php echo base_url('privacy-policy'); ?>">Pivacy Policy</a></li>
							<li><a class="menu" href="<?php echo base_url('contact-us'); ?>">Contact Us</a></li>
							
							
						</ul>
					</nav>
				</div>
				
			</header>

		</div>

        <main>