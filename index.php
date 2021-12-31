<?php
    // error_reporting(E_ALL);
    // ini_set('display_errors', 1);

    include_once("scripts/dbStartup.php");

    session_start();
    $_SESSION['auth'] = true;
?>

<!DOCTYPE html>
<html>
    <?php
        include_once("components/head.php");
        include_once("components/scripts.php");
    ?>
    <body>
        <main>
            <div class="pageContent centerContent container-fluid">
                <div class="row align-items-center flexContentMobile" style="height: 100%;">
                    <div class="col-8 offset-2 card" id="mainContent" style="border-radius: 20px; padding:2rem">
                        <div class="logoCaption row">
                            <div class="text-center col">
                                <img src="img/title.png" class="img-fluid" alt="MC Skin Voter">
                                <br><br>
                                <h5>Welcome to MC Skin Voter.<br>This website works alongside the Planet Minecraft community to provide extended tools<br>and resources for specific contest formats.</h5>
                                <div class="row">
                                    <div class="text-center col">
                                        <a 
                                            style="margin-top:1rem;"
                                            href="submitSkin.php" role="button"
                                            class="btn btn-success"
                                        >
                                            Submit Skin
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="padding-top:2rem;">
                            <div class="text-center col">
                                <h3>Active Polls</h3>
                                
                                    <?php
                                        $polls = $db->getActivePolls();
                                        foreach ($polls as $k => $poll) {
                                            $skins = $db->getSkinsForPoll($poll['poll_id']);
                                            $p = ($poll['poll_id'] * 42) / 32;
                                    ?>
                                        <a href="poll.php?p=<?php echo $p; ?>">
                                            <span class="badge bg-dark border" style='padding: 1rem; margin: 0.3rem'>
                                            <h2>
                                                <?php
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
                                            </span>
                                        </a>
                                    <?php
                                        }
                                    ?>

                                <h1 id="colors">
                                    <!-- Color badges inserted here via JS -->
                                </h1>
                            </div>
                            <div class="text-center col">
                                <h3>Poll Results</h3>
                                
                                <?php
                                    $polls = $db->getCompletedPolls();
                                    foreach ($polls as $key => $poll) {
                                        $skins = $db->getSkinsForPoll($poll['poll_id']);
                                        $p = ($poll['poll_id'] * 42) / 32;
                                ?>
                                    <a href="poll.php?p=<?php echo $p; ?>">
                                        <span class="badge bg-dark">
                                            <h2>
                                                <?php
                                                    foreach ($skins as $key => $skin) {
                                                        $skin = $db->getSkin($skin['skin']);
                                                        echo $skin['name'];
                                                        if ($key != sizeof($skins) - 1) {
                                                            echo " vs. ";
                                                        }
                                                    }
                                                ?>
                                            </h2>
                                            <h5 id="timer" style="color: lightgreen">
                                                <?php echo $db->getPoll($poll['poll_id'])['end_date'] . " EST"; ?>
                                            </h5>
                                        </span>
                                    </a>
                                <?php
                                    }
                                ?>
                                
                                <h1 id="colors">
                                    <!-- Color badges inserted here via JS -->
                                </h1>
                            </div>
                            <div class="text-center col">
                                <h3>Active Contests</h3>
                                <h2>
                                    <span class="badge bg-dark">
                                        PBL S2
                                    </span>
                                </h2>
                                <h1 id="colors">
                                    <!-- Color badges inserted here via JS -->
                                </h1>
                            </div>
                            <div class="text-center col">
                                <h3>Finished Contests</h3>
                                <h2>
                                    <span class="badge bg-dark">
                                        PBL S1
                                    </span>
                                </h2>
                                <h1 id="colors">
                                    <!-- Color badges inserted here via JS -->
                                </h1>
                            </div>
                        </div>
                        
                        <div class="row" style="padding-top:4rem;">
                            <div class="col">
                                <a 
                                    style="margin-top:1rem;"
                                    href="api/toggleBackground.php?u=<?php $protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://"; echo $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];; ?>" role="button"
                                    class="badge bg-info"
                                >
                                    <?php
                                        if (session_id() == ''){
                                            session_start();
                                        }
                                        if (!isset($_SESSION['animatedBackground'])) {
                                            $_SESSION['animatedBackground'] = true;
                                        }
                                        if (isset($_SESSION['animatedBackground'])) {
                                            if ($_SESSION['animatedBackground'] == true) {
                                        
                                    ?>
                                                <font size="2">Disable Animated Background</font>
                                    <?php
                                            }
                                            else {
                                    ?>
                                                <font size="2">Enable Animated Background</font>
                                    <?php
                                            }
                                        }
                                    ?>
                                </a>
                                <div id="paletteCredit"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php include_once("components/granim.php"); ?>
        </main>
    </body>
    <?php include_once("components/granim.php"); ?>
</html>