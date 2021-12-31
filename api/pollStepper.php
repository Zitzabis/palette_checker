<?php
    include_once("../scripts/dbStartup.php");

    $activePolls = $db->getActivePolls();
    foreach ($activePolls as $key => $value) {
        if (strtotime($value['end_date']) < strtotime('now')) {
            $db->endPoll($value['poll_id']);
        }
    }
?>