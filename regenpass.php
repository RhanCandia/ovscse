<?php

include('core/init.inc.php');

function regenPass($sid) {

	$newPass = rand_pass(8);

	if (mysql_query("UPDATE `users` SET `password` = '{$newPass}' WHERE `user_id` = {$sid}")) {
		return true;
	} else {
		return false;
	}

}

?>

<!DOCTYPE html>
<html>
  <head>
    <title>Voting Site - Regen Passwords</title>
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen" />
    <link href="misc/css/index.css" rel="stylesheet" media="screen" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="bootsrap/assets/css/bootstrap-responsive.css" rel="stylesheet" />
	
	<script type="text/javascript">
	// <![CDATA[
	function scrollToBottom(elm_id)
	{
	var elm = document.getElementById(elm_id);
	try
	{
	elm.scrollTop = elm.scrollHeight;
	}
	catch(e)
	{
	var f = document.createElement
	("input");
	if (f.setAttribute) f.setAttribute
	("type","text")
	if (elm.appendChild)
	elm.appendChild(f);
	f.style.width = "0px";
	f.style.height = "0px";
	if (f.focus) f.focus();
	if (elm.removeChild)
	elm.removeChild(f);
	}
	}
	// ]]>
	</script>

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
          <legend>Password Regeneration</legend>
				<?php

				$totalUsers		=	mysql_query("SELECT * FROM `users` WHERE `department` <> 'ADMIN'");

				$all = array();

				while (($row = mysql_fetch_assoc($totalUsers)) !== false) {
					$all[] = $row;
				}

				$cap	=	count($all);

				?>

				<div style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px;">

						<form action="" method="post">

							<input name="generate" class="btn btn-primary btn-block btn-large" type="submit" value="REGENERATE PASSWORDS" />

						</form>

						<input type="button" class="btn btn-block" value="SCROLL" onclick="scrollToBottom('regens')" />

				<div id="regens" style="margin-top: 10px; margin-bottom: 10px; max-height: 200px; overflow: auto; border: solid 1px black; background-color: #000; color: #FFF;">

				<?php
				
					if (isset($_POST['generate'])) {

						for ($i = 0; $i < $cap; $i++) { 
							regenPass($i);
							echo "<p style='text-indent: 1.6em; margin-bottom: 0px; margin-top: 0px;'>" . ($i + 1) . " Account Password(s) Changed!</p>";
						}

						?>
						<br />
						<div class="alert alert-info" style="text-align: center;">
							PASSWORD REGENERATION SUCCESSFUL!
						</div>
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