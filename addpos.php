<?php

if (isset($_GET['bid'], $_POST['positions'])) {
    $errors = "";
    if (empty($_POST['positions'])) {
        $errors = "All positions removed.";
        rem_position($_GET['bid']);
        
        header('Location: ballot.php?bid=' . $_GET['bid']);
    } else {
        
        $positions = explode(',', $_POST['positions']);
        
        foreach($positions as $key => $value) {
            $positions[$key] = trim($value);
        }
        echo "<br />";
        
        add_position($_GET['bid'], $positions);
        header('Location: ballot.php?bid=' . $_GET['bid']);
    }
}

?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <title>Voting Site - Add Position</title>
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen" />
    <link href="misc/css/index.css" rel="stylesheet" media="screen" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="bootsrap/assets/css/bootstrap-responsive.css" rel="stylesheet" />
  </head>
  <body>
    
    <div class="row-fluid">
        <div class="span8 offset2" id="content">
            <legend>Add Position</legend>
            <div class="row-fluid">
                <div class="span8 offset2 alert alert-info" id="avpos">
                <?php
                    global $posStr;
                    $all_pos = get_positions($_GET['bid']);
                    $posStr = implode(', ', $all_pos);
                    $ouput = (empty($posStr)) ? "None." : $posStr;
                    echo "Current Available Positions : " . $ouput . "<br />";
                ?>
                </div>
            </div>
            <div class="row-fluid">
                <div class="span10 offset1">
                    <form class="form-horizontal" action="" method="post">
                        <div class="input-block-level">
                            <span class="add-on"><strong>Position  Titles</strong></span>
                        </div>

                            <div class="span10 offset1 alert alert-warning" id="avpos">
                                <p>Please enter the positions in highest to lowest order separated by commas.</p>
                                <p>Example : PositionOne, PositionTwo, PositionThree, …, PositionN</p>
                            </div>
                            <div class="alert alert-warning span10 offset1">
                              For special cases like <strong>Year Level Representatives</strong>, the position names should be <strong>1st Year Representative, 2nd Year Representative,<br />3rd Year Representative and 4th Year Representative</strong>.
                            </div>
                        
                            <input class="span10" name="positions" type="text" value="<?php echo $posStr; ?>" style="text-align: left;" />
                            <button class="btn btn-primary" type="submit" title="Save"><i class="icon-ok-sign icon-white"></i> Save</button>
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <script src="bootstrap/js/jquery.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
  </body>
</html>