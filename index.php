<?php
include_once 'db.config.php';
(!isset($_GET['s'])) ? $_GET['s'] = '' : $_GET['s'] = $user->clean($_GET['s']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<title>Simple Add, Edit and View Data</title>
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
			<h2 class="text-primary">Simple Add, Edit and View Data</h2>
		</div>

		<div class="row">
			<div class="col-lg-12 col-md-12 col-xs-12">
				<div>
					<form action="<?=HTTPHOST;?>" method="GET" class="form-inline">
						<a href="<?=HTTPHOST;?>" class="btn btn-primary <?=(!isset($_GET['s']) || empty($_GET['s']) || $_GET['s'] == 'all') ? 'active' : '';?>" data-toggle="tooltip" data-placement="top" title="View all data"><i class="fa fa-eye"></i>&nbsp;&nbsp;View All</a>
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
				<h3>About <?=$user->viewCount($_GET['s'])?> Results</h3>
				<div class="table-responsive">
					<table class="table table-condensed table-bordered table-hover">
						<thead>
							<tr>
								<th width="90px">Actions</th>
								<th>ID</th>
								<th>First name</th>
								<th>Last name</th>
								<th>Email</th>
								<th>Phone number</th>
							</tr>
						</thead>
						<tbody><?=$user->view($_GET['s']);?></tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	
	<script src="<?=HTTPHOST;?>assets/js/jquery.min.js"></script>
	<script src="<?=HTTPHOST;?>assets/js/bootstrap.min.js"></script>
	<script src="<?=HTTPHOST;?>assets/js/main.js"></script>
</body>
</html>