<?php

include_once 'db.config.php';
(!isset($_GET['id']) || empty($_GET['id'])) ? $_GET['id'] = 0 : $_GET['id'] = $_GET['id'];
if(isset($_GET['confirm']) && $_GET['confirm'] == 'confirm') {
	$user->delete($_GET['id']);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<title>Simple CRUD System</title>
	<link rel="stylesheet" href="<?=HTTPHOST;?>assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="<?=HTTPHOST;?>assets/css/bootstrap.lumen.min.css">
	<link rel="stylesheet" href="<?=HTTPHOST;?>assets/css/fontawesome.min.css">
	<script>
		function clean(e) { //e for element
			var string = document.getElementById(e);
			var regex = /[^a-z0-9\s]/gi;
			string.value = string.value.replace(regex, '');
		}
	</script>
</head>
<body>

	<div class="container">
		<div class="page-header">
			<h2 class="text-primary">Simple CRUD System</h2>
		</div>

		<div class="row">
			<div class="col-lg-12 col-md-12 col-xs-12">
				<div>
					<form action="<?=HTTPHOST;?>" method="GET" class="form-inline">
						<a href="<?=HTTPHOST;?>" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="View all data"><i class="fa fa-eye"></i>&nbsp;&nbsp;View All</a>
						<a href="<?=HTTPHOST;?>add/" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Add data"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add</a>
						<div class="input-group" data-toggle="tooltip" data-placement="top" title="Search for first name or last name">
							<input id="search" name="s" onkeyup="clean('search')" onkeydown="clean('search')" type="text" class="form-control" placeholder="Search name..." autocomplete="on">
							<div class="input-group-btn">
								<button type="submit" class="btn btn-primary"><i class="fa fa-search" aria-hidden="false"></i></button>
							</div>
						</div>
					</form>
					<br/> <!-- for spacing -->
				</div>
				<div class="row">
					<?php if($user->view($_GET['id']) != '') { ?>
						<!-- col-lg-pull-6 col-md-pull-6 -->
						<div class="col-lg-6 col-md-6 col-xs-12 <?=(isset($alert)) ? 'col-lg-pull-6 col-md-pull-6' : 0;?>">
							<div class="panel panel-primary">
								<div class="panel-heading">
									<h2 class="panel-title">Delete this data?</h2>
								</div>
								<div class="panel-body">
									<?php $data = $user->view($_GET['id']); ?>
									<p>
										<strong>Name:</strong>&nbsp;<?=$data['user_firstname'].' '.$data['user_lastname'];?><br />
										<strong>Email:</strong>&nbsp;<?=$data['user_email'];?><br />
										<strong>Phone:</strong>&nbsp;<?=$data['user_phonenumber'];?><br />
									</p>
								</div>
								<div class="panel-footer">
									<a href="<?=HTTPHOST;?>delete/<?=$data['user_id'];?>/confirm" class="btn btn-danger">Confirm</a>
									<a href="<?=HTTPHOST;?>" class="btn btn-default">Cancel</a>
								</div>
							</div>
						</div>
					<?php } else { ?>
						<div class="col-lg-6 col-md-6 col-xs-12">
							<div class="alert alert-warning">
								<strong>Error</strong>, User not found! You cannot delete that user.
							</div>
						</div>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
	
	<script src="<?=HTTPHOST;?>assets/js/jquery.min.js"></script>
	<script src="<?=HTTPHOST;?>assets/js/bootstrap.min.js"></script>
	<script src="<?=HTTPHOST;?>assets/js/main.js"></script>
</body>
</html>