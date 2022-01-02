<?php
    if (session_id() == ''){
        session_start();
    }
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    include_once("scripts/init.php");
    include_once("scripts/dbStartup.php");

    if (isset($_REQUEST['mode'])) {
        $mode = $_REQUEST['mode'];
    }
    else {
        $mode = null;
    }
?>

<!DOCTYPE html>
<html>
    <?php
        include_once("components/head.php");
        include_once("components/scripts.php");
    ?>
    <body>
   
            <div class="container-fluid">
                <div class="row">
                    <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
                    <div class="position-sticky pt-3">
                        <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link <?php if ($mode == null) { echo "active";} ?>" aria-current="page" href="admin.php">
                            <span data-feather="home"></span>
                            Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                            <span data-feather="file"></span>
                            Contests
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php if ($mode == "poll" || $mode == "singlePoll") { echo "active";} ?>" href="admin.php?mode=poll">
                            <span data-feather="shopping-cart"></span>
                            Polls
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                            <span data-feather="users"></span>
                            Skins
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                            <span data-feather="bar-chart-2"></span>
                            Vote Log
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                            <span data-feather="layers"></span>
                            Integrations
                            </a>
                        </li>
                        </ul>
                    </div>
                    </nav>

                    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                        <?php
                            if ($mode == "poll") {
                                include_once("components/admin/poll.php");
                            }
                            elseif ($mode == "singlePoll") {
                                include_once("components/admin/singlePoll.php");
                            }
                            else {
                                include_once("components/admin/dashboard.php");
                            }
                        ?>
                    </main>
                </div>
            </div>

    </body>
</html>