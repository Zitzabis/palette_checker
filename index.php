<!DOCTYPE html>
<html>
    <?php
        include_once("components/head.php");
        include_once("components/scripts.php");
    ?>
    <body>
        <?php include_once("components/navBarIcon.php"); ?>
        <main>
            <div class="pageContent centerContent"> 
                <?php include_once("components/nav.php"); ?>
                <div>
                    <div class="logo text-center">
                        <a href="#">
                            <img src="img/logo.png" onclick="logo()" width="100%">
                        </a>
                    </div>
                    <div class="logoCaption">
                        <h1 class="text-center">
                            <div>
                                Start Mapping
                            </div>
                        </h1>
                    </div>
                </div>
            </div>
            <?php include_once("components/granim.php"); ?>
        </main>
        <?php include_once("components/sidebar.php"); ?>
    </body>

    <?php include_once("components/granim.php"); ?>
</html>