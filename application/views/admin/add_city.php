<?php
	if($states != 0) {
		$attrib = 'required';
		$label = '';
	} else {
		$attrib = 'disabled';
		$label = '<small class="text-danger">you must add a state</small>';
	}
?>
<div class="pages-section">

	<section class="section-header">
		
		<div class="container-fluid">
			
			<div class="page-title">
				<h1>Add New City</h1>
			</div>

			<div class="breadcrumb-wrap">
				<ol class="breadcrumb">
					<li><a href="<?php echo base_url('admin'); ?>">Admin</a></li>
					<li><a href="<?php echo base_url('admin/cities'); ?>">Cities</a></li>
					<li class="active">New</li>
				</ol>
			</div>

		</div>

	</section>

	<section class="section-content">
		
		<div class="container-fluid">

			<form class="addcity-form" method="post" action="<?php echo base_url('admin/city/add'); ?>">
			
				<div class="row">
					
					<div class="col-md-9">
						<div class="well">
							<div class="row">

								<div class="col-md-6">

									<div class="form-group">
										<label>City</label>
										<input type="text" class="form-control slugcity" name="name" placeholder="Enter city name ..." required />
									</div>

								</div>

								<div class="col-md-6">

									<div class="form-group">
										<label>State <?php echo $label; ?></label>
										<select class="form-control slugstate" name="state" <?php echo $attrib; ?>>
											<option disabled selected>Select A State</option>
										<?php foreach($states as $state) { ?>
											<option value="<?php echo $state->abbrev; ?>"><?php echo $state->abbrev; ?></option>
										<?php } ?>
										</select>
									</div>

								</div>

								<div class="col-md-12">

									<div class="form-group">
										<label>Industry</label>
										<select class="form-control slugindustry" name="industry" required>
											<option disabled selected>Select Industry</option>
										<?php foreach($industry as $type) { ?>
											<option value="<?php echo $type->id; ?>" data-slug="<?php echo $type->slug; ?>"><?php echo $type->industry; ?></option>
										<?php } ?>
										</select>
									</div>

								</div>

								<div class="col-md-12">
									<div class="form-group">
										<label>Slug</label>
										<input type="text" class="form-control slug" name="slug" data-slug="<?php echo base_url('admin/validateslug'); ?>" data-posttype="city" placeholder="City slug ..." readonly required />
									</div>
								</div>

								<div class="col-md-6">

									<div class="form-group">
										<label>Area Code</label>
										<input type="text" class="form-control number" name="area_code" maxlength="3" placeholder="Enter area code ..." required />
									</div>

								</div>

								<div class="col-md-6">

									<div class="form-group">
										<label>Phone</label>
										<input type="text" class="form-control" name="phone" placeholder="Enter phone number ..." required />
									</div>

								</div>

								<div class="col-md-12">
									<div class="form-group">
										<label>Zip Code <small class="text-warning hidden-xs">seperated by comma & space</small></label>
										<textarea class="form-control" name="zip_code" rows="2" id="zip_strip" onKeyUp="strip_zip()" placeholder="Enter zip code areas (e.g 90001, 90002)" required></textarea>
									</div>
								</div>
								
								<div class="col-md-12">
									<div class="form-group">
										<label>Content</label>
										<textarea class="wysiwyg form-control" name="description" ></textarea>
									</div>
								</div>
								
								<div class="col-md-12">
									<div class="form-group">
										<label>Meta Keywords</label>
										<input type="text" class="form-control" name="meta_keyword" placeholder="SEO Keywords ..." required />
									</div>
								</div>
								<div class="col-md-12">
									<div class="form-group">
										<label>Meta Description</label>
										<textarea class="form-control" name="meta_description" placeholder="SEO Description ..." rows="2" required></textarea>
									</div>
								</div>

							</div>
						</div>
					</div>

					<div class="col-md-3">

						<div class="panel-group" id="accordion1" role="tablist" aria-multiselectable="true">
						    <div class="panel panel-default">
						        <div class="panel-heading" role="tab" id="headingOne">
						            <h4 class="panel-title">
								        <a role="button" data-toggle="collapse" data-parent="#accordion1" href="#coordinates" aria-expanded="true" aria-controls="collapseOne">
								         	Map Coordinates
								        </a>
								    </h4>
						        </div>
						        <div id="coordinates" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
						            <div class="panel-body">
						            	<div class="form-group">
						            		<label>Latitude (x)</label>
						            		<input type="text" class="form-control" name="lat" placeholder="Enter latitude" />
						            	</div>
						            	<div class="form-group">
						            		<label>Longitude (y)</label>
						            		<input type="text" class="form-control" name="lng" placeholder="Enter longitude" />
						            	</div>
						            </div>
						        </div>
						    </div>
						</div>
						
						<div class="panel-group" id="accordion4" role="tablist" aria-multiselectable="true">
						    <div class="panel panel-default">
						        <div class="panel-heading" role="tab" id="headingOne">
						            <h4 class="panel-title">
								        <a role="button" data-toggle="collapse" data-parent="#accordion4" href="#action" aria-expanded="true" aria-controls="collapseOne">
								         	Action
								        </a>
								    </h4>
						        </div>
						        <div id="action" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
						            <div class="panel-body">
						                <div class="checkbox">
										    <label>
										    	<input type="checkbox" name="is_popular" value="1" /> Popular City
										    </label>
										</div>
						            </div>
						        </div>
						        <div class="panel-footer">
						        	<button type="submit" class="btn btn-success btn-block btn-save">Save</button>
						        </div>
						    </div>
						</div>

					</div>

				</div>

			</form>

		</div>

	</section>

</div>