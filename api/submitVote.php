<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    $poll = $_REQUEST['p'];
    $pollID = ($poll * 32) / 42;

    $skin = $_REQUEST['s'];
    $skinID = ($poll * 6) / 2;

    if(!empty($_SERVER['HTTP_CLIENT_IP'])){
        //ip from share internet
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    }elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
        //ip pass from proxy
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }else{
        $ip = $_SERVER['REMOTE_ADDR'];
    }

    session_start();

    if (isset($_SESSION['votes'])) {
        foreach ($_SESSION['votes'] as $key => $value) {
            if ($value == $pollID) {
                echo "<h1>You have already voted on this poll.<br>Please respect a fair vote by not trying to duplicate votes.</h1>";
                exit();
            }
        }
    }

    include_once("scripts/init.php");
    include_once("scripts/dbStartup.php");

    if (!isset($_SESSION['votes'])) {
        echo "<h1>Unauthorized use of this endpoint.</h1>";
        exit();
    }

    $db->recordVote($skinID, $ip, $pollID);

    if (isset($_SESSION['votes'])) {
        $_SESSION['votes'][] = $pollID;
    }
    else {
        $_SESSION['votes'] = array(
            $pollID
        );
    }

    $p = ($pollID * 42) / 32;
    header('Location: ../poll.php?p=' + $p);
    exit();
?>