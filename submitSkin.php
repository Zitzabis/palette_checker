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
                                <h1>Instructions:</h1>
                                <h5>
                                    Use the below section to upload and submit a skin to be used in a poll.
                                    <br><br>
                                    If you were provided a poll key, please enter it in the "Poll Key" field.
                                </h5>
                            </div>
                        </div>

                        <form action="api/submitSkin.php" method="post" enctype="multipart/form-data">
                            <div class="row" style="padding-top:2rem;">
                                
                                    <div class="text-center col">
                                        <div class="form-group">
                                            <label for="inputUsername">PMC Username</label>
                                            <input type="text" class="form-control" name="inputUsername" id="inputUsername" aria-describedby="inputUsername" placeholder="Enter username">
                                            <small id="inputUsername" class="form-text text-muted">This will be hidden until the poll ends.</small>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputSkinName">Skin Name</label>
                                            <input type="text" class="form-control" name="inputSkinName" id="inputSkinName" aria-describedby="inputSkinName" placeholder="Enter skin name">
                                            <small id="inputSkinName" class="form-text text-muted">This will be publically displayed. Please use the same name as you intend to use on PMC.</small>
                                        </div>
                                        <div class="form-group">
                                            <label for="skinFile" class="form-label">Skin File Upload</label>
                                            <input class="form-control" name="skinFile" type="file" id="skinFile">
                                        </div>
                                        <br>
                                    </div>
                                    <div class="text-center col">
                                        <div class="form-group">
                                            <label for="inputPollKey">Poll Key</label>
                                            <input type="text" name="inputPollKey" class="form-control" id="inputPollKey" aria-describedby="inputPollKey" placeholder="Enter poll key" maxlength = "15">
                                            <small id="inputPollKey" class="form-text text-muted">If you are the first person to create the poll, select the "Create Poll" option before pressing Submit. You may set a custom poll key. If you do not, an automatic one will be generated and provided to you.</small>
                                        </div>
                                        <br>
                                        <div class="form-group form-check">
                                            <input type="checkbox" id="inputPollKeyCreate" name="inputPollKeyCreate"> Create New Poll
                                        </div>
                                        <br>
                                        
                                    </div>
                                
                            </div>
                            <div class="row" style="padding-top:4rem;">
                                <div class="col text-center">
                                    <button type="submit" class="btn btn-success">Submit</button>
                                </div>
                            </div>
                        </form>
                        
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