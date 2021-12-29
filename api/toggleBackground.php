<?php
    session_start();

    if ($_SESSION['animatedBackground']) {
        $_SESSION['animatedBackground'] = false;
    } else {
        $_SESSION['animatedBackground'] = true;
    }

    header('Location: ' . $_REQUEST['u']);

?>