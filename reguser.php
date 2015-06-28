<?php
    include('core/init.inc.php');
    
    if ($_SESSION['userGroup'] !== 'admin' && $_SESSION['userGroup'] !== 'encoder') {
        header('Location: home.php');
        die();
    }
    
    if (isset($_POST['studid'], $_POST['fname'], $_POST['lname'], $_POST['dept'])) {
        $errors;
        if (empty($_POST['studid']) || empty($_POST['fname']) || empty($_POST['lname']) || empty($_POST['dept'])) {
            $errors = "All fields are required.";
        }
        $added = "";
        if (empty($errors)) {
            
            if (user_exists($_POST['studid'])) {
                $errors = "Student ID is already registered.";
            } else {
                $feed = add_user($_POST['studid'], $_POST['lname'], $_POST['fname'], $_POST['dept']);
                if ($feed === true) {
                    $added = true;
                } else {
                    $added = false;
                }
            }
            
        }
    }
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Voting Site - Register</title>
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
      <div class="row-fluid">
        <div class="span4 offset4" id="login">
            <legend>Register User</legend>
            <form class="form-horizontal" action="" method="post">
            <?php
                if (empty($errors) === false) {
                ?>
                <div class="row-liquid span8 offset2" id="error" style="color: red;">
                <?php
                    echo $errors;
                ?>
                </div>
                <br />
                <br />
                <br />
                <?php
                }
                if (isset($added)) {
                if ($added === true) {
                ?>
                    <div class="row-liquid span8 offset2" id="error">
                <?php
                    echo $_POST['fname'] . " " . $_POST['lname'] . " was added successfully.";
                ?>
                </div>
                <br />
                <br />
                <br />
                <?php
                }
                }
            ?>

            <div class="row-liquid">
                <div class="control-group">
                 <input class="input-xlarge span8 offset2" name="studid" type="text" placeholder="Student ID" />
                </div>
            </div>
            <div class="row-liquid">
                <div class="control-group">
                 <input class="input-xlarge span8 offset2" name="fname" type="text" placeholder="First Name" />
                </div>
            </div>
            <div class="row-liquid">
                <div class="control-group">
                 <input class="input-xlarge span8 offset2" name="lname" type="text" placeholder="Last Name" />
                </div>
            </div>
            <div class="row-liquid">
                <div class="control-group">
                 <?php $colleges = get_colleges(); ?>
            		<select class="span8 offset2" name="dept">
		            	<?php foreach ($colleges as $college) { ?>
		            		<option value="<?php echo $college['ccode'] ?>"><?php echo $college['cname'] ?></option>
		            	<?php } ?>
	            	</select>
                </div>
            </div>
            <div class="row-liquid">
                 <input class="btn btn-large btn-primary span8 offset2" type="submit" value="Register" />
            </div>
            </form>
        </div>
      </div>
    </div>

    <script src="bootstrap/js/jquery.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
  </body>
</html>