<?php
    require_once "catchWeb.php";
    require_once "data.php";

    $sportEvents = new sportEvents();
    $sportEvents->deleteSportEvents();
    $sportEvents->getData($array);
    $sportEvents->setRedis();
    class sportEvents
    {
        public $db;

        /**
         * 建立資料庫連線
         */
        public function __construct()
        {
            $dbConnect = 'mysql:host=localhost;dbname=sports;port=3306';
            $dbUser = 'root';
            $dbPw = '';

            // 連接資料庫伺服器
            $this->db = new PDO($dbConnect, $dbUser, $dbPw);
            $this->db->exec("set names utf8");
        }

        /**
         * 關閉資料庫連線
         */
        public function __destruct()
        {
            $this->db = null;
        }

        /**
         * 擷取資料
         */
        public function getData($array){
            for($i = 0; $i< count($array); $i++){
                //時間
                $date = $array[$i][1];
                //聯賽
                $league = $array[$i][2];

                //賽事(隊伍1)
                $team1 = $array[$i][5];
                //賽事(隊伍2)
                $team2 = $array[$i][6];

                //全場讓球，C=>下讓上，H=>上讓下
                $overallConcede = $array[$i][7];
                //全場讓球資料(隊伍1)
                $overallConcedeTeam1 = $array[$i][8];
                //全場讓球資料(隊伍2)
                $overallConcedeTeam2 = $array[$i][9];
                $overallConcedeAll = $array[$i][10];

                //全場大小資料規則(隊伍1) O=>大，U=>小
                $overallSizeTeam1OU = $array[$i][11];
                //全場大小資料規則(隊伍2) O=>大，U=>小
                $overallSizeTeam2OU = $array[$i][12];
                //全場大小資料賠率(隊伍1)
                $overallSizeOddsTeam1 = $array[$i][13];
                //全場大小資料賠率(隊伍2)
                $overallSizeOddsTeam2 = $array[$i][14];

                //全場獨贏資料(隊伍1)
                $orverallWinTeam1 = $array[$i][15];
                //全場獨贏資料(隊伍2)
                $overallWinTeam2 = $array[$i][16];
                $overallWinAll = $array[$i][17];

                //單雙
                $SDTeam1 = $array[$i][18];
                $SDTeam2 = $array[$i][19];
                $SDOddsTeam1 = $array[$i][20];
                $SDOddsTeam2 = $array[$i][21];

                //全場讓球，C=>下讓上，H=>上讓下
                $halfConcede = $array[$i][23];
                // 0/0.5
                $halfConcedeRule = $array[$i][24];
                //半場讓球資料(隊伍1)
                $halfConcedeTeam1 = $array[$i][25];
                //半場讓球資料(隊伍2)
                $halfConcedeTeam2 = $array[$i][26];

                //半場大小資料規則(隊伍1) O=>大，U=>小
                $halfSizeTeam1OU = $array[$i][27];
                //半場大小資料規則(隊伍2) O=>大，U=>小
                $halfSizeTeam2OU = $array[$i][28];
                //半場大小資料賠率(隊伍1)
                $halfSizeOddsTeam1 = $array[$i][29];
                //半場大小資料賠率(隊伍2)
                $halfSizeOddsTeam2 = $array[$i][30];

                //半場獨贏資料(隊伍1)
                $halfWinTeam1 = $array[$i][31];
                //半場獨贏資料(隊伍2)
                $halfWinTeam2 = $array[$i][32];
                $halfWinAll = $array[$i][33];

                $this->insertSportEvents($date, $league, $team1, $team2, $overallConcede, $overallConcedeTeam1, $overallConcedeTeam2, $overallConcedeAll, $overallSizeTeam1OU, $overallSizeTeam2OU, $overallSizeOddsTeam1, $overallSizeOddsTeam2, $orverallWinTeam1, $overallWinTeam2, $overallWinAll, $SDTeam1, $SDTeam2, $SDOddsTeam1, $SDOddsTeam2, $halfConcede, $halfConcedeRule, $halfConcedeTeam1, $halfConcedeTeam2, $halfSizeTeam1OU, $halfSizeTeam2OU, $halfSizeOddsTeam1, $halfSizeOddsTeam2, $halfWinTeam1, $halfWinTeam2, $halfWinAll);
            }
        }

        /**
         * 先行清空資料庫中的資料
         */
        public function deleteSportEvents()
        {
            $sql = 'DELETE FROM `sport_events`';
            $result = $this->db->prepare($sql);
            $result->execute();
        }

        /**
         * 存入資料庫
         */
        public function insertSportEvents($date, $league, $team1, $team2, $overallConcede, $overallConcedeTeam1, $overallConcedeTeam2, $overallConcedeAll, $overallSizeTeam1OU, $overallSizeTeam2OU, $overallSizeOddsTeam1, $overallSizeOddsTeam2, $orverallWinTeam1, $overallWinTeam2, $overallWinAll, $SDTeam1, $SDTeam2, $SDOddsTeam1, $SDOddsTeam2, $halfConcede, $halfConcedeRule, $halfConcedeTeam1, $halfConcedeTeam2, $halfSizeTeam1OU, $halfSizeTeam2OU, $halfSizeOddsTeam1, $halfSizeOddsTeam2, $halfWinTeam1, $halfWinTeam2, $halfWinAll)
        {
            $sql = 'INSERT INTO `sport_events`
                    (`date`, `league`, `team1`, `team2`, `overallConcede`, `overallConcedeTeam1`, `overallConcedeTeam2`, `overallConcedeAll`, `overallSizeTeam1OU`, `overallSizeTeam2OU`, `overallSizeOddsTeam1`, `overallSizeOddsTeam2`, `orverallWinTeam1`, `overallWinTeam2`, `overallWinAll`, `SDTeam1`, `SDTeam2`, `SDOddsTeam1`, `SDOddsTeam2`, `halfConcede`, `halfConcedeRule`, `halfConcedeTeam1`, `halfConcedeTeam2`, `halfSizeTeam1OU`, `halfSizeTeam2OU`, `halfSizeOddsTeam1`, `halfSizeOddsTeam2`, `halfWinTeam1`, `halfWinTeam2`, `halfWinAll`)
                    VALUES
                    (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
            $result = $this->db->prepare($sql);
            $result->execute(array($date, $league, $team1, $team2, $overallConcede, $overallConcedeTeam1, $overallConcedeTeam2, $overallConcedeAll, $overallSizeTeam1OU, $overallSizeTeam2OU, $overallSizeOddsTeam1, $overallSizeOddsTeam2, $orverallWinTeam1, $overallWinTeam2, $overallWinAll, $SDTeam1, $SDTeam2, $SDOddsTeam1, $SDOddsTeam2, $halfConcede, $halfConcedeRule, $halfConcedeTeam1, $halfConcedeTeam2, $halfSizeTeam1OU, $halfSizeTeam2OU, $halfSizeOddsTeam1, $halfSizeOddsTeam2, $halfWinTeam1, $halfWinTeam2, $halfWinAll));
        }

        /**
         * 將資料存入redis
         */
        public function setRedis()
        {
            //抓賽事資料
            $sql = 'SELECT * FROM `sport_events`';
            $result = $this->db->prepare($sql);
            $result->execute();
            $data = $result->fetchAll(PDO::FETCH_ASSOC);

            //將資料丟給redis
	        $redis = new Redis();
        	$redis->connect('127.0.0.1', 6379);
            $redis->set("sport_events", json_encode($data, JSON_UNESCAPED_UNICODE));
            $info = $redis->get("sport_events");
            $array = json_decode($info);

            echo "共 ".count($array)."筆賽事<hr>";
            echo $info;
        }
    }