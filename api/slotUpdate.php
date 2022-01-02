<?php
    include_once("../classes/Database.php");
    $db = new Database("localhost", "pbl", "vksqaPJoUpfEzBY2");

    if (!function_exists('str_contains')) {
        function str_contains(string $haystack, string $needle): bool
        {
            return '' === $needle || false !== strpos($haystack, $needle);
        }
    }
    
    $updateURL = array();
    $newURL = array();
    $slotIDs = array();
    foreach ($_REQUEST as $key => $value) {
        if (str_contains($key, 'profileURLi')) {
            $slotIDTemp = str_replace("profileURLi", "", $key);
            $updateURL[] = array($slotIDTemp, $value);
        }
        if (str_contains($key, 'profileURLNew')) {
            $newURL[] = $value;
        }
        if (str_contains($key, 'slotID')) {
            $slotIDs[] = $value;
        }
    }

    foreach ($updateURL as $key => $value) {
        $db->updatePollSlot($value[0], $value[1]);
    }
    foreach ($newURL as $key => $value) {
        if ($value == "") {
            continue;
        }
        $db->insertToPollSlot($_REQUEST['poll'], $value);
    }

    $poll = $db->getPoll($_REQUEST['poll']);
    if ($poll['slots'] != $_REQUEST['pollSlots']) {
        $db->updatePollSlotTotal($_REQUEST['poll'], $_REQUEST['pollSlots']);
    }
    
    header("Location: ../admin.php?mode=singlePoll&poll=" . $_REQUEST['poll'])
?>