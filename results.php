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
			  <div class="span8 offset2" id="content" style="overflow: hidden;">
				  <legend>Ballot Result</legend>
					
			  
					<div class="row-fluid" id="section_to_print">
						<div class="span10 offset1">
							<?php
									$positions = get_positions($_GET['bid']);
									$pos_count = count($positions);
									
									?>
										<h1 style="text-align: center;"><?php echo get_ballot_name($_GET['bid']); ?></h1>
									<?php
									
									for ($rank = 0; $rank < $pos_count; $rank++) {
						                $nominees = get_nominees($_GET['bid'], $rank);
						                if (!empty($nominees)) {
						                    ?>
						                    <div class="alert alert-info">
							                    <?php echo $positions[$rank]; ?>
						                    </div>
						                    <hr />
						                    <table class="table table-hover" id="results">
							                    
							                    <thead>
								                    <th>
									                    Name
								                    </th>
								                    <th>
									                    Party
								                    </th>
								                    <th>
									                    Vote Count
								                    </th>
							                    </thead>
							                    
							                    <tbody>
							                    
							                    <?php foreach ($nominees as $nominee) { ?>
							                    
							                    	<tr>
								                    	<td>
									                    	<?php echo $nominee['n_name']; ?>
								                    	</td>
								                    	<td>
									                    	<?php echo $nominee['n_party']; ?>
								                    	</td>
								                    	<td>
									                    	<?php echo $nominee['votes']; ?>
								                    	</td>
							                    	</tr>
							                    
							                    <?php } ?>
							                    
							                    </tbody>
							                    
						                    </table>
						                    
						                    <?php
						                }
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