<?php
// error_reporting(E_ALL);
//     ini_set('display_errors', 1);
    $username = $_REQUEST['inputUsername'];
    $skinName = $_REQUEST['inputSkinName'];
    if (isset($_REQUEST['inputPollKeyCreate'])) {
        $createPoll = true;
    } else {
        $createPoll = false;
    }
    $target_dir = "../img/";
    $target_file = $target_dir . basename($_FILES["skinFile"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    if(isset($_POST["submit"])) {
        $check = getimagesize($_FILES["skinFile"]["name"]);
        if($check !== false) {
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }
    }

    // // Check if file already exists
    // if (file_exists($target_file)) {
    //     echo "Sorry, file already exists.";
    //     $uploadOk = 0;
    // }
    
    // Check file size
    if ($_FILES["skinFile"]["size"] > 50000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }
    
    // Allow certain file formats
    if($imageFileType != "png") {
        echo "Sorry, only PNG files are allowed.";
        $uploadOk = 0;
    }
    
    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
        exit();
    // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["skinFile"]["tmp_name"], $target_file)) {
            //echo "The file ". htmlspecialchars( basename( $_FILES["skinFile"]["name"])). " has been uploaded.";
        } else {
            echo "Sorry, there was an error uploading your file.";
            exit();
        }
    }

    include_once("../classes/Database.php");
    $db = new Database("localhost", "root", "3DPr1ntPalace!!C");

    if ( isset($_REQUEST['inputPollKeyCreate']) ) {
        if ( $_REQUEST['inputPollKey'] != '' ) {
            $pollKey = $_REQUEST['inputPollKey'];
        }
        else {
            $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $charactersLength = strlen($characters);
            $randomString = '';
            for ($i = 0; $i < 5; $i++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            }
            $pollKey = $randomString;
        }
        $db->createPoll($pollKey);
    }
    else {
        $pollKey = $_REQUEST['inputPollKey'];
    }

    $poll = $db->getPollByKey($pollKey);

    $skinID = $db->insertSkin(
        $target_dir . $poll['poll_id'] . ".png",
        $username,
        $skinName
    );

    $db->linkSkinToPoll($poll['poll_id'], $skinID);

    $pollID = $poll['poll_id'];
    $p = ((int)$pollID * 42) / 32;

    rename($target_file, $target_dir . $pollID . ".png");

    if (isset($randomString)) {
        echo "<h1>Poll Key: ";
        echo $randomString;
        echo "</h1>";
        echo "<a href='" . '../poll.php?p=' . $p . "'><h3>Go to Poll</h3></a>";
    }
    else {
        header('Location: ../poll.php?p=' . $p);
    }
    exit();
?>