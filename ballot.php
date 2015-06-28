<?php

include('core/init.inc.php');

if (isset($_GET['bid'], $_GET['del'], $_GET['nid'])) {
    if ($_GET['del']) {
        del_nominee($_GET['bid'], $_GET['nid']);
        header('Location: ballot.php?bid=' . $_GET['bid']);
    }
}

?>
<!DOCTYPE html>
<html>
  <head>
    <title>Voting System - Ballot</title>
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen" />
    <link href="misc/css/index.css" rel="stylesheet" media="screen" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="bootsrap/assets/css/bootstrap-responsive.css" rel="stylesheet" />
  </head>
  <body>
    
    <?php
	    
		if (in_array($_SESSION['studID'], get_voters($_GET['bid'])) || get_status($_GET['bid']) === '1' && $_SESSION['userGroup'] !== 'admin' || (isActive($_GET['bid']) === '0' && $_SESSION['userGroup'] !== 'admin')) {
			
			?>
			
			<div class="container-fluid" id="base">
				<div class="row-fluid">
					<div class="span8 offset2" id="content" style="position: fixed; top: 35%; max-height: 200px;">
						<p>
							<br />
							<br />
							<h1 style="text-align: center;">This ballot is no longer available for you.</h1>
						</p>
					</div>
				</div>
			</div>
			
			<?php
			
			die();
		}
		
    ?>
    
    <div class="container-fluid">
        <br />
        <div class="row-fluid">
            <div class="span8 offset2" id="ballothead">
                <?php
                    if (isset($_GET['bid']) === false || valid_bid($_GET['bid']) === false) {
                        ?>
                        <br />
                        <br />
                        <br />                                                                        
                        <h2><?php echo "Ballot not found."; ?></h2>
                        <?php
                    } else {
                        $ballot = get_ballot($_GET['bid']);
                        ?>
                        <h2><?php echo $ballot['title']; ?></h2>
                        <hr />
                        <div class="span8 offset2">
                            <h4><?php echo $ballot['description']; ?></h4>
                        </div>
                        <?php
                    }
                ?>
            </div>
        </div>
        
        <!-- Ballot form starts here. -->
        
        <?php
        
        	$action = "";
        	
	        if ($ballot['active'] === '1') {
		        $action = "confirmcast.php";
	        }
	        
        ?>
        <form class="form-horizontal" action="<?php if ($ballot['active'] === '1') echo $action; ?>" method="post">
        <input type="hidden" name="bid" value="<?php echo $_GET['bid']; ?>" />
        <?php
            $positions = get_positions($_GET['bid']);
            $pos_count = count($positions);
            
            for ($rank = 0; $rank < $pos_count; $rank++) {
                $nominees = get_nominees($_GET['bid'], $rank);
                if (!empty($nominees)) {
                    ?>

                    <?php

                    if (($positions[$rank] === '2nd Year Representative' && get_yearLevel($_SESSION['studID']) === '1') || ($positions[$rank] === '2nd Year Representative' && get_yearLevel($_SESSION['studID']) === '0')) {
                        ?>

                        <div class="row-fluid">
                            <div class="span8 offset2" id="content" style="overflow: hidden;">
                                <legend><?php echo $positions[$rank]; ?></legend>
                                <table class="table table-hover" id="nominees">
                                        <thead>
                                            <tr>
                                                <th class="span1">&nbsp;</th>
                                                <th class="span5">Candidate Name</th>
                                                <th class="span4">Party</th>
                                                <th class="span1"></th>
                                            </tr>
                                        </thead>
                                    <?php
                                    foreach ($nominees as $nominee) {
                                        ?>
                                        <tbody>
                                            <tr>
                                                <td class="span1"><input type="radio" name="posRank<?php echo $rank; ?>" value="<?php echo $nominee['n_id']; ?>" <?php if ($ballot['active'] !== '1' && $ballot['archive'] !== '1') echo "disabled=\"disabled\""; ?> /></td>
                                                <td class="span5">
                                                    
                                                    <script>
                                                        $(function ()
                                                        { $("#<?php $name = array(); $name = preg_split('#\s+#', $nominee['n_name']); echo strtolower(implode('', $name)); ?>").popover({
                                                                                                                                                                                            title: '<?php echo $nominee['n_name']; ?>',
                                                                                                                                                                                            animation: true,
                                                                                                                                                                                            html: true,
                                                                                                                                                                                            trigger: 'hover',
                                                                                                                                                                                            placement: 'left',
                                                                                                                                                                                            content: '<div style="margin: auto;"><img data-src="holder.js/160x120" alt="160x120" style="width: 160px; height: 120px; margin: auto;" src="misc/img/nominees/<?php $name = array(); $name = preg_split('#\s+#', $nominee['n_name']); echo strtolower(implode('', $name)) . $_GET['bid']; ?>.png" /></div><hr /><div><?php echo $nominee['n_about']; ?></div>'
                                                                                                                                                                                        });
                                                        });
                                                    </script>
                                                    
                                                    <a href="#" id="<?php $name = array(); $name = preg_split('#\s+#', $nominee['n_name']); echo strtolower(implode('', $name)); ?>"><?php echo $nominee['n_name']; ?></a>
                                                </td>
                                                <td class="span4"><?php echo $nominee['n_party']; ?></td>
                                                <td class="span1">
                                                    <?php
                                                    if ($ballot['active'] !== '1') {
                                                        ?>
                                                        <a class="btn" href="ballot.php?bid=<?php echo $_GET['bid']; ?>&amp;del=true&amp;nid=<?php echo $nominee['n_id'] ?>"><i class="icon-remove"></i></a>
                                                        <?php
                                                    }
                                                    ?>
                                                </td>
                                            </tr>
                                        </tbody>
                                        <?php
                                    }
                                    ?>
                                </table>
                            </div>
                        </div>

                        <?php
                    }

                    if (($positions[$rank] === '3rd Year Representative' && get_yearLevel($_SESSION['studID']) === '2') || ($positions[$rank] === '3rd Year Representative' && get_yearLevel($_SESSION['studID']) === '0')) {
                        ?>

                        <div class="row-fluid">
                            <div class="span8 offset2" id="content" style="overflow: hidden;">
                                <legend><?php echo $positions[$rank]; ?></legend>
                                <table class="table table-hover" id="nominees">
                                        <thead>
                                            <tr>
                                                <th class="span1">&nbsp;</th>
                                                <th class="span5">Candidate Name</th>
                                                <th class="span4">Party</th>
                                                <th class="span1"></th>
                                            </tr>
                                        </thead>
                                    <?php
                                    foreach ($nominees as $nominee) {
                                        ?>
                                        <tbody>
                                            <tr>
                                                <td class="span1"><input type="radio" name="posRank<?php echo $rank; ?>" value="<?php echo $nominee['n_id']; ?>" <?php if ($ballot['active'] !== '1' && $ballot['archive'] !== '1') echo "disabled=\"disabled\""; ?> /></td>
                                                <td class="span5">
                                                    
                                                    <script>
                                                        $(function ()
                                                        { $("#<?php $name = array(); $name = preg_split('#\s+#', $nominee['n_name']); echo strtolower(implode('', $name)); ?>").popover({
                                                                                                                                                                                            title: '<?php echo $nominee['n_name']; ?>',
                                                                                                                                                                                            animation: true,
                                                                                                                                                                                            html: true,
                                                                                                                                                                                            trigger: 'hover',
                                                                                                                                                                                            placement: 'left',
                                                                                                                                                                                            content: '<div style="margin: auto;"><img data-src="holder.js/160x120" alt="160x120" style="width: 160px; height: 120px;" src="misc/img/nominees/<?php $name = array(); $name = preg_split('#\s+#', $nominee['n_name']); echo strtolower(implode('', $name)) . $_GET['bid']; ?>.png" /></div><hr /><div><?php echo $nominee['n_about']; ?></div>'
                                                                                                                                                                                        });
                                                        });
                                                    </script>
                                                    
                                                    <a href="#" id="<?php $name = array(); $name = preg_split('#\s+#', $nominee['n_name']); echo strtolower(implode('', $name)); ?>"><?php echo $nominee['n_name']; ?></a>
                                                </td>
                                                <td class="span4"><?php echo $nominee['n_party']; ?></td>
                                                <td class="span1">
                                                    <?php
                                                    if ($ballot['active'] !== '1') {
                                                        ?>
                                                        <a class="btn" href="ballot.php?bid=<?php echo $_GET['bid']; ?>&amp;del=true&amp;nid=<?php echo $nominee['n_id'] ?>"><i class="icon-remove"></i></a>
                                                        <?php
                                                    }
                                                    ?>
                                                </td>
                                            </tr>
                                        </tbody>
                                        <?php
                                    }
                                    ?>
                                </table>
                            </div>
                        </div>

                        <?php
                    }

                    if (($positions[$rank] === '4th Year Representative' && get_yearLevel($_SESSION['studID']) === '3') || ($positions[$rank] === '4th Year Representative' && get_yearLevel($_SESSION['studID']) === '0')) {
                        ?>

                        <div class="row-fluid">
                            <div class="span8 offset2" id="content" style="overflow: hidden;">
                                <legend><?php echo $positions[$rank]; ?></legend>
                                <table class="table table-hover" id="nominees">
                                        <thead>
                                            <tr>
                                                <th class="span1">&nbsp;</th>
                                                <th class="span5">Candidate Name</th>
                                                <th class="span4">Party</th>
                                                <th class="span1"></th>
                                            </tr>
                                        </thead>
                                    <?php
                                    foreach ($nominees as $nominee) {
                                        ?>
                                        <tbody>
                                            <tr>
                                                <td class="span1"><input type="radio" name="posRank<?php echo $rank; ?>" value="<?php echo $nominee['n_id']; ?>" <?php if ($ballot['active'] !== '1' && $ballot['archive'] !== '1') echo "disabled=\"disabled\""; ?> /></td>
                                                <td class="span5">
                                                    
                                                    <script>
                                                        $(function ()
                                                        { $("#<?php $name = array(); $name = preg_split('#\s+#', $nominee['n_name']); echo strtolower(implode('', $name)); ?>").popover({
                                                                                                                                                                                            title: '<?php echo $nominee['n_name']; ?>',
                                                                                                                                                                                            animation: true,
                                                                                                                                                                                            html: true,
                                                                                                                                                                                            trigger: 'hover',
                                                                                                                                                                                            placement: 'left',
                                                                                                                                                                                            content: '<div style="margin: auto;"><img data-src="holder.js/160x120" alt="160x120" style="width: 160px; height: 120px;" src="misc/img/nominees/<?php $name = array(); $name = preg_split('#\s+#', $nominee['n_name']); echo strtolower(implode('', $name)) . $_GET['bid']; ?>.png" /></div><hr /><div><?php echo $nominee['n_about']; ?></div>'
                                                                                                                                                                                        });
                                                        });
                                                    </script>
                                                    
                                                    <a href="#" id="<?php $name = array(); $name = preg_split('#\s+#', $nominee['n_name']); echo strtolower(implode('', $name)); ?>"><?php echo $nominee['n_name']; ?></a>
                                                </td>
                                                <td class="span4"><?php echo $nominee['n_party']; ?></td>
                                                <td class="span1">
                                                    <?php
                                                    if ($ballot['active'] !== '1') {
                                                        ?>
                                                        <a class="btn" href="ballot.php?bid=<?php echo $_GET['bid']; ?>&amp;del=true&amp;nid=<?php echo $nominee['n_id'] ?>"><i class="icon-remove"></i></a>
                                                        <?php
                                                    }
                                                    ?>
                                                </td>
                                            </tr>
                                        </tbody>
                                        <?php
                                    }
                                    ?>
                                </table>
                            </div>
                        </div>

                        <?php
                    }
/*
                    if (($positions[$rank] === '4th Year Representative' && get_yearLevel($_SESSION['studID']) === '4') || ($positions[$rank] === '4th Year Representative' && get_yearLevel($_SESSION['studID']) === '0')) {
                        ?>

                        <div class="row-fluid">
                            <div class="span8 offset2" id="content" style="overflow: hidden;">
                                <legend><?php echo $positions[$rank]; ?></legend>
                                <table class="table table-hover" id="nominees">
                                        <thead>
                                            <tr>
                                                <th class="span1">&nbsp;</th>
                                                <th class="span5">Candidate Name</th>
                                                <th class="span4">Party</th>
                                                <th class="span1"></th>
                                            </tr>
                                        </thead>
                                    <?php
                                    foreach ($nominees as $nominee) {
                                        ?>
                                        <tbody>
                                            <tr>
                                                <td class="span1"><input type="radio" name="posRank<?php echo $rank; ?>" value="<?php echo $nominee['n_id']; ?>" <?php if ($ballot['active'] !== '1' && $ballot['archive'] !== '1') echo "disabled=\"disabled\""; ?> /></td>
                                                <td class="span5">
                                                    
                                                    <script>
                                                        $(function ()
                                                        { $("#<?php $name = array(); $name = preg_split('#\s+#', $nominee['n_name']); echo strtolower(implode('', $name)); ?>").popover({
                                                                                                                                                                                            title: '<?php echo $nominee['n_name']; ?>',
                                                                                                                                                                                            animation: true,
                                                                                                                                                                                            html: true,
                                                                                                                                                                                            trigger: 'hover',
                                                                                                                                                                                            placement: 'left',
                                                                                                                                                                                            content: '<div style="margin: auto;"><img data-src="holder.js/160x120" alt="160x120" style="width: 160px; height: 120px;" src="misc/img/nominees/<?php $name = array(); $name = preg_split('#\s+#', $nominee['n_name']); echo strtolower(implode('', $name)) . $_GET['bid']; ?>.png" /></div><hr /><div><?php echo $nominee['n_about']; ?></div>'
                                                                                                                                                                                        });
                                                        });
                                                    </script>
                                                    
                                                    <a href="#" id="<?php $name = array(); $name = preg_split('#\s+#', $nominee['n_name']); echo strtolower(implode('', $name)); ?>"><?php echo $nominee['n_name']; ?></a>
                                                </td>
                                                <td class="span4"><?php echo $nominee['n_party']; ?></td>
                                                <td class="span1">
                                                    <?php
                                                    if ($ballot['active'] !== '1') {
                                                        ?>
                                                        <a class="btn" href="ballot.php?bid=<?php echo $_GET['bid']; ?>&amp;del=true&amp;nid=<?php echo $nominee['n_id'] ?>"><i class="icon-remove"></i></a>
                                                        <?php
                                                    }
                                                    ?>
                                                </td>
                                            </tr>
                                        </tbody>
                                        <?php
                                    }
                                    ?>
                                </table>
                            </div>
                        </div>

                        <?php
                    }
*/
                    if ($positions[$rank] !== '1st Year Representative' && $positions[$rank] !== '2nd Year Representative' && $positions[$rank] !== '3rd Year Representative' && $positions[$rank] !== '4th Year Representative') {

                    ?>

                    <div class="row-fluid">
                        <div class="span8 offset2" id="content" style="overflow: hidden;">
                            <legend><?php echo $positions[$rank]; ?></legend>
                            <table class="table table-hover" id="nominees">
                                    <thead>
                                        <tr>
                                            <th class="span1">&nbsp;</th>
                                            <th class="span5">Candidate Name</th>
                                            <th class="span4">Party</th>
                                            <th class="span1"></th>
                                        </tr>
                                    </thead>
                                <?php
                                foreach ($nominees as $nominee) {
                                    ?>
                                    <tbody>
                                        <tr>
                                            <td class="span1"><input type="radio" name="posRank<?php echo $rank; ?>" value="<?php echo $nominee['n_id']; ?>" <?php if ($ballot['active'] !== '1' && $ballot['archive'] !== '1') echo "disabled=\"disabled\""; ?> /></td>
                                            <td class="span5">
											    
											    <script>
													$(function ()
													{ $("#<?php $name = array(); $name = preg_split('#\s+#', $nominee['n_name']); echo strtolower(implode('', $name)); ?>").popover({
																																														title: '<?php echo $nominee['n_name']; ?>',
																																														animation: true,
																																														html: true,
																																														trigger: 'hover',
																																														placement: 'left',
																																														content: '<div style="margin: auto;"><img data-src="holder.js/160x120" alt="160x120" style="width: 160px; height: 120px;" src="misc/img/nominees/<?php $name = array(); $name = preg_split('#\s+#', $nominee['n_name']); echo strtolower(implode('', $name)) . $_GET['bid']; ?>.png" /></div><hr /><div><?php echo $nominee['n_about']; ?></div>'
																																													});
													});
												</script>
												
                                            	<a href="#" id="<?php $name = array(); $name = preg_split('#\s+#', $nominee['n_name']); echo strtolower(implode('', $name)); ?>"><?php echo $nominee['n_name']; ?></a>
                                            </td>
                                            <td class="span4"><?php echo $nominee['n_party']; ?></td>
                                            <td class="span1">
                                                <?php
                                                if ($ballot['active'] !== '1') {
                                                    ?>
                                                    <a class="btn" href="ballot.php?bid=<?php echo $_GET['bid']; ?>&amp;del=true&amp;nid=<?php echo $nominee['n_id'] ?>"><i class="icon-remove"></i></a>
                                                    <?php
                                                }
                                                ?>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <?php
                                }
                                ?>
                            </table>
                        </div>
                    </div>

                    <?php
                    }
                }
            }
        ?>
        
        <?php 
        if ($ballot['active'] == '1') {
        ?>
        <div class="row-fluid">
            <div class="span8 offset2" id="content">
                <legend>Submit Ballot</legend>
                <div class="control-group">
                    <div class="row-fluid">
                        <div class="span6 offset3">
							<div id="voteModal" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="voteModalLabel" aria-hidden="true">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
									<h3 id="voteModalLabel">Submit votes?</h3>
								</div>
								<div class="modal-body">
									<p>Please take time to review your votes before submitting.</p>
									<hr />
									<p>Once submitted, you can no longer change it or go back to this page. You will see your ticket and will be logged out after submission.</p>
								</div>
								<div class="modal-footer">
								    <button class="btn" data-dismiss="modal" aria-hidden="true">Return</button>
								    <input type="submit" class="btn btn-primary <?php if ($_SESSION['userGroup'] === 'admin') echo "disabled"; ?>" value="Submit" />
								</div>
							</div>
							<a href="#<?php if ($_SESSION['userGroup'] !== 'admin') echo "voteModal"; ?>" class="btn btn-large btn-primary offset3 <?php if ($_SESSION['userGroup'] === 'admin') echo "disabled"; ?>" data-toggle="modal">Submit</a>
                            <input class="btn btn-large" type="reset" value="Reset" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
        }
        ?>
        
        <!-- Ballot form ends here. -->
        </form>
    
    <?php
    if ($ballot['active'] !== '1' && $ballot['archive'] !== '1' && $_SESSION['userGroup'] === 'admin') {
        
        include('addpos.php');
        include('addnominee.php');

    }
    ?>    
    
    </div>

    <script src="bootstrap/js/jquery.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>

  </body>
</html>