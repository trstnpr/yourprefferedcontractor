<!DOCTYPE html>

<html lang="en">

    <head>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8">
        <meta charset="UTF-8">
        <meta name="viewport" content="initial-scale=1, width=device-width">

        <title><?php echo $title; ?></title>

        <link href="<?php echo base_url('build/css/admin_styles.css?v=1'); ?>" rel="stylesheet">

    </head>

    <body>

		<section class="admin-login-section">

			<div class="container">

			    <div class="row">

			        <div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3">

			        	<div class="login-wrap">

				            <form role="form" class="admin-login" method="post" action="<?php echo base_url('admin/login/process'); ?>">
								<div class="form-group text-center">
									<div class="logo">
										<img src="<?php echo base_url('build/images/logo.png'); ?>" class="img-responsive center-block" />
									</div>
								</div>
								<br/>
								<div class="form-group">
									<input type="text" class="form-control input-lg username" name="username" placeholder="Enter username">
								</div>
								<div class="form-group">
									<input type="password" class="form-control input-lg password" name="password" placeholder="Enter password">
								</div>
								<div class="form-group">
									<button type="submit" class="btn btn-success btn-lg btn-block btn-login">Login</button>
								</div>
				            </form>

				        </div>

				        <a href="<?php echo base_url(); ?>" class="center-block txt-center"><i class="fa fa-long-arrow-left"></i> Back to Home</a>

			        </div>

			    </div>

			</div>


		</section>
	
        <script type="text/javascript" src="<?php echo base_url('build/js/master-scripts.js?v=1'); ?>"></script>
        <script src="http://maps.google.com/maps/api/js?key=AIzaSyDTUiG6ZFSJIGA9QGs2R09OANGgcZTGq0Q" 
            type="text/javascript"></script>
        <script type="text/javascript" src="<?php echo base_url('build/js/admin_scripts.js?v=1'); ?>"></script>

        <script type="text/javascript">


        </script>

    </body>

</html>