<?php $poll = $db->getPoll($_REQUEST['poll']); ?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
<h1 class="h2">Poll</h1>
<div class="btn-toolbar mb-2 mb-md-0">
    <div class="btn-group me-2">
        <button type="button" class="btn btn-sm btn-outline-secondary">Settings</button>
        <button type="button" class="btn btn-sm btn-outline-secondary">Logout</button>
    </div>
</div>
</div>

<h2>
<?php
    $skins = $db->getSkinsForPoll($_REQUEST['poll']);
    foreach ($skins as $key2 => $skin) {
        $skin = $db->getSkin($skin['skin']);
        echo $skin['name'];
        if ($key2 != sizeof($skins) - 1) {
            echo " vs. ";
        }
    }
?>
</h2>
<script>
var endDate = new Date("<?php echo $poll['end_date']; ?>").getTime();

var timer = setInterval(function() {

    let now = new Date().getTime();
    let t = endDate - now;
    
    if (t >= 0) {
    
        let days = Math.floor(t / (1000 * 60 * 60 * 24));
        let hours = Math.floor((t % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        let mins = Math.floor((t % (1000 * 60 * 60)) / (1000 * 60));
        let secs = Math.floor((t % (1000 * 60)) / 1000);
    
        document.getElementById("timer-days").innerHTML = days +
        "<span class='label'>d</span>";
    
        document.getElementById("timer-hours").innerHTML = ("0"+hours).slice(-2) +
        "<span class='label'>h</span>";
    
        document.getElementById("timer-mins").innerHTML = ("0"+mins).slice(-2) +
        "<span class='label'>m</span>";
    
        document.getElementById("timer-secs").innerHTML = ("0"+secs).slice(-2) +
        "<span class='label'>s</span>";
        
        if (days > 5) {
            document.getElementById("timer").style.color = "lightgreen";
        }
        if (days < 5 && days > 2) {
            document.getElementById("timer").style.color = "orange";
        }
        if (days < 2) {
            document.getElementById("timer").style.color = "LightCoral";
        }
    } else {

        document.getElementById("timer").innerHTML = "The countdown is over!";
    
    }
    
}, 1000);

</script>
<h5 id="timer">
Ends in: 
<span id="timer-days"></span>
<span id="timer-hours"></span>
<span id="timer-mins"></span>
<span id="timer-secs"></span>
</h5>

<form action="api/submitSkin.php" method="post" enctype="multipart/form-data">
    <div class="row border" style="margin: 1rem">
        <div class="col">
            <div class="mb-3">
                <label for="startDate" class="form-label">Start Date</label>
                <?php
                    $date = new DateTime($db->getPoll($poll['poll_id'])['start_date']);
                ?>
                <input type="date" class="form-control" id="startDate" value="<?php echo $date->format('Y-m-d'); ?>">
            </div>
            <div class="mb-3">
                <label for="startDate" class="form-label">End Date</label>
                <?php
                    $date = new DateTime($db->getPoll($poll['poll_id'])['end_date']);
                ?>
                <input type="date" class="form-control" id="startDate" value="<?php echo $date->format('Y-m-d'); ?>">
            </div>
        </div>
        <div class="col">
            <div class="mb-3">
                <label for="startDate" class="form-label">Status</label>
                <select id="cars" name="cars" class="form-control">
                    <option value="draft" <?php if ($poll['active'] == 0) {echo "selected";} ?>>Draft</option>
                    <option value="active" <?php if ($poll['active'] == 1) {echo "selected";} ?>>Active</option>
                    <option value="done" <?php if ($poll['active'] == 2) {echo "selected";} ?>>Done</option>
                    <option value="deleted" <?php if ($poll['active'] == 3) {echo "selected";} ?>>Deleted</option>
                </select>
            </div>
        </div>
        <div class="col">
            <div class="mb-3">
                <label for="pollKey" class="form-label">Poll Key</label>
                <input type="text" class="form-control" id="pollKey" value="<?php echo $poll['poll_key']; ?>">
            </div>
        </div>
        <h2 class="text-center">
            <input style="margin-top:1rem;" class="btn btn-success" type="submit" value="Save">
        </h2>
    </div>
</form>

<form action="api/slotUpdate.php" method="post" enctype="multipart/form-data">
    <div class="row border" style="margin: 1rem">
        <h3>Slots</h3>
        <div class="col-4">
            <div class="mb-3">
                <label for="pollSlots" class="form-label">Available slots (# of possible entries to the poll)</label>
                <input type="text" class="form-control" id="pollSlots" name="pollSlots" value="<?php echo $poll['slots']; ?>">
            </div>
        </div>
        <div class="col-8" style="border-left: 4px dotted black;">
            <?php
                $pollSlots = $db->getPollSlots($poll['poll_id']);
                echo '<input type="hidden" name="poll" value="' . $poll['poll_id'] . '">';
                for ($i=0; $i < $poll['slots']; $i++) {
                    echo "<h4>". ($i+1) ."</h4>";
                    if (isset($pollSlots[$i])) {
                        echo '<input type="hidden" name="slotID' . $pollSlots[$i]['slots_id'] . '" value="' . $pollSlots[$i]['slots_id'] . '">';
                        echo '<input type="text" class="form-control" id="profileURLi" name="profileURLi' . $pollSlots[$i]['slots_id'] . '" value="' . $pollSlots[$i]['url'] . '">';
                    }
                    else {
                        echo '<input type="text" class="form-control" id="profileURL" name="profileURLNew' . $i . '" value="">';
                    }
                }
            ?>
        </div>
        <h2 class="text-center">
            <input style="margin-top:1rem;" class="btn btn-success" type="submit" value="Save">
        </h2>
    </div>
</form>

<hr>

<div class="row">
    <h3>Submitted Skins</h3>
    <?php
        for ($i=0; $i < $poll['slots']; $i++) {
            if (isset($skins[$i])) {
                $skin = $db->getSkin($skins[$i]['skin']);
    ?>
                <div class="col border bg-light" style='padding: 1rem; margin: 0.3rem'>
                    <h4>Skin <?php echo $i+1; ?></h4>
                    <div class="mb-3">
                        <label for="skinName" class="form-label">Skin Name</label>
                        <input type="text" class="form-control" id="skinName" value="<?php echo $skin['name']; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="skinAuthor" class="form-label">Author</label>
                        <input type="text" class="form-control" id="skinAuthor" value="<?php echo $skin['author']; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="dateUploaded" class="form-label">Date Uploaded</label><br>
                        <b><?php echo $skin['date_uploaded']; ?></b>
                    </div>
                    <div class="mb-3">
                        <label for="skinPath" class="form-label">Skin File</label>
                        <input type="text" class="form-control" id="skinPath" value="<?php echo $skin['path']; ?>">
                    </div>
                </div>
    <?php
            }
            else {
    ?>
                <div class="col border bg-light" style='padding: 1rem; margin: 0.3rem'>
                    <h4>Skin <?php echo $i+1; ?></h4>
                    <div class="mb-3">
                        <label for="skinName" class="form-label">Skin Name</label>
                        <input type="text" class="form-control" id="skinName" value="" disabled>
                    </div>
                    <div class="mb-3">
                        <label for="skinAuthor" class="form-label">Author</label>
                        <input type="text" class="form-control" id="skinAuthor" value="" disabled>
                    </div>
                    <div class="mb-3">
                        <label for="dateUploaded" class="form-label">Date Uploaded</label><br>
                        <b>-</b>
                    </div>
                    <div class="mb-3">
                        <label for="skinPath" class="form-label">Skin File</label>
                        <input type="text" class="form-control" id="skinPath" value="" disabled>
                    </div>
                </div>
    <?php
            }
        }
    ?>
</div>