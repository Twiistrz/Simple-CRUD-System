<?php

include_once 'db.config.php';
(!isset($_GET['id']) || empty($_GET['id'])) ? $_GET['id'] = 0 : $_GET['id'] = $_GET['id'];
if(isset($_POST['update'])) {
	$user_id = $user->clean($_POST['id']);
	$user_firstname = $user->clean($_POST['firstname']);
	$user_lastname = $user->clean($_POST['lastname']);
	$user_email = $user->clean($_POST['email']);
	$user_phonenumber = $user->clean($_POST['phonenumber']);
	if($user->edit($user_id,$user_firstname,$user_lastname,$user_email,$user_phonenumber)) {
		$alert['success'] = 'Data updated!';
	} else {
		$alert['error'] = $user->errors();
	}
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
							<input name="s" type="text" class="form-control" placeholder="Search name..." autocomplete="on">
							<div class="input-group-btn">
								<button type="submit" class="btn btn-primary"><i class="fa fa-search" aria-hidden="false"></i></button>
							</div>
						</div>
					</form>
					<br/> <!-- for spacing -->
				</div>
				<div class="row">

					<?php if(isset($alert)) { ?>
					<div class="col-lg-6 col-md-6 col-xs-12 col-lg-push-6 col-md-push-6">
						<?php if(isset($alert['success'])) { ?>
						<div class="alert alert-success"><strong><?=$alert['success'];?></strong></div>
						<?php } ?>

						<?php if(isset($alert['error'])) { ?>
						<div class="alert alert-warning"><strong>Error's Found: </strong>
							<i><ul>								
								<?php//print_r($alert['error']);?>
								<?php foreach ($alert['error'] as $key => $value) { echo '<li>'.$value.'</li>'; } ?>
							</ul></i>
						</div>
						<?php } ?>
					</div>
					<?php } ?>

					<?php if($user->editView($_GET['id']) != '') { ?>
						<!-- col-lg-pull-6 col-md-pull-6 -->
						<div class="col-lg-6 col-md-6 col-xs-12 <?=(isset($alert)) ? 'col-lg-pull-6 col-md-pull-6' : 0;?>">
							<div class="panel panel-primary">
								<div class="panel-body">
									<?php $data = $user->editView($_GET['id']); ?>
									<form action="<?=HTTPHOST;?>edit.php?id=<?=$data['user_id'];?>" method="POST">
										<div class="form-group">
											<label for="firstname">First name <span class="text-warning">*</span></label>
											<input value="<?=$data['user_firstname'];?>" name="firstname" type="text" class="form-control" placeholder="First name" required>
										</div>
										<div class="form-group">
											<label for="lastname">Last name <span class="text-warning">*</span></label>
											<input value="<?=$data['user_lastname'];?>" name="lastname" type="text" class="form-control" placeholder="Last name" required>
										</div>
										<div class="form-group">
											<label for="email">Email <span class="text-warning">*</span></label>
											<input value="<?=$data['user_email'];?>" name="email" type="email" class="form-control" placeholder="Email" required>
										</div>
										<div class="form-group">
											<label for="phonenumber">Phone number <span class="text-warning">*</span></label>
											<input value="<?=$data['user_phonenumber'];?>" name="phonenumber" type="text" class="form-control" placeholder="Phone number" required>
										</div>
										<input value="<?=$data['user_id'];?>" type="hidden" name="id" value="<?=$_GET['id'];?>">
										<button name="update" type="submit" class="btn btn-primary btn-block">update data</button>
									</form>
								</div>
							</div>
						</div>
					<?php } else { ?>
						<div class="col-lg-6 col-md-6 col-xs-12">
							<div class="alert alert-warning">
								<strong>Error</strong>, User not found! You cannot edit that user.
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
