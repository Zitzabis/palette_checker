<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Dashboard</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <button type="button" class="btn btn-sm btn-outline-secondary">Settings</button>
            <button type="button" class="btn btn-sm btn-outline-secondary">Logout</button>
        </div>
    </div>
</div>

<h2>Polls</h2>
<div class="table-responsive">
    <table class="table table-striped table-sm">
    <thead>
        <tr>
        <th scope="col">#</th>
        <th scope="col">Status</th>
        <th scope="col">Key</th>
        <th scope="col">Start Date</th>
        <th scope="col">End Date</th>
        <th scope="col">Time Left</th>
        <th scope="col">Skins</th>
        <th scope="col">Votes</th>
        </tr>
    </thead>

    <tbody>
        <?php
            $polls = $db->getPolls();
            foreach ($polls as $k => $poll) {
                $skins = $db->getSkinsForPoll($poll['poll_id']);
                $p = ($poll['poll_id'] * 42) / 32;
        ?>
            <tr onclick="window.location='<?php echo "admin.php?mode=singlePoll&poll=" . $poll['poll_id']; ?>';">
                <td><?php echo $poll['poll_id']; ?></td>
                
                <?php
                    if ($poll['active'] == 0) {
                        echo "<td style='color: coral'><b>Pending</b></td>";
                    }
                    if ($poll['active'] == 1) {
                        echo "<td style='color: ForestGreen'><b>Active</b></td>";
                    }
                    if ($poll['active'] == 2) {
                        echo "<td style='color: CornflowerBlue'><b>Done</b></td>";
                    }
                ?>
                
                <td><?php echo $poll['poll_key']; ?></td>
                <td><?php echo $poll['start_date']; ?></td>
                <td><?php echo $poll['end_date']; ?></td>
                <td>
                <script>
                    var endDate<?php echo $k ?> = new Date("<?php echo $db->getPoll($poll['poll_id'])['end_date']; ?>").getTime();

                    var timer<?php echo $k ?> = setInterval(function() {

                        let now<?php echo $k ?> = new Date().getTime();
                        let t<?php echo $k ?> = endDate<?php echo $k ?> - now<?php echo $k ?>;
                        
                        if (t<?php echo $k ?> >= 0) {
                        
                            let days<?php echo $k ?> = Math.floor(t<?php echo $k ?> / (1000 * 60 * 60 * 24));
                            let hours<?php echo $k ?> = Math.floor((t<?php echo $k ?> % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                            let mins<?php echo $k ?> = Math.floor((t<?php echo $k ?> % (1000 * 60 * 60)) / (1000 * 60));
                            let secs<?php echo $k ?> = Math.floor((t<?php echo $k ?> % (1000 * 60)) / 1000);
                        
                            document.getElementById("timer<?php echo $k ?>-days").innerHTML = days<?php echo $k ?> +
                            "<span class='label'>d</span>";
                        
                            document.getElementById("timer<?php echo $k ?>-hours").innerHTML = ("0"+hours<?php echo $k ?>).slice(-2) +
                            "<span class='label'>h</span>";
                        
                            document.getElementById("timer<?php echo $k ?>-mins").innerHTML = ("0"+mins<?php echo $k ?>).slice(-2) +
                            "<span class='label'>m</span>";
                        
                            document.getElementById("timer<?php echo $k ?>-secs").innerHTML = ("0"+secs<?php echo $k ?>).slice(-2) +
                            "<span class='label'>s</span>";
                            
                            if (days<?php echo $k ?> > 5) {
                                document.getElementById("timer<?php echo $k ?>").style.color = "lightgreen";
                            }
                            if (days<?php echo $k ?> < 5 && days<?php echo $k ?> > 2) {
                                document.getElementById("timer<?php echo $k ?>").style.color = "orange";
                            }
                            if (days<?php echo $k ?> < 2) {
                                document.getElementById("timer<?php echo $k ?>").style.color = "LightCoral";
                            }
                        } else {

                            document.getElementById("timer<?php echo $k ?>").innerHTML = "The countdown is over!";
                        
                        }
                        
                    }, 1000);

                    </script>
                    <h5 id="timer<?php echo $k ?>">
                        <span id="timer<?php echo $k ?>-days"></span>
                        <span id="timer<?php echo $k ?>-hours"></span>
                        <span id="timer<?php echo $k ?>-mins"></span>
                        <span id="timer<?php echo $k ?>-secs"></span>
                    </h5>
                </td>
                <td><?php echo sizeof($skins); ?>/<?php echo $poll['slots']; ?></td>
                <td>
                <?php
                    $totalVotes = 0;
                    foreach ($skins as $key => $value) {
                        $totalVotes += $db->getVotes($value['skin'])['num_votes'];
                    }
                    echo $totalVotes;
                ?>
                </td>
            </tr>
        <?php
            }
        ?>
    </tbody>
    </table>
</div>