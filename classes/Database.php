<?php
    class Database {
        private $mysqli;
        public $error;
        function __construct($servername, $username, $password) {
            $this->mysqli = new mysqli($servername, $username, $password);
            if ($this->mysqli->connect_error) {
                $this->error = "Connection failed: " . $this->mysqli->connect_error;
                return false;
            }
        }

        function closeConn() {
            $this->mysqli->close();
        }

        #########
        # Polls
        #########
        function getPoll($id) {
            $query = "SELECT * FROM pmc_voter.poll as p WHERE p.poll_id = ?";

            $stmt = $this->mysqli->prepare($query); 
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result(); // get the mysqli result
            $data = $result->fetch_all(MYSQLI_ASSOC);
            return $data[0];
        }

        function getActivePolls() {
            $sql = "SELECT p.poll_id, p.active, p.start_date, p.end_date FROM pmc_voter.poll as p WHERE p.active = 1";

            $result = $this->mysqli->query($sql);
            for ($return = array (); $row = $result->fetch_assoc(); $return[] = $row);
            return $return;
        }

        function getCompletedPolls() {
            $sql = "SELECT p.poll_id, p.active, p.start_date, p.end_date FROM pmc_voter.poll as p WHERE p.active = 2";

            $result = $this->mysqli->query($sql);
            for ($return = array (); $row = $result->fetch_assoc(); $return[] = $row);
            return $return;
        }

        function createPoll($id) {
            $query = "INSERT INTO pmc_voter.poll(`active`, `start_date`, `end_date`, `poll_key`) VALUES (1, now(), now() + interval 2 day, ?)";

            $stmt = $this->mysqli->prepare($query); 
            $stmt->bind_param("s", $id);
            $stmt->execute();
        }

        #########
        # Skins
        #########
        function getSkin($id) {
            $query = "SELECT * FROM pmc_voter.skin as s WHERE s.skin_id = ?";

            $stmt = $this->mysqli->prepare($query); 
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result(); // get the mysqli result
            $data = $result->fetch_all(MYSQLI_ASSOC);
            return $data[0];
        }

        function getSkinsForPoll($id) {
            $query = "SELECT * FROM pmc_voter.skin_poll as sp WHERE sp.poll = ?";

            $stmt = $this->mysqli->prepare($query); 
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result(); // get the mysqli result
            $data = $result->fetch_all(MYSQLI_ASSOC);
            return $data;
        }

        #########
        # Votes
        #########
        function recordVote($skinID, $ip, $poll) {
            $query = "INSERT INTO pmc_voter.vote(skin, ip, poll) VALUES (?, ?, ?)";

            $stmt = $this->mysqli->prepare($query); 
            $stmt->bind_param("isi", $skinID, $ip, $poll);
            $stmt->execute();
        }

        function getVotes($skinID) {
            $query = "SELECT COUNT(*) as num_votes FROM pmc_voter.vote as v WHERE v.skin = ?";

            $stmt = $this->mysqli->prepare($query); 
            $stmt->bind_param("i", $skinID);
            $stmt->execute();
            $result = $stmt->get_result(); // get the mysqli result
            $data = $result->fetch_all(MYSQLI_ASSOC);
            return $data[0];
        }

        function getPollByKey($pollKey) {
            $query = "SELECT * FROM pmc_voter.poll as p WHERE p.poll_key = ?";

            $stmt = $this->mysqli->prepare($query); 
            $stmt->bind_param("s", $pollKey);
            $stmt->execute();
            $result = $stmt->get_result(); // get the mysqli result
            $data = $result->fetch_all(MYSQLI_ASSOC);
            return $data[0];
        }

        function insertSkin($path, $author, $title) {
            $query = "INSERT INTO pmc_voter.skin(path, author, name) VALUES (?, ?, ?)";

            $stmt = $this->mysqli->prepare($query); 
            $stmt->bind_param("sss", $path, $author, $title);
            $stmt->execute();

            $query = "SELECT * FROM pmc_voter.skin as s WHERE s.path = ?";

            $stmt = $this->mysqli->prepare($query); 
            $stmt->bind_param("s", $path);
            $stmt->execute();
            $result = $stmt->get_result(); // get the mysqli result
            $data = $result->fetch_all(MYSQLI_ASSOC);
            return $data[0]['skin_id'];
        }

        function linkSkinToPoll($poll, $skinID) {
            $query = "INSERT INTO pmc_voter.skin_poll(`poll`, `skin`) VALUES (?, ?)";

            $stmt = $this->mysqli->prepare($query); 
            $stmt->bind_param("ii", $poll, $skinID);
            $stmt->execute();
        }
    }
?>