<!DOCTYPE html>
<html>
  <head>
    <title>Voting Site - Add Nominee</title>
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen" />
    <link href="misc/css/index.css" rel="stylesheet" media="screen" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="bootsrap/assets/css/bootstrap-responsive.css" rel="stylesheet" />
  </head>
  <body>
    
    <div class="row-fluid">
        <div class="span8 offset2" id="content">
            <legend>Add Nominee</legend>
            <?php
            $availablePos = get_positions($_GET['bid']);
            if (empty($availablePos)) {
                ?>
                <div class="row-fluid">
                    <div class="span8 offset2" id="avpos">
                        <p>There are no available positions yet.</p>
                    </div>
                </div>
                <?php
            } else {
                ?>
                <div class="row-fluid">
                    <div class="span12">
                        <form class="form-horizontal" action="addnominee_process.php" method="post" enctype="multipart/form-data">
                        	<input type="hidden" name="bid" value="<?php echo $_GET['bid']; ?>" />
                            <div class="control-group">
                                <label class="control-label">Position</label>
                                <div class="controls">
                                    <select class="input-xlarge" name="pos_id">
                                    <?php
                                        foreach($availablePos as $key => $position) {
                                    ?>
                                        <option value="<?php echo $key; ?>"><?php echo $position; ?></option>
                                    <?php
                                        }
                                    ?>
                                    </select>
                                </div>
                            </div>
                            <div class="control-group <?php if ($errorName === 1) echo "error"; ?>">
                                <label class="control-label">Full Name</label>
                                <div class="controls">
                                    <input class="input-xlarge" type="text" name="nom_name" placeholder="<?php if ($errorName === 1) echo "This field is required."; ?>" value="<?php if (isset($_POST['nom_name'])) echo $_POST['nom_name']; ?>" />
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Picture (Max: 2MB)</label>
                                <div class="controls">
                                    <input class="input-xlarge" type="file" name="nom_photo" />
                                </div>
                            </div>                            
                            <div class="control-group">
                                <label class="control-label">Party</label>
                                <div class="controls">
                                    <input class="input-xlarge" type="text" name="nom_party" value="<?php if (isset($_POST['nom_party'])) echo $_POST['nom_party']; ?>" />
                                </div>
                            </div>
                            <div class="control-group <?php if ($errorBio === 1) echo "error"; ?>">
                                <label class="control-label">Catch Phrase</label>
                                <div class="controls">
                                    <textarea class="input-xlarge" name="nom_bio" rows="4" placeholder="<?php if ($errorBio === 1) echo "This field is required."; ?>"><?php if (isset($_POST['nom_bio'])) echo $_POST['nom_bio']; ?></textarea>
                                </div>
                            </div>
                            <div class="control-group">
                                <div class="controls input-prepend input-append">
                                    <input type="submit" class="btn btn-primary" value="Add Nominee" />
                                    <input type="reset" class="btn" value="Clear Form" />
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
    
    <script src="bootstrap/js/jquery.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
  </body>
</html>