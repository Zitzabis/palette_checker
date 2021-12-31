<?php
if (session_id() == ''){
    session_start();
}
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    include_once("scripts/dbStartup.php");

    $poll = $_REQUEST['p'];
    $pollID = ($poll * 32) / 42;
    $skins = $db->getSkinsForPoll($pollID);
    $pollDB = $db->getPoll($pollID);
?>

<!DOCTYPE html>
<html>
    <?php
        include_once("components/head.php");
        include_once("components/scripts.php");
    ?>
    <style>
        .pageContent {
            color: white;
            /* overflow:auto;
            overflow-y:auto; */
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.6.0/dist/chart.min.js"></script>
    <body>
        <main>
            <div class="pageContent centerContent container-fluid"> 
                <div class="row align-items-center flexContentMobile" style="height: 100%;">
                    <div class="col-8 offset-2" id="mainContent">
                        <div class='text-center' style='padding:1rem;'>
                            <h1><a href="index.php">Home</a></h1>
                        </div>
                        <?php
                            if ($pollDB['active'] == 1) {
                        ?>
                                <div class="row" style="padding-top:2rem;">
                                    <?php
                                        foreach ($skins as $key => $skin) {
                                            $skin = $db->getSkin($skin['skin']);
                                            $p = ($pollID * 42) / 32;
                                    ?>
                                    
                                            <div class="text-center col bg-dark " style="margin:2rem; border-radius: 10px;">
                                                <h2 style="padding-top:2rem">
                                                    <?php
                                                        echo $skin['name'];
                                                        $p = ($pollID * 42) / 32;
                                                        $s = ($skin['skin_id'] * 4) / 6;
                                                    ?>
                                                </h2>
                                                <?php //include_once('components/skinPreviewImage.php'); ?>
                                                <br>
                                          
                                                <div>
                                                    <?php include('components/skinPreviewMini.php'); ?>
                                                    <!-- <iframe id="3dpreview_mini" src="<?php echo "3dpreview_mini/index.php?img=" .  $skin['skin_id']; ?>" width="300px" height="300px"></iframe> -->
                                                </div>
                                              
                                                <input id="previewID<?php echo $skin['skin_id']; ?>" type=hidden value="<?php echo $skin['skin_id']; ?>">
                                                <a role="button" href="poll.php?p=<?php echo $p; ?>&prev=<?php echo $skin['skin_id']; ?>" class="badge btn-primary">
                                                    3D Preview
                                                </a>
                                                
                                                <br><br>
                                                <h2>
                                                    <a 
                                                        style="margin-top:1rem;"
                                                        href="api/submitVote.php?p=<?php echo $p; ?>&s=<?php echo $p; ?>" role="button"
                                                        class="btn btn-success"
                                                        id="<?php echo $skin['skin_id']; ?>"
                                                        name="<?php echo $skin['skin_id']; ?>"
                                                    >
                                                        Vote
                                                    </a>
                                                </h2>
                                            </div>

                                            <?php
                                                if ($key != sizeof($skins) - 1) {
                                            ?>
                                                    <div class="text-center col-md-1" style="margin:2rem; margin-top:16%;">
                                                        <h1>vs</h1>
                                                    </div>

                                            <?php
                                                }
                                            ?>
                                    <?php
                                        }
                                    ?>
                                </div>
                        <?php
                            }
                            if ($pollDB['active'] == 2) {
                        ?>
                                <script>
                                    $( document ).ready(function() {
                            
                                        const ctx = document.getElementById('barChart').getContext('2d');
                                        const myChart = new Chart(ctx, {
                                            type: 'bar',
                                            data: {
                                                labels: [<?php
                                                    foreach ($skins as $key => $skin) {
                                                        $skin = $db->getSkin($skin['skin']);
                                                        echo '"'.$skin['name'].'"';
                                                        if ($key != sizeof($skins) - 1) {
                                                            echo ",";
                                                        }
                                                    }
                                                ?>],
                                                datasets: [{
                                                    label: '# of Votes',
                                                    data: [<?php
                                                        foreach ($skins as $key => $skin) {
                                                            $votes = $db->getVotes($skin['skin']);
                                                            echo $votes['num_votes'];
                                                            if ($key != sizeof($skins) - 1) {
                                                                echo ",";
                                                            }
                                                        }
                                                    ?>],
                                                    backgroundColor: [
                                                        'rgba(255, 99, 132, 0.2)',
                                                        'rgba(54, 162, 235, 0.2)',
                                                        'rgba(255, 206, 86, 0.2)',
                                                        'rgba(75, 192, 192, 0.2)',
                                                        'rgba(153, 102, 255, 0.2)',
                                                        'rgba(255, 159, 64, 0.2)'
                                                    ],
                                                    borderColor: [
                                                        'rgba(255, 99, 132, 1)',
                                                        'rgba(54, 162, 235, 1)',
                                                        'rgba(255, 206, 86, 1)',
                                                        'rgba(75, 192, 192, 1)',
                                                        'rgba(153, 102, 255, 1)',
                                                        'rgba(255, 159, 64, 1)'
                                                    ],
                                                    borderWidth: 1
                                                }]
                                            },
                                            options: {
                                                scales: {
                                                    y: {
                                                        beginAtZero: true,
                                                        ticks: {
                                                            precision: 0
                                                        }
                                                    }
                                                },
                                                maintainAspectRatio: false,
                                            }
                                        });
                                    });
                                </script>
                                <div class="row" style="padding-top:2rem;">
                                    <div class="text-center col card bg-dark" style="margin:2rem;">
                                        <div>
                                            <h1><a href="index.php">Home</a></h1>
                                        </div>
                                        <div class="row">
                                            <?php
                                                foreach ($skins as $key => $skin) {
                                                    $skin = $db->getSkin($skin['skin']);
                                            ?>
                                                    <div class="text-center col" style="margin:0.5rem;">
                                                        <img
                                                            style="padding:1rem; height:80%; width:60%"
                                                            src="<?php echo $skin['path']; ?>"
                                                            alt="Card image cap"
                                                        >
                                                
                                                        <h4>
                                                            <?php
                                                                echo $skin['name'];
                                                                $p = ($pollID * 42) / 32;
                                                                $s = ($skin['skin_id'] * 4) / 6;
                                                            ?>
                                                            <br>
                                                        </h4>
                                                        <?php
                                                            echo "Made by: " . $skin['author'];
                                                        ?>
                                                    </div>
                                            <?php
                                                }
                                            ?>
                                        </div>
                                        <div class="row">
                                            <div class="chart-container col" style="position: relative; height:30rem; width:100%; background: white;">
                                                <canvas id="barChart"></canvas>
                                            </div>
                                        </div>
                                        <br><br>
                                    </div>
                                </div>
                        <?php
                            }

                            if (isset($_REQUEST['prev'])) {
                                include_once('components/skinPreviewFull.php');
                            }
                        ?>
                </div>
            </div>
        </main>
    </body>
</html>