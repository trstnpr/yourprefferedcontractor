<div class="pages-section">

	<section class="section-header">
		
		<div class="container-fluid">
			
			<div class="page-title">
				<h1>Industry <a href="<?php echo base_url('admin/industry/new'); ?>" class="btn btn-default btn-sm">Add New</a></h1>
			</div>

			<div class="breadcrumb-wrap">
				<ol class="breadcrumb">
					<li><a href="<?php echo base_url('admin'); ?>">Admin</a></li>
					<li class="active">Industry</li>
				</ol>
			</div>

		</div>

	</section>

	<section class="section-content">
		
		<div class="container-fluid">

		<?php
			if($industry != 0) {
		?>
			<div class="data-list">
				<table class="table table-striped datatable" cellspacing="0" width="100%">
				    <thead>
				        <tr>
				            <th>ID</th>
				            <th>Industry</th>
				            <th>Label</th>
				            <th>Prefix</th>
				            <th>Action</th>
				        </tr>
				    </thead>
				    <tbody>
				    <?php foreach ($industry as $indstry) { ?>
				        <tr>
				            <th width="5%"><?php echo $indstry->id; ?></th>
				            <td><?php echo $indstry->industry; ?></td>
				            <td><?php echo $indstry->label; ?></td>
				            <th><?php echo $indstry->slug; ?></th>
				            <td width="10%">

				            	<a href="<?php echo base_url('admin/industry/'.$indstry->slug); ?>" class="btn btn-warning btn-xs btn-block">Update</a>

				            	<button type="button" class="btn btn-danger btn-xs btn-block btn-delindustry" data-delete="<?php echo $indstry->id; ?>" data-action="<?php echo base_url('admin/industry/delete'); ?>">Delete</button>

				            </td>
				        </tr>
				    <?php } ?>
				    </tbody>
				</table>
			</div>

		<?php } else { ?>

			<div class="well">
				<h2 class="txt-center">No Posts Available</h2>
			</div>

		<?php } ?>

		</div>

	</section>

</div>