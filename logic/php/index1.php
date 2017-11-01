<?php
    /*设置时区*/
    date_default_timezone_set('PRC');
    /*连接数据库*/
    require 'database.php';
    $db = new PDO($dbName, $dbUser, $dbPassword);

    /*当日分时段人数统计*/
    $years = ["今日访问人数", "7:00-9:00", "9:00-11:00", "11:00-13:00", "13:00-15:00", "15:00-17:00", "17:00-19:00", "19:00-21:00", "21:00-23:00"];
    $dateTimess = [
        ['07:00:00.000','08:59:59.000'],
        ['09:00:00.000','10:59:59.000'],
        ['11:00:00.000','12:59:59.000'],
        ['13:00:00.000','14:59:59.000'],
        ['15:00:00.000','16:59:59.000'],
        ['17:00:00.000','18:59:59.000'],
        ['19:00:00.000','20:59:59.000'],
        ['21:00:00.000','22:59:59.000']
    ];
    $now = date('H:i:s');
    foreach ($dateTimess as $key => $value) {
        if ($now>$value[0] && $now<$value[1]) {
            $kkk = $key;
            array_splice($years, $kkk+2, 9-($kkk+2));
        }
    }
    $dateTimes = [
        ['07:00:00.000','22:59:59.000'],
        ['07:00:00.000','08:59:59.000'],
        ['09:00:00.000','10:59:59.000'],
        ['11:00:00.000','12:59:59.000'],
        ['13:00:00.000','14:59:59.000'],
        ['15:00:00.000','16:59:59.000'],
        ['17:00:00.000','18:59:59.000'],
        ['19:00:00.000','20:59:59.000'],
        ['21:00:00.000','22:59:59.000']
    ];
    $hahaha = [];
    // $enenen = [];
    // $xline = [];
    $deptIndex = ['材料学院','电子信息学院','动力与能源学院','管理学院','航海学院','航空学院','航天学院','机电学院','计算机学院','教育实验学院','理学院','力学与土木建筑学院','人文与经法学院','软件与微电子学院','生命学院','外国语学院','自动化学院'];
    $zero = [0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0];
    foreach($dateTimes as $key=>$datetime){
        $period = $db->query("SELECT dept,count(dept) as deptcnt FROM dbo.chart WHERE VisitTime BETWEEN '".date('Y-m-d')." ".$datetime[0]."' AND '".date('Y-m-d')." ".$datetime[1]."'and dept !=N'未知部门' GROUP BY dept");
        // $period = $db->query("SELECT dept,count(dept) as deptcnt FROM [dbo].[RTPass] WHERE VisitTime BETWEEN '2017-06-22 ".$datetime[0]."' AND '2017-06-22 ".$datetime[1]."'and dept !='未知部门' GROUP BY dept");
        $periodDatas = $period->fetchAll(PDO::FETCH_ASSOC);
        if(!empty($periodDatas)) {
            foreach($periodDatas as $k=>$periodData){
                $xueyuan = '';
                $xueyuan = substr($periodData['dept'], -6);
                if ($xueyuan == '学院') {
                    // $xline[] = $periodData['dept'];
                    $index = array_search($periodData['dept'], $deptIndex);
                    // $periodDatas[$index] = $periodDatas[$k]['deptcnt'];
                    array_splice($zero, $index, 1, $periodDatas[$k]['deptcnt']);

                }else{
                    unset($periodDatas[$k]);
                }
            }
            // $hahaha[$key] = array_values($periodDatas);
            $hahaha[$key] = $zero;     
            // $enenen[$key] = $xline;
            // unset($xline);
        }
    }

    // sqlsrv_free_stmt($period);
    // sqlsrv_close($db);
    // echo json_encode($enenen);
