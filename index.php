<?php
	
	include('core/init.inc.php');
	
	if (isset($_POST['studID'], $_POST['password'])) {
		$errors = array();
		if (empty($_POST['studID'])) {
			$errors[] = "Username ID can not be empty.";
		}
		if (empty($_POST['password'])) {
			$errors[] = "Password can not be empty.";
		}
		
		if (empty($errors)) {
		
			if (valid_credentials($_POST['studID'], $_POST['password']) === false) {
				$errors[] = "UserID and/or Password did not match.";
			} else {
			
				$_SESSION['studID'] = $_POST['studID'];
				$_SESSION['userName'] = get_userName($_POST['studID']);
				$_SESSION['studDept'] = get_userDept($_POST['studID']);
				$_SESSION['userGroup'] = get_userGroup($_POST['studID']);
				
				if ($_SESSION['userGroup'] === 'admin') {
					header('Location: adminpanel.php');
				}
				if ($_SESSION['userGroup'] === 'user') {
					header('Location: home.php');
				}
				if ($_SESSION['userGroup'] === 'encoder') {
					header('Location: reguser.php');
				}
			
			}
		}
	}
	
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Voting Site - Log in</title>
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
      <br />
      <br />
      <br />
      <div class="row-fluid">
        <div class="span4 offset4" id="login">
          <legend>Login</legend>
          <?php if (empty($errors) === false) { ?>
          <div class="row-liquid span8 offset2" id="error" style="color: red;">
          <ul>
          <?php foreach ($errors as $error) { ?>
          	<li><?php echo $error; ?></li>
          <?php } ?>
          </ul>
          </div>
          <?php } ?>
          <form class="form-horizontal" action="" method="post">
            <div class="row-liquid">
              <input class="input-xlarge span8 offset2" name="studID" type="text" placeholder="Student ID" />
            </div>
            <br />
            <div class="row-liquid">
              <input class="input-xlarge span8 offset2" name="password" type="password" placeholder="Password" />
            </div>
            <br />
            <div class="row-liquid">
              <input class="btn btn-large btn-primary span8 offset2" type="submit" value="Login" />
            </div>
          </form>
        </div>
      </div>
    </div>

    <script src="bootstrap/js/jquery.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
  </body>
</html>