<?php
	
include('core/init.inc.php');
			
	if (isset($_SESSION['userGroup'])) {
		if ($_SESSION['userGroup'] !== 'admin') {
			header('Location: home.php');
		}
	}

			if (isset($_POST['currentPassword'], $_POST['newPassword'], $_POST['newPasswordVerify'])) {
				$errPass = "";
				$confPass = "";
				
				if (empty($_POST['currentPassword']) || empty($_POST['newPassword']) || empty($_POST['newPasswordVerify'])) {
					$errPass = "All fields are required.";
				} else {
					$currPass = valid_credentials($_SESSION['studID'], $_POST['currentPassword']);
					if ($currPass === false) {
						$errPass = "The Current Password is Wrong.";
					}
					if ($_POST['newPassword'] !== $_POST['newPasswordVerify']) {
						$errPass = "New Passwords did not match.";
					}
					if (empty($errPass)) {
						$changed = admin_passChange($_SESSION['studID'], $_POST['newPassword']);
						if ($changed) {
							$errPass = "Password changed.";
						}
					}
				}
			}

?>
<!DOCTYPE html>
<html>
  <head>
  	<meta charset="utf-8">
	<title>Voting Site - Admin Panel</title>
	<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen" />
	<link href="misc/css/index.css" rel="stylesheet" media="screen" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<link href="bootsrap/assets/css/bootstrap-responsive.css" rel="stylesheet" />
  </head>
  <body>
	
	<div class="container-fluid" id="base">
		  	
		  	<br />
		  	
		  	<div class="row-fluid">
			  	<div class="span8 offset2" id="banner"></div>
		    </div>
		    
		    <br />
		  	
			<div class="row-fluid">
				<div class="span6 offset3" id="content">
					<legend>Admin Panel</legend>
						
								<?php if (empty($errPass) === false) { ?>
								<div class="control-group">
									<div class="span8 offset2 alert alert-info" style="text-align: center;">
										<?php echo $errPass; ?>
									</div>
									<br />
									<br />
								</div>
								<?php } ?>
								
						<div class="control-group"  style="padding: 30px;">
						
							<a class="btn btn-info btn-large btn-block" href="home.php" name="Ballot Settings">Ballot Settings</a>
						
							<a class="btn btn-info btn-large btn-block" href="viewusers.php" name="View Users">View Users</a>
						
							<a class="btn btn-info btn-large btn-block" href="viewresults.php" name="Ballot Results">Ballot Results</a>

							<a class="btn btn-info btn-large btn-block" href="regenpass.php" name="Regenerate Passwords">Regenerate Passwords</a>
							
							<a class="btn btn-info btn-large btn-block" href="#passwordModal" data-toggle="modal" name="Admin Password Change">Admin Password Change</a>
						
						</div>
					
				</div>
			</div>
			
			<br />
			<br />
	
	</div>
	
<!-- change password modal -->

<div id="passwordModal" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="passwordModalLabel" aria-hidden="true">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		<h3 id="passwordModalLabel">Admin Password Change</h3>
	</div>
	<div class="modal-body">
		<br />
		<br />
		
		<form class="form-horizontal" action="" method="post">
			<div class="control-group">
			    <label class="control-label" for="currentPassword">Current Password</label>
			    <div class="controls">
			      <input type="password" class="input-xlarge" id="currentPassword" name="currentPassword" maxlength="8" placeholder="Current Password" />
			    </div>
			</div>
			<div class="control-group">
			    <label class="control-label" for="newPassword">New Password</label>
			    <div class="controls">
			      <input type="password" class="input-xlarge" id="newPassword" name="newPassword" maxlength="8" placeholder="New Password" />
			    </div>
			</div>
			<div class="control-group">
			    <label class="control-label" for="newPasswordVerify">Verify New Password</label>
			    <div class="controls">
			      <input type="password" class="input-xlarge" id="newPasswordVerify" name="newPasswordVerify" maxlength="8" placeholder="Verify New Password" />
			    </div>
			</div>
	</div>
	<br />
	<div class="modal-footer">
		<button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
	    <input type="submit" class="btn btn-primary" value="Change">
	</div>
	</form>
</div>

	<script src="bootstrap/js/jquery.js"></script>
	<script src="bootstrap/js/bootstrap.min.js"></script>
  </body>
</html>