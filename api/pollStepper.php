<?php
    include_once("../classes/Database.php");
    $db = new Database("localhost", "root", "3DPr1ntPalace!!C");

    $activePolls = $db->getActivePolls();
    foreach ($activePolls as $key => $value) {
        if (strtotime($value['end_date']) < strtotime('now')) {
            $db->endPoll($value['poll_id']);
        }
    }
?>