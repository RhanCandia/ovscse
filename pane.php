<!DOCTYPE html>
<html>
  <head>
	<meta charset="utf-8">
    <title>OVSCSE - Computer Society Elections</title>
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen" />
    <link href="misc/css/index.css" rel="stylesheet" media="screen" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="bootsrap/assets/css/bootstrap-responsive.css" rel="stylesheet" />
  </head>
  <body>
    
	  <?php if ($_SESSION['userGroup'] === 'admin') { ?>
	  	
	    <ul class="nav nav-tabs nav-stacked pull-left" id="staticNav">
	    	<li>
		    	<a href="#" style="color: red;">
		    		<div style="background-color: grey; color: white; font-weight: bolder; border: solid 1px gray; border-radius: 0px 0px 4px 0px; margin: 0px 4px 4px 0px; padding: 0px 4px 0px 4px; font-size: .8em; min-width: 4em; position: absolute; top: 0; left: 0;">
			    		Welcome
		    		</div>
		    		<br />
		    		<center>
		    			<strong><?php echo $_SESSION['userName']; ?> <i class="icon-user"></i></strong>
		    		</center>
		    	</a>
	    	</li>
	    	<li>
		    	<a href="home.php">Home</a>
	    	</li>
	    	<li>
		    	<a href="reguser.php">Register</a>
	    	</li>
	    	<li>
		    	<a href="adminpanel.php">Admin</a>
	    	</li>
	    	<li>
		    	<a href="#logoutModal" data-toggle="modal">Logout</a>
	    	</li>
	    </ul>
	  	
	  <?php } ?>
	  
	  <?php if ($_SESSION['userGroup'] === 'encoder') { ?>

	    <ul class="nav nav-tabs nav-stacked pull-left" id="staticNav">
	    	<li>
		    	<a href="#" style="color: red;">
		    		<div style="background-color: grey; color: white; font-weight: bolder; border: solid 1px gray; border-radius: 0px 0px 4px 0px; margin: 0px 4px 4px 0px; padding: 0px 4px 0px 4px; font-size: .8em; min-width: 4em; position: absolute; top: 0; left: 0;">
			    		Welcome
		    		</div>
		    		<br />
		    		<center>
		    			<strong><?php echo $_SESSION['userName']; ?> <i class="icon-user"></i></strong>
		    		</center>
		    	</a>
	    	</li>
	    	<li>
		    	<a href="#logoutModal" data-toggle="modal">Logout</a>
	    	</li>
	    </ul>

	  <?php } ?>
	  
	  <?php if ($_SESSION['userGroup'] === 'user') { ?>

	    <ul class="nav nav-tabs nav-stacked pull-left" id="staticNav">
	    	<li>
		    	<a href="#" style="color: red;">
		    		<div style="background-color: gray; color: white; font-weight: bolder; border: solid 1px grey; border-radius: 0px 0px 4px 0px; margin: 0px 4px 4px 0px; padding: 0px 4px 0px 4px; font-size: .8em; min-width: 4em; position: absolute; top: 0; left: 0;">
			    		Welcome
		    		</div>
		    		<br />
		    		<center>
		    			<strong><?php echo $_SESSION['userName']; ?> <i class="icon-user"></i></strong>
		    		</center>
		    	</a>
	    	</li>
	    	<li>
		    	<a href="home.php">Home</a>
	    	</li>
	    	<li>
		    	<a href="#logoutModal" data-toggle="modal">Logout</a>
	    	</li>
	    </ul>

	  <?php } ?>
	  

<!-- log out modal -->
	    
<div id="logoutModal" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="logoutModalLabel" aria-hidden="true">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		<h3 id="logoutModalLabel">Log out?</h3>
	</div>
	<div class="modal-body">
		<p>Are you sure you want to log out?</p>
	</div>
	<div class="modal-footer">
	    <button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
	    <a href="logout.php" class="btn btn-primary">Log out</a>
	</div>
</div>

    <script src="bootstrap/js/jquery.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
  </body>
</html>