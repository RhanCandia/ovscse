<?php

include('core/init.inc.php');

?>
<!DOCTYPE html>
<html>
  <head>
  	<meta charset="utf-8">
	<title>Voting Site - Admin Panel</title>
	<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="all" />
	<link href="misc/css/index.css" rel="stylesheet" media="all" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<link href="bootsrap/assets/css/bootstrap-responsive.css" rel="stylesheet" />
  </head>
  <body>

	  <?php include('pane.php'); ?>
	
	  <div class="container-fluid" id="base">
		  	
		  <br />
		  <br />
		  	
		  <div class="row-fluid">
			  <div class="span8 offset2" id="content">
				  <legend>Registered Users</legend>
					<div class="row-fluid">			  
					  <div class="span6 offset1">
					  
					  	<form class="form-inline" action="" method="post">
						  	
						  	<?php $colleges = get_colleges(); ?>
						  	<select class="span10" name="dept">
							  	<?php foreach ($colleges as $college) { ?>
							  		<option value="<?php echo $college['ccode'] ?>"><?php echo $college['cname'] ?></option>
							  	<?php } ?>
							</select>
			            	
			            	<button type="submit" class="btn">View</form>
						  	
					  	</form>
					  	
					  </div>
					  
					  	<div class="span4">
						  	<button class="btn btn-block" onclick="window.print()">Print</button>
						</div>
						
					</div>

					<div class="row-fluid">
						<div class="span6 offset3">
							<form class="form-search" action="" method="post">
							  <input type="text" name="searchID" class="span9 search-query" placeholder="Search by ID" />
							  <button type="submit" class="btn">Search</button>
							</form>
						</div>
					</div>
			  
					<div class="row" id="section_to_print" style="overflow: hidden;">
						<div class="span10 offset1">
							<?php

								if (isset($_POST['searchID'])) {
									$result	=	find_user($_POST['searchID']);
									if (empty($result['id'])) {
										?>

											<div class="alert alert-error span8 offset2">
												<h5 style="text-align: center;">The student was not found in the database!</h5>
											</div>

										<?php
									} else {

										?>

											<table class="table table-hover">
												<thead>
													<tr>
														<th>Student ID</th>
														<th>College</th>
														<th>Name</th>
														<th>Password</th>
													</tr>
												</thead>
												<tbody>
													<tr>
														<td style="text-indent: 10px; min-width: 140px;">
															<?php echo $result['id']; ?>
														</td>
														<td style="text-indent: 10px; min-width: 100px;">
															<?php echo $result['department']; ?>
														</td>
														<td style="text-indent: 10px;">
															<?php echo $result['lastname'] . ", " . $result['firstname']; ?>
														</td>
														<td style="text-indent: 10px; font-family: 'Lucida Console'; font-weight: bolder;">
															<?php echo $result['password']; ?>
														</td>
													</tr>
												</tbody>
											</table>

										<?php

									}
								}

								if (isset($_POST['dept'])) {
									$users = list_users($_POST['dept']);
									?>
									
									<div class="alert alert-info" style="text-align: center;">
										Students registered under the <strong><?php echo get_collegeName($_POST['dept']); ?></strong>.
									</div>
									
									<table class="table table-hover">
									
										<thead>
											<tr>
												<th>
													Student ID
												</th>
												<th>
													Name
												</th>
												<th>
													Password
												</th>
											</tr>
										</thead>
										
										<tbody>
											
											<?php
												
												foreach ($users as $user) {
													?>
													
													<tr>
														<td>
															<?php echo $user['id']; ?>
														</td>
														<td>
															<?php echo $user['lastname'] . ", " . $user['firstname']; ?>
														</td>
														<td style="font-family: 'Lucida Console'; font-weight: bolder;">
															<?php echo substr(base64_decode($user['password']), 0, -4); ?>
														</td>
													</tr>
													
													<?php
												}
												
											?>
											
										</tbody>
									
									</table>
									
									<?php
								}
							?>
						</div>
					</div>
			  
			  </div>
		  </div>
	
	  </div>

	<script src="bootstrap/js/jquery.js"></script>
	<script src="bootstrap/js/bootstrap.min.js"></script>
  </body>
</html>