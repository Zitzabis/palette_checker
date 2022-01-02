<?php
if (session_id() == ''){
    session_start();
}
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    include_once("scripts/init.php");
    include_once("scripts/dbStartup.php");
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
                            <a class="nav-link active" aria-current="page" href="admin.php">
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
                            <a class="nav-link" href="#">
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
                                    foreach ($polls as $key => $poll) {
                                        $skins = $db->getSkinsForPoll($poll['poll_id']);
                                        $p = ($poll['poll_id'] * 42) / 32;
                                ?>
                                    <tr>
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
                                        <td>40 minutes</td>
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
                    </main>
                </div>
            </div>

    </body>
</html>