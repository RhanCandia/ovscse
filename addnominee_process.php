<?php

include('core/init.inc.php');


    if (isset($_POST['bid'], $_POST['pos_id'], $_POST['nom_name'], $_FILES['nom_photo'], $_POST['nom_party'], $_POST['nom_bio'])) {
    $errorName = 0;
    if (empty($_POST['nom_name'])) {
        $errorName = 1;
    }
    $errorBio = 0;
    if (empty($_POST['nom_bio'])) {
        $errorBio = 1;
    }
    if ($errorName === 0 && $errorBio === 0) {
    	
    	$ext = substr($_FILES['nom_photo']['name'], -4);
    	$tmpName = array();
    	$tmpName = preg_split('#\s+#', $_POST['nom_name']);
    	$picname = strtolower(implode('', $tmpName)) . $_POST['bid'] . ".png";
    	
    	move_uploaded_file($_FILES['nom_photo']['tmp_name'], "misc/img/nominees/{$picname}");
        
        add_nominee($_POST['bid'], $_POST['pos_id'], $_POST['nom_name'], $_POST['nom_party'], $_POST['nom_bio']);
        header('Location: ballot.php?bid=' . $_POST['bid']);
    }
    }

?>