<!DOCTYPE html>
<html>
    <?php
        include_once("components/head.php");
        include_once("components/scripts.php");
    ?>
    <body>
        <?php include_once("components/navBarIcon.php"); ?>
        <main>
            <div class="pageContent centerContent container-fluid"> 
                <?php include_once("components/nav.php"); ?>
                <div class="row align-items-center" style="height: 100%">
                    <div class="col-8 offset-2">
                        <div class="logoCaption text-center">
                            <h1>Minecraft Skin Palette Checker</h1>
                            This is a tool that can be used for checking Minecraft skins to make sure they meet palette requirements.
                            <h3 class="text-center">
                                <div>
                                    URL
                                    <input style="width: 100%; height: 100px;" class="form-control form-control-lg" type="text">
                                </div>
                            </h3>
                        </div>
                    </div>
                </div>
            </div>
            <?php include_once("components/granim.php"); ?>
        </main>
        <?php include_once("components/sidebar.php"); ?>
    </body>

    <?php include_once("components/granim.php"); ?>
</html>