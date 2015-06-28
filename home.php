<?php

include('core/init.inc.php');

if (isset($_GET['action'], $_GET['id'])) {
    ballot_action($_GET['id'], $_GET['action']);
    header('Location: home.php');
}

if (isset($_GET['end'], $_GET['id'])) {
	end_ballot($_GET['id']);
	header('Location: home.php');
}


if (isset($_GET['start'], $_GET['id'])) {
	start_ballot($_GET['id']);
	header('Location: home.php');
}

$errname = 0;
$errdesc = 0;
$errdept = 0;

if (isset($_POST['ballotName'], $_POST['dept'], $_POST['ballotDesc'])) {
    if (empty($_POST['ballotName'])) {
        $errname = 1;
    }
    if (empty($_POST['dept'])) {
	    $errdept = 1;
    }
    if (empty($_POST['ballotDesc'])) {
        $errdesc = 1;
    }
    if ($errname === 0 && $errdesc === 0) {
        add_ballot($_POST['ballotName'], $_POST['dept'], $_POST['ballotDesc']);
        header('Location: home.php');
    }
}

?>
<!DOCTYPE html>
<html>
  <head>
    <title>Voting Site - Home</title>
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
        <div class="span8 offset2" id="content" style="min-height: 400px;">
          
          <ul id="ballotTabs" class="nav nav-tabs">
            <li class="active">
              <a href="#activeBallots" data-toggle="tab">Active Ballots</a>
            </li>
            <?php if ($_SESSION['userGroup'] === 'admin') { ?>
            <li>
              <a href="#queuedBallots" data-toggle="tab">Queued Ballots</a>
            </li>
            <li>
              <a href="#archivedBallots" data-toggle="tab">Archived Ballots</a>
            </li>
            <li>
              <a href="#newBallot" data-toggle="tab">New Ballot</a>
            </li>
            <?php } ?>
          </ul>

          <div id="ballotContents" class="tab-content">

            <div class="tab-pane fade in active" id="activeBallots">
              <div class="alert alert-info span10 offset1">
                
                  These are the ballots available for <?php echo get_collegeName(get_userDept($_SESSION['studID'])); ?>.

                <?php if ($_SESSION['userGroup'] === 'user') { ?>
                  <br />
                  <br />
                  If multiple ballots are available, you can cast your votes on each ballot. Just log in again after completing one ballot. Ballot results will be posted once the elections are over. To see the results, just log in again with your account.
                
                <?php } ?>
              </div>
              <table class="table table-hover" id="ballots"> 
                <?php
                  $a_ballots = get_active_ballots();
                  if ($a_ballots) {
                    foreach ($a_ballots as $ballot) {
                      ?>
                        
                        <?php if ($_SESSION['studDept'] === $ballot['department'] || $_SESSION['userGroup'] === 'admin') { ?>
                        
                        <?php
                          
                          $voters = get_voters($ballot['id']);
                          $voted = ((in_array($_SESSION['studID'], $voters)) ? true : false);
                          
                        ?>
                        
                        <tr>
                          <td>
                            <?php if ($voted === false && $ballot['status'] === '0') { ?>
                              <a href="ballot.php?bid=<?php echo $ballot['id']; ?>"><?php echo $ballot['title'] ?></a>
                            <?php } else { ?>
                              <strong style="color: blue;"><?php echo $ballot['title'] ?></strong>
                            <?php } ?>
                          </td>
                          <td>
                              
                              <?php if ($_SESSION['userGroup'] === 'admin') { ?>
                              
                              <a href="?action=0&amp;id=<?php echo $ballot['id']; ?>" title="Queue"><i class="icon-time"></i></a>
                              &nbsp;
                              <a href="?action=2&amp;id=<?php echo $ballot['id']; ?>" title="Archive"><i class="icon-folder-open"></i></a>
                              &nbsp;
                              <a href="?action=3&amp;id=<?php echo $ballot['id']; ?>" title="Delete"><i class="icon-trash"></i></a>
                              &nbsp;
                              <?php if ($ballot['status'] === '0') { ?>
                                <a href="?end=true&amp;id=<?php echo $ballot['id']; ?>" title="End"><i class="icon-stop"></i></a>
                              <?php } else { ?>
                                <a href="?start=true&amp;id=<?php echo $ballot['id']; ?>" title="Start"><i class="icon-play"></i></a>
                              <?php } ?>
                              
                              <?php } else { ?>
                              
                                <?php echo ($ballot['status'] === '0' ? "On Going …" : "Voting is closed …"); ?>
                              
                              <?php } ?>
                              
                          </td>
                          <td>
                          <?php if ($_SESSION['userGroup'] !== 'admin') { ?>
                            <?php if ($ballot['status'] === '0') {   ?>
                              
                              <?php if ($voted === false) { ?>
                                <a href="ballot.php?bid=<?php echo $ballot['id']; ?>">Click here to vote!</a>
                              <?php } else { ?>
                                <strong style="color: red;">Already voted!</strong>
                              <?php } ?>
                              
                            <?php } else {
                            ?>
                              <a href="results.php?bid=<?php echo $ballot['id']; ?>">View results!</a>
                            <?php
                            } ?>
                        <?php } else { ?>
                          
                          <?php echo ($ballot['status'] === '0' ? "On Going …" : "Voting is closed …"); ?>
                          
                        <?php } ?>
                          </td>
                        </tr>
                        
                        <?php } ?>
                        
                      <?php
                    }
                  }
                ?>
              </table>

            </div>

          <?php if ($_SESSION['userGroup'] === 'admin') { ?>

            <div class="tab-pane fade" id="queuedBallots">
              <div class="alert alert-info span10 offset1">
                  These are the queued ballots that are subject to adding the nominees for each ballot.
              </div>
              <table class="table table-hover" id="ballots">
                  <?php
                    $qu_ballots = get_queue_ballots();
                    if ($qu_ballots) {
                      foreach ($qu_ballots as $ballot) {
                        ?>
                          <tr>
                            <td><a href="ballot.php?bid=<?php echo $ballot['id']; ?>"><?php echo $ballot['title'] ?></a></td>
                            <td>
                                <a href="?action=1&amp;id=<?php echo $ballot['id']; ?>" title="Activate"><i class="icon-off"></i></a>
                                &nbsp;
                                <a href="?action=2&amp;id=<?php echo $ballot['id']; ?>" title="Archive"><i class="icon-folder-open"></i></a>
                                &nbsp;
                                <a href="?action=3&amp;id=<?php echo $ballot['id']; ?>" title="Delete"><i class="icon-trash"></i></a>
                            </td>
                            <td>...</td>
                          </tr>
                        <?php
                      }
                    }
                  ?>
              </table>

            </div>

            <div class="tab-pane fade" id="archivedBallots">
              <div class="alert alert-info span10 offset1">
                These are the past ballots kept for various reasons like documentation.
              </div>
              <table class="table table-hover" id="ballots">
                  <?php
                    $ar_ballots = get_archive_ballots();
                    if ($ar_ballots) {
                      foreach ($ar_ballots as $ballot) {
                        ?>
                          <tr>
                            <td><a href="ballot.php?bid=<?php echo $ballot['id']; ?>"><?php echo $ballot['title'] ?></a></td>
                            <td>
                                <a href="?action=0&amp;id=<?php echo $ballot['id']; ?>" title="Queue"><i class="icon-time"></i></a>
                                &nbsp;
                                <a href="?action=1&amp;id=<?php echo $ballot['id']; ?>" title="Activate"><i class="icon-off"></i></a>
                                &nbsp;
                                <a href="?action=3&amp;id=<?php echo $ballot['id']; ?>" title="Delete"><i class="icon-trash"></i></a>
                            </td>
                            <td>...</td>
                          </tr>
                        <?php
                      }
                    }
                  ?>
              </table>

            </div>

            <div class="tab-pane fade" id="newBallot">
              <div class="alert alert-info span10 offset1">
                  Create a new ballot for a poll or election here. Created ballots will go strait to the Queued Ballots tab. There then you will have to add the nominees / candidates for that ballot.
              </div>
              <form class="form-horizontal" action="" method="post">
                <div class="control-group <?php if ($errname === 1) echo "error"; ?>">
                  <label class="control-label">Ballot Title</label>
                  <div class="controls">
                    <input type="text" name="ballotName" class="span10" placeholder="<?php if ($errname === 1) echo "This field is required."; ?>" value="<?php if (isset($_POST['ballotName'])) echo htmlentities($_POST['ballotName']); ?>" />
                  </div>
                </div>
                <div class="control-group <?php if ($errdept === 1) echo "error"; ?>">
                  <label class="control-label">College Department</label>
                  <div class="controls">
                    <?php $colleges = get_colleges(); ?>
                    <select class="span8" name="dept">
                      <?php foreach ($colleges as $college) { ?>
                        <option value="<?php echo $college['ccode'] ?>"><?php echo $college['cname'] ?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
                <div class="control-group <?php if ($errdesc === 1) echo "error"; ?>">
                  <label class="control-label">Ballot Description</label>
                  <div class="controls">
                    <textarea name="ballotDesc" rows="3" class="span10" placeholder="<?php if ($errdesc === 1) echo "This field is required."; ?>"><?php if (isset($_POST['ballotDesc'])) echo htmlentities($_POST['ballotDesc']); ?></textarea>
                  </div>
                </div>
                <div class="control-group">
                  <label class="control-label"></label>
                  <div class="controls input-prepend input-append">
                    <input type="submit" class="btn btn-large btn-primary" value="Create Ballot" />
                    <input type="reset" class="btn btn-large" value="Clear Form" />
                  </div>
                </div>
              </form>

            </div>
          <?php } ?>
          </div>
          
        </div>
      </div>

    </div>

    <script src="bootstrap/js/jquery.js"></script>
    <script src="bootsrap/js/bootstrap.min.js"></script>
  </body>
</html>