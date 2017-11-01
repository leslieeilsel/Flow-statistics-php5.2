<?php
header("Content-type: text/html; charset=utf-8");
/*设置时区*/
date_default_timezone_set('PRC');

/*连接数据库*/
require 'database.php';
require 'count.php';
//query语句 
$query="SELECT dept,count(dept) as deptcnt FROM dbo.RTPass WHERE datediff(day,VisitTime,getdate()) = 0 and dept !=N'未知部门' GROUP BY dept ORDER BY deptcnt ASC"; 
$query = iconv("utf-8", "gbk", $query);
$a = mssql_query($query);
while($temp = mssql_fetch_assoc($a))
{   $tempstr['dept'] = iconv('GBK','UTF-8',$temp['dept']);
    $tempstr['deptcnt'] = $temp['deptcnt'];
    $dept[] = $tempstr;
} 


/*学院实时来访人数*/
// $deptCountSql = $db->query("SELECT dept,count(dept) as deptcnt FROM dbo.chart WHERE datediff(day,VisitTime,getdate()) = 0 and dept !=N'未知部门' GROUP BY dept ORDER BY deptcnt ASC"); //排序 ORDER BY deptcnt ASC
// $dept = $deptCountSql->fetchAll(PDO::FETCH_ASSOC);
$deptArr = array();
$deptCountArr = array();
$deptPercent = array();
$deptPercentArr = array();
if ($dept !== false) {
    foreach ($dept as $v) {
        $xueyuan = '';
        $xueyuan = substr($v['dept'], -6);
        if ($xueyuan == '学院') {
            $deptArr[] = $v['dept'];
            $deptCountArr[] = $v['deptcnt'];
            $deptPercent['name'] = $v['dept'];
            $deptPercent['value'] = $v['deptcnt'];
            $deptPercentArr[] = $deptPercent;
        }
    }
}
// $aaa =  json_encode($deptArr);
// $bbb =  json_encode($deptPercentArr);


echo json_encode(array('deptArr'=>$deptArr,'deptPercentArr'=>$deptPercentArr,'countAll'=>$countAll, 'countToday'=>$countToday));
// echo '333';
