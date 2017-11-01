<?php
    /*设置时区*/
date_default_timezone_set('PRC');
    /*连接数据库*/
require 'database.php';

//query语句 
$deptCountSqlTen="SELECT dept,count(dept) as deptcnt FROM dbo.RTPass WHERE datediff(day,VisitTime,getdate()) = 0 and dept !=N'未知部门' GROUP BY dept"; 
$deptCountSqlTen = iconv("utf-8", "gbk", $deptCountSqlTen);
$a = mssql_query($deptCountSqlTen);
while($aa = mssql_fetch_assoc($a))
{   $aastr['dept'] = iconv('GBK','UTF-8',$aa['dept']);
    $aastr['deptcnt'] = $aa['deptcnt'];
    $deptTen[] = $aastr;
} 
$deptArrTen = array();
$deptCountArrTen = array();
$deptPercentTen = array();
$deptPercentArrTen = array();
if (!empty($deptTen)) {
    foreach ($deptTen as $v) {
        $xueyuanTen = '';
        $xueyuanTen = substr($v['dept'], -6);
        if ($xueyuanTen == '学院') {
            $deptArrTen[] = $v['dept'];
            $deptCountArrTen[] = $v['deptcnt'];
            $deptPercentTen['name'] = $v['dept'];
            $deptPercentTen['value'] = $v['deptcnt'];
            $deptPercentArrTen[] = $deptPercentTen;
        }
    }
}

    // sqlsrv_free_stmt($deptCountSqlTen);
    // sqlsrv_close($db);

echo json_encode($deptPercentArrTen);
