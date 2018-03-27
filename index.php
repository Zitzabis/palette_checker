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
                    <div class="col-8 offset-2">
                        <div class="logoCaption row">
                            <div class="text-center col">
                                <font size="10" class="writtenFont">Minecraft Skin Palette Checker</font>
                                <h5>This is a tool that can be used for checking Minecraft skins<br>to make sure they meet palette requirements.<br><br>Use the following fields to input your data.</h5>
                            </div>
                        </div>
                        <div class="row" style="padding-top:2rem;">
                            <div class="text-center col">
                                <h3>Palette</h3>
                                You can either submit each color individually or as a list<br><code>572F4E, 573E69, 4B5F901</code>
                                <br>
                                Leading hastags are optional.
                                <h1>
                                    <span class="badge bg-dark">
                                        <input class="form-control" type="text" id="hexcode" placeholder="#hexcode">
                                        <span style="cursor: pointer;" onclick="addColor()">+</span>
                                    </span>
                                </h1>
                                <h1 id="colors">

                                </h1>
                            </div>
                        </div>
                        <div class="row" style="padding-top:2rem;">
                            <div class="text-center col">
                                <h3>URL</h3>
                                Please make sure this is a direct URL to the file.
                                <div>
                                    <input style="width: 100%; height: 4rem;" id="url" class="form-control form-control-lg" type="text">
                                </div>
                                <br>
                                <button type="button" class="btn btn-outline-light btn-lg btn-block" style="cursor: pointer;" onclick="matcher()">Check Skin</button>
                                <br>
                                <h1 id="status"></h1>
                                <a href="https://github.com/Zitzabis/palette_checker"><img src="img/github.png"></a>
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