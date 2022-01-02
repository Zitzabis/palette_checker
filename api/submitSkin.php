<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    $usernameURL = $_REQUEST['inputUsername'];
    $skinNameURL = $_REQUEST['inputSkinName'];
    if (isset($_REQUEST['inputPollKeyCreate'])) {
        $createPoll = true;
    } else {
        $createPoll = false;
    }

    /****************/
    // Get username
    /****************/
    $context = stream_context_create(
        array(
            "http" => array(
                "header" => "User-Agent: Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/50.0.2661.102 Safari/537.36"
            )
        )
    );
    $usernamePage = file_get_contents($usernameURL, false, $context);
    $re = '/<div.id="member-title-primary">.<a.*><h1>(.*)<\/h1><\/a>/ms';
    preg_match_all($re, $usernamePage, $matches);

    // Print the entire match result
    $username = $matches[1][0];

    /****************/
    // Get skin name
    /****************/
    $context = stream_context_create(
        array(
            "http" => array(
                "header" => "User-Agent: Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/50.0.2661.102 Safari/537.36"
            )
        )
    );
    $skinPage = file_get_contents($skinNameURL, false, $context);
    $re = '/<a\nhref=".member.zitzabis." title="(.+)" class="alt pusername.+">.+<.a><br.>/';
    preg_match($re, $skinPage, $matches);

    // Print the entire match result
    $skinUsername = $matches[1];

    $re = '/<div\nid="resource-title-text"><h1>(.+)<\/h1>/';
    preg_match($re, $skinPage, $matches);

    // Print the entire match result
    $skinName = $matches[1];

    if ($skinUsername != $username) {
        echo "The skin's author does not match the profile you provided.";
        echo "<br>Profile: " . $_REQUEST['inputUsername'];
        echo "<br>Skin: " . $_REQUEST['inputSkinName'];

        echo "<br><br>Press the back button to modify the links you provided.";
        exit();
    }

    /****************/
    // Image Handling
    /****************/
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
        echo "Your file was not uploaded.";
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
    $db = new Database("localhost", "pbl", "vksqaPJoUpfEzBY2");

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
        if ( isset($_REQUEST['inputPollKey']) && $_REQUEST['inputPollKey'] != '' ) {
            $pollKey = $_REQUEST['inputPollKey'];
        }
        else {
            echo "You must define the poll you want to enter, or select the option to create a poll.";
            echo "<br><br>Press the back button to add a poll key or select the option to create a poll.";
            exit();
        }
    }

    $poll = $db->getPollByKey($pollKey);

    $skinID = $db->insertSkin(
        $target_dir . $pollKey . "_" . $username .".png",
        $username,
        $skinName
    );

    $db->linkSkinToPoll($poll['poll_id'], $skinID);

    $pollID = $poll['poll_id'];
    $p = ((int)$pollID * 42) / 32;

    rename($target_file, $target_dir . $pollKey . "_" . $username .".png");

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