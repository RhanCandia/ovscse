<?php

include('core/init.inc.php');

$positions = get_positions($_POST['bid']);
$pos_count = count($positions);


if ($_SESSION['studID'] !== null) {
	for ($rank = 0; $rank < $pos_count; $rank++) {
    	cast_vote($_POST['posRank' . $rank]);
    }
}

add_voter($_SESSION['studID'], $_POST['bid']);

$_SESSION['studID'] = null;

header('refresh: 8; url=index.php');

?>
<!DOCTYPE html>
<html>
  <head>
    <title>Voting Site - Confirm Cast</title>
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
        	<div class="span8 offset2" id="content">
        		<legend>Ticket</legend>
        		<blockquote style="text-align: justify;">
		        	<p>
		        		Your votes have been casted and you have been logged out.
	        		</p>
	        		<p>
		        		Thank you for voting.
	        		</p>
	        		<p>
	        			The results shall be posted after the elections.
	        		</p>
	        		<p>
		        		Please log in again after the election to view the results.
	        		</p>
        		</blockquote>
        		<br />
        	</div>
        </div>
        
        <br />

        <div class="row-fluid">
            <div class="span8 offset2" id="content">
                <div class="row-fluid">
                    <div class="span8 offset2">
                        <br />
                        <p class="alert alert-info" style="text-align: center;">You will be redirected in <span id="countdown">8</span> second(s).</p>
                        <script language="javascript">

                        var time_left = 8;
                        var cinterval;

                        function time_dec(){
                          time_left--;
                          document.getElementById('countdown').innerHTML = time_left;
                          if(time_left == 0){
                            clearInterval(cinterval);
                          }
                        }

                        cinterval = setInterval('time_dec()', 1000);

                        </script>
                        <a href="home.php"><button class="btn btn-large btn-block btn-primary">Back to Log in</button></a>
                        <br />
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="http://code.jquery.com/jquery-latest.js"></script>
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>